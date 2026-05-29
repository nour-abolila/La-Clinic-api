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
            'otp_code' => 'required|string|size:6|regex:/^\d{6}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'otp_code.required' => 'OTP code is required',
            'otp_code.size' => 'OTP code must be exactly 6 digits',
            'otp_code.regex' => 'OTP code must contain only digits',
        ];
    }
}
