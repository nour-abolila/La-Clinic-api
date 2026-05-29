<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Password\ForgotPasswordRequest;
use App\Http\Requests\Password\ResetPasswordRequest;
use App\Http\Requests\Password\VerifyPasswordRequest;
use App\Services\Auth\OtpService;
use App\Services\Auth\PasswordService;



class PasswordController extends Controller
{
    public function __construct(protected PasswordService $passwordService, protected OtpService $otpService) {}

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        $user = $this->passwordService->forgetPassword($request->email);

        $otp = $this->otpService->generateOtpCode($user);

        $this->otpService->sendOtp($user, $otp);

        return ApiResponse::success('OTP sent to your email', ['user_id' => $user->id]);
    }


    public function verifyPassword(VerifyPasswordRequest $request)
    {
        $user = $this->passwordService->forgetPassword($request->email); // بجيب اليوزر من ال Auth service عن طريق الايميل

        if (!$this->otpService->verifyOtp($user, $request->input('otp_code'))) {
            return ApiResponse::error('Invalid or expired OTP', 422);
        }

        return ApiResponse::success('OTP verified successfully. You can now reset your password.');
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = $this->passwordService->forgetPassword($request->email);

        $this->passwordService->resetPassword($user, $request->password);

        return ApiResponse::success('Password has been reset successfully.');
    }


    public function resendOtp(ForgotPasswordRequest $request)
    {
        $user = $this->passwordService->forgetPassword($request->email);

        $otp = $this->otpService->generateOtpcode($user);

        $this->otpService->sendOtp($user, $otp);

        return ApiResponse::success('OTP resent to your email', ['user_id' => $user->id]);
    }
}
