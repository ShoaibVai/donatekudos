<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SetupTotpController;

// ============================================================================
// PUBLIC ROUTES
// ============================================================================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ============================================================================
// AUTHENTICATED ROUTES (User Dashboard)
// ============================================================================

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

// ============================================================================
// AUTHENTICATION ROUTES (Guest Only)
// ============================================================================

Route::middleware('guest')->group(function () {
    // Sign Up
    Route::get('/signup', [SignUpController::class, 'show'])->name('signup');
    Route::post('/signup', [SignUpController::class, 'store'])->name('signup.store');

    // TOTP Setup during Signup
    Route::get('/setup-totp', [SetupTotpController::class, 'show'])->name('setup-totp');
    Route::post('/setup-totp', [SetupTotpController::class, 'verify'])->name('verify-totp');

    // Login
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    // Forgot Password & TOTP Verification
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot-password.store');

    Route::get('/verify-totp-forgot', [ForgotPasswordController::class, 'showVerifyTotp'])->name('verify-totp-forgot');
    Route::post('/verify-totp-forgot', [ForgotPasswordController::class, 'verifyTotp'])->name('verify-totp-forgot.store');

    // Reset Password
    Route::get('/reset-password', [ResetPasswordController::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('reset-password.store');
});
