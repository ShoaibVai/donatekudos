<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use OTPHP\TOTP;

class ForgotPasswordController extends Controller
{
    public function show(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|string|lowercase|email|exists:users',
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();

        // Check if user has TOTP secret set up
        if (!$user->totp_secret) {
            return back()->with('error', 'This account does not have two-factor authentication set up. Please contact support.');
        }

        // Store email in session for password reset verification
        $request->session()->put('password_reset_email', $validated['email']);

        return redirect()->route('verify-totp-forgot')
            ->with('status', 'Enter the TOTP code from your authenticator app.');
    }

    public function showVerifyTotp(): View|RedirectResponse
    {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('forgot-password')
                ->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('email', $email)->firstOrFail();

        if (!$user->totp_secret) {
            return redirect()->route('forgot-password')
                ->with('error', 'Account does not have two-factor authentication.');
        }

        return view('auth.verify-totp-forgot', [
            'email' => $email,
        ]);
    }

    public function verifyTotp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'totp_code' => 'required|string|size:6',
        ]);

        $email = session('password_reset_email');
        if (!$email) {
            return redirect()->route('forgot-password')
                ->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('email', $email)->firstOrFail();

        if (!$user->totp_secret) {
            return redirect()->route('forgot-password')
                ->with('error', 'Account does not have two-factor authentication set up.');
        }

        // Verify TOTP code against user's stored secret
        $totp = TOTP::create($user->totp_secret);

        if (!$totp->verify($validated['totp_code'])) {
            return back()->withErrors([
                'totp_code' => 'The TOTP code is invalid.',
            ])->onlyInput('totp_code');
        }

        // TOTP verified, proceed to password reset
        $request->session()->put('totp_verified', true);

        return redirect()->route('reset-password')
            ->with('status', 'TOTP verified. Please enter your new password.');
    }
}
