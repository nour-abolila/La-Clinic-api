<?php

namespace App\Services\Auth;

use App\Models\OtpVerification;
use App\Models\User;
use App\Services\Auth\OtpService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct(protected OtpService $otpService) {}

    public function register(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
        ]);

        return $user;
    }

    // لازم افعل الايميل قبل ما اقدر اسجل دخول
    public function verifyEmail(User $user)
    {
        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);
    }


    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        if (!$user->email_verified_at) {
            return 'email_not_verified';
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
        ];
    }


    public function logout(User $user)
    {
        $user->tokens()->delete();
        return true;
    }
}
