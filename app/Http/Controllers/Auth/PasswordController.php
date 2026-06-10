<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Password\ForgotPasswordRequest;
use App\Http\Requests\Password\ResetPasswordRequest;
use App\Http\Requests\Password\VerifyPasswordRequest;
use App\Models\User;
use App\Services\Auth\OtpService;
use App\Services\Auth\PasswordService;
use Illuminate\Support\Facades\Hash;



class PasswordController extends Controller
{
    public function __construct(protected OtpService $otpService) {}

    private function getUserByEmail(string $email): User
    {
        return User::firstWhere('email', $email);
    }



    public function forgetPassword(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        $user = $this->getUserByEmail($data['email']);

        $otp = $this->otpService->generateOtpCode($user);

        $this->otpService->sendOtp($user, $otp);

        return ApiResponse::success('OTP sent to your email', ['user_id' => $user->id]);
    }



    public function verifyPassword(VerifyPasswordRequest $request)
    {
        $data = $request->validated();

        $user = $this->getUserByEmail($data['email']);

        if (!$this->otpService->verifyOtp($user, $request->input('otp_code'))) {
            return ApiResponse::error('Invalid or expired OTP', 422);
        }

        return ApiResponse::success('OTP verified successfully. You can now reset your password.');
    }



    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $user = $this->getUserByEmail($data['email']);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return ApiResponse::success('Password has been reset successfully.');
    }



    public function resendOtp(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        $user = $this->getUserByEmail($data['email']);

        $otp = $this->otpService->generateOtpCode($user);
        if (!$otp) {
            return ApiResponse::error(
                'Please wait 2 minutes before requesting another OTP',
                429
            );
        }

        $this->otpService->sendOtp($user, $otp);

        return ApiResponse::success('OTP resent to your email', ['user_id' => $user->id]);
    }
}
