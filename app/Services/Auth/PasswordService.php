<?php

namespace App\Services\Auth;

use App\Models\OtpVerification;
use App\Models\User;
use App\Services\Auth\OtpService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordService
{
    public function forgetPassword(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }


    public function resetPassword(User $user, string $password): void
    {
        $user->update([
            'password' => Hash::make($password),
        ]);

        $user->tokens()->delete();
    }
}
