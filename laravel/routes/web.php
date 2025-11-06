<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::prefix('auth')->group(function () {
    // Registration
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('totp-setup', [RegisterController::class, 'showTotpSetup'])->name('auth.totp-setup');
    Route::post('totp-confirm', [RegisterController::class, 'confirmTotp'])->name('auth.totp-confirm');

    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('verify-totp', [LoginController::class, 'showTotpVerification'])->name('auth.verify-totp');
    Route::post('verify-totp', [LoginController::class, 'verifyTotp']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Password Reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::get('password/reset/form', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset/confirm', [ForgotPasswordController::class, 'reset'])->name('password.reset.confirm');
    Route::get('password/reset/done', [ForgotPasswordController::class, 'showResetDone'])->name('password.reset.done');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Public Profile Routes
Route::get('profile/{username}', [ProfileController::class, 'show'])->name('profile.show');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.post');
    
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('users/{user}/export/xml', [AdminController::class, 'exportUserXml'])->name('admin.export-xml');
        Route::get('deleted-users', [AdminController::class, 'deletedUsers'])->name('admin.deleted-users');
        Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});

