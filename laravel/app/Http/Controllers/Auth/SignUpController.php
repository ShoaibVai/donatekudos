<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use OTPHP\TOTP;

class SignUpController extends Controller
{
    public function show(): View
    {
        return view('auth.signup');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate TOTP secret
        $totp = TOTP::create();
        $totpSecret = $totp->getSecret();

        // Create user with TOTP secret
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'totp_secret' => $totpSecret,
        ]);

        // Redirect to TOTP setup page
        session([
            'totp_setup_user_id' => $user->id,
            'totp_setup_secret' => $totpSecret,
        ]);

        return redirect()->route('setup-totp')->with('status', 'Account created! Please set up your authenticator.');
    }
}

