<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'otp_code' => 'required|string|size:6|regex:/^\d{6}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required',
            'user_id.integer' => 'User ID must be an integer',
            'otp_code.required' => 'OTP code is required',
            'otp_code.size' => 'OTP code must be exactly 6 digits',
            'otp_code.regex' => 'OTP code must contain only digits',
        ];
    }
}
