<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('success')) {
    function success(string $message = 'Success', $data = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }
}

if (!function_exists('error')) {
    function error(string $message = 'Error', $errors = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}