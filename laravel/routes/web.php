<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SetupTotpController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::view('/', 'welcome')->name('home');

// Authentication Routes
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

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot-password.store');

    // Verify TOTP for Password Reset
    Route::get('/verify-totp-forgot', [ForgotPasswordController::class, 'showVerifyTotp'])->name('verify-totp-forgot');
    Route::post('/verify-totp-forgot', [ForgotPasswordController::class, 'verifyTotp'])->name('verify-totp-forgot.store');

    // Reset Password
    Route::get('/reset-password', [ResetPasswordController::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('reset-password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/create', [ProfileController::class, 'create'])->name('create');
        Route::post('/', [ProfileController::class, 'store'])->name('store');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');

        Route::post('/gallery', [ProfileController::class, 'uploadGallery'])->name('gallery.upload');
        Route::delete('/gallery/{id}', [ProfileController::class, 'deleteGallery'])->name('gallery.delete');

        Route::post('/wallet', [ProfileController::class, 'uploadWallet'])->name('wallet.upload');
        Route::delete('/wallet/{id}', [ProfileController::class, 'deleteWallet'])->name('wallet.delete');

        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Public profile view (accessible to anyone)
Route::get('/@{profileUrl}', [ProfileController::class, 'publicProfile'])->name('profile.public');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'verifyPassword'])->name('verify');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('web')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/deleted-users', [AdminController::class, 'deletedUsers'])->name('deleted-users');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
        Route::get('/export-xml', [AdminController::class, 'exportXml'])->name('export-xml');
    });
});

