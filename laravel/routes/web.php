<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SetupTotpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

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

// Logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    // View current user's profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    
    // Create profile
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    
    // Edit profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Gallery management
    Route::post('/profile/gallery', [ProfileController::class, 'uploadGallery'])->name('profile.gallery.upload');
    Route::delete('/profile/gallery/{id}', [ProfileController::class, 'deleteGallery'])->name('profile.gallery.delete');
    
    // Wallet QR code management
    Route::post('/profile/wallet', [ProfileController::class, 'uploadWallet'])->name('profile.wallet.upload');
    Route::delete('/profile/wallet/{id}', [ProfileController::class, 'deleteWallet'])->name('profile.wallet.delete');
    
    // Delete profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public profile view (accessible to anyone)
Route::get('/@{profileUrl}', [ProfileController::class, 'publicProfile'])->name('profile.public');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'verifyPassword'])->name('admin.verify');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('web')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/deleted-users', [AdminController::class, 'deletedUsers'])->name('admin.deleted-users');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
        Route::get('/export-xml', [AdminController::class, 'exportXml'])->name('admin.export-xml');
    });
});

