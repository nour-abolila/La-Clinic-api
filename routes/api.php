<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


// Authentication Routes

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/login', 'login');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'logout');
    });
});


Route::prefix('auth')->controller(PasswordController::class)->group(function () {
    Route::post('/forget-password', 'forgetPassword');
    Route::post('/verify-password', 'verifyPassword');
    Route::post('/reset-password', 'resetPassword');
    Route::post('/resend-otp', 'resendOtp');
});



// Public Routes

Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);

Route::apiResource('products', ProductController::class)
    ->only(['index', 'show']);

Route::get('/doctors', [DoctorController::class, 'index']);

Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);



// Admin Routes

Route::middleware(['auth:api', 'admin'])->group(function () {

    Route::apiResource('categories', CategoryController::class)
        ->except(['index', 'show']);

    Route::apiResource('products', ProductController::class)
        ->except(['index', 'show']);
});


Route::middleware(['auth:api', 'admin'])->controller(DoctorController::class)->group(function () {

    Route::post('/doctors', 'store');

    Route::patch('/doctors/{doctor}', 'update');

    Route::delete('/doctors/{doctor}', 'destroy');
});



// Cart Routes

Route::middleware('auth:api')->prefix('cart')->controller(CartController::class)->group(function () {

    Route::get('/', 'show');

    Route::post('/add', 'add');

    Route::delete('/remove/{productId}', 'remove');
});



// Doctor Routes

Route::middleware(['auth:api', 'doctor'])->controller(DoctorController::class)->group(function () {

    Route::get('/doctor/profile', 'myProfile');
});
