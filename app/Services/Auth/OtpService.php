<?php

namespace App\Services\Auth;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    const OTP_EXPIRES_MINUTES = 10;
    const MAX_ATTEMPTS = 5;
    const RESEND_MINUTES = 2;

    public function generateOtpCode(User $user)
    {
        $existingOtp = OtpVerification::where('user_id', $user->id)->first();

        if (
            $existingOtp && $existingOtp->created_at->addMinutes(self::RESEND_MINUTES)->isAfter(now())
        ) {
            return null;
        }

        OtpVerification::where('user_id', $user->id)->delete();

        $otp = (string) random_int(100000, 999999);

        OtpVerification::create([
            'user_id'    => $user->id,
            'otp_code'   => ($otp),
            'expires_at' => now()->addMinutes(self::OTP_EXPIRES_MINUTES),
            'attempts'   => 0,
        ]);

        return (string) $otp;
    }


    public function sendOtp(User $user, string $otp)
    {
        Mail::to($user->email)->send(new OtpMail($user, $otp));
    }



    public function verifyOtp(User $user, string $otpCode): bool
    {
        $otp = OtpVerification::where('user_id', $user->id)->first();

        if (!$otp) {
            return false;
        }

        if ($otp->attempts >= self::MAX_ATTEMPTS) {
            $otp->delete();
            return false;
        }

        if (Carbon::now()->greaterThan($otp->expires_at)) {
            $otp->delete();
            return false;
        }

        if (($otpCode !== $otp->otp_code)) {
            $otp->increment('attempts');
            return false;
        }

        $otp->update([
            'verified_at' => now(),
        ]);

        $otp->delete();
        return true;
    }
}
