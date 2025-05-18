<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/register',[RegisterController::class, 'create'])->name('register');
    Route::post('/register',[RegisterController::class, 'store']);

    // Login Routes
    Route::get('/login',[AuthenticateController::class, 'create'])->name('login');
    Route::post('/login',[AuthenticateController::class, 'store']);

    // Password Reset Routes
    Route::get('/forgot-password', [ResetPasswordController::class, 'requestPass'])->name('password.request');

    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->name('password.reset');

    Route::post('/reset-password',[ResetPasswordController::class, 'resetHandler'] )->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout',[AuthenticateController::class, 'destroy'])->name('logout');

    // Send Email Verification Notification
    Route::get('/email/verify',  [EmailVerificationController::class, 'notice'])->name('verification.notice');

    // Verify Email
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');

    // Resend Email Verification Notification
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

    // Password Confirmation
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');

    Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('throttle:6,1');
});

