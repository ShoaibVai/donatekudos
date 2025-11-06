<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class ForgotPasswordController extends Controller
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'totp_code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'No account found with this email.']);
        }

        // Verify TOTP code using the user's current secret
        if (!$this->google2fa->verifyKey($user->totp_secret, $request->totp_code)) {
            return redirect()->back()
                ->withErrors(['totp_code' => 'Invalid TOTP code. Please check your authenticator app and try again.'])
                ->withInput($request->only('email'));
        }

        // Store user ID and show password reset form
        session(['reset_user_id' => $user->id]);

        return redirect()->route('password.reset.form')
            ->with('success', 'TOTP verification successful. Please enter your new password.');
    }

    public function showResetForm()
    {
        if (!session('reset_user_id')) {
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please try again.');
        }

        return view('auth.passwords.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userId = session('reset_user_id');
        if (!$userId) {
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please try again.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'User not found.');
        }

        // Generate new TOTP secret
        $newSecret = $this->google2fa->generateSecretKey();

        // Update password and TOTP secret
        $user->update([
            'password' => \Hash::make($request->password),
            'totp_secret' => $newSecret,
        ]);

        // Generate QR code for new secret
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode(
            $this->google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $newSecret
            )
        );

        session()->forget('reset_user_id');
        session(['totp_secret' => $newSecret, 'qr_code_url' => $qrCodeUrl]);

        return redirect()->route('password.reset.done')
            ->with('success', 'Password reset successfully! Please set up your authenticator app with the new secret.');
    }

    public function showResetDone()
    {
        $secret = session('totp_secret');
        $qrCodeUrl = session('qr_code_url');

        if (!$secret || !$qrCodeUrl) {
            return redirect()->route('login');
        }

        return view('auth.passwords.reset-done', compact('secret', 'qrCodeUrl'));
    }
}
