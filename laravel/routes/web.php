<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Public Profile Editing
    Route::get('/my-page', [PublicProfileController::class, 'edit'])->name('public_profile.edit');
    Route::put('/my-page', [PublicProfileController::class, 'update'])->name('public_profile.update')->middleware('throttle:10,1');
    Route::post('/my-page/image', [PublicProfileController::class, 'uploadImage'])->name('public_profile.image.upload')->middleware('throttle:5,1');
    Route::delete('/my-page/image/{id}', [PublicProfileController::class, 'deleteImage'])->name('public_profile.image.delete')->middleware('throttle:10,1');
});

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
});

// Auth routes must be loaded before catch-all route
require __DIR__.'/auth.php';

// Public View - Catch-all route (must be last)
Route::get('/{slug}', [PublicProfileController::class, 'show'])->name('public_profile.show');
