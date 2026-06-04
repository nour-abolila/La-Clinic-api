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
use App\Services\Auth\OtpService;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(protected AuthService $authService, protected OtpService $otpService) {}


    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            $otp = $this->otpService->generateOtpCode($user);
            $this->otpService->sendOtp($user, $otp);

            return ApiResponse::success('OTP has been sent to your email. Please verify to complete registration.');
        } catch (\Exception $e) {
            return ApiResponse::error('Registration failed');
        }
    }


    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        if (!$this->otpService->verifyOtp($user, $request->otp_code)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        $this->authService->verifyEmail($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success(
            'Email verified successfully.',
            [
                'user' => new UserResource($user),
                'access_token' => $token,
            ]
        );
    }



    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return ApiResponse::error('Invalid credentials');
        }

        if ($result === 'email_not_verified') {
            return ApiResponse::error('Email not verified. Please verify your email before logging in.');
        }

        return ApiResponse::success(
            'Login successful',
            [
                'user' => new UserResource($result['user']),
                'access_token' => $result['access_token']
            ],
        );
    }



    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());

            return ApiResponse::success('Logout successful');
        } catch (\Exception $e) {
            return ApiResponse::error('Logout failed');
        }
    }
}
