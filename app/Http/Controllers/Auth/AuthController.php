<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\PasswordReset\ForgotPasswordRequest;
use App\Http\Requests\PasswordReset\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Auth\OtpService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{

    public function __construct(protected OtpService $otpService) {}


    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $otp = $this->otpService->generateOtpCode($user);

            $this->otpService->sendOtp($user, $otp);

            return success('OTP has been sent to your email. Please verify to complete registration.');
        } catch (\Exception $e) {

            return error('Registration failed');
        }
    }


    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        if (!$this->otpService->verifyOtp($user, $request->otp_code)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);

        $token = Auth::login($user);

        return success(
            'Email verified successfully.',
            [
                'user' => new UserResource($user),
                'access_token' => $token,
            ]
        );
    }



    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return error('Invalid credentials');
        }

        if (!$user->email_verified_at) {
            return error(
                'Email not verified. Please verify your email before logging in.'
            );
        }

        if (!$token = Auth::attempt($credentials)) {
            return error('Invalid credentials');
        }

        return success(
            'Login successful',
            [
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        );
    }



    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return success('Logout successful');
    }
}
