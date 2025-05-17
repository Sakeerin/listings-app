<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/register',[RegisterController::class, 'create'])->name('register');
    Route::post('/register',[RegisterController::class, 'store']);

    // Login Routes
    Route::get('/login',[AuthenticateController::class, 'create'])->name('login');
    Route::post('/login',[AuthenticateController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout',[AuthenticateController::class, 'destroy'])->name('logout');
});

