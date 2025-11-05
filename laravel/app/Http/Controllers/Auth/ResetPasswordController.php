<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ResetPasswordController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (!session()->has('totp_verified')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please verify your identity first.');
        }

        return view('auth.reset-password');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!session()->has('totp_verified')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please verify your identity first.');
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('password_reset_email');
        $user = User::where('email', $email)->firstOrFail();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Clear session
        $request->session()->forget([
            'password_reset_email',
            'password_reset_totp_secret',
            'totp_verified',
        ]);

        return redirect()->route('login')
            ->with('status', 'Password reset successfully. Please login with your new password.');
    }
}
