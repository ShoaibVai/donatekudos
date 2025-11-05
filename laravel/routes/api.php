<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;

Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('api.profile.show');
