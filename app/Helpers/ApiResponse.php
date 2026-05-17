<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;


class ApiResponse
{
    public static function success(string $message = 'Success', $data = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
        ]);
    }

    public static function error(string $message = 'Error', $errors = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors'  => $errors,
        ]);
    }
}
