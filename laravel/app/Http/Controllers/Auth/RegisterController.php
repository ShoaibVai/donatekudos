<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class RegisterController extends Controller
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Generate TOTP secret
        $secret = $this->google2fa->generateSecretKey();
        $user->update(['totp_secret' => $secret]);

        // Create profile
        Profile::create(['user_id' => $user->id]);

        // Generate QR code URL
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        // Store in session and show TOTP setup page
        session(['totp_secret' => $secret, 'qr_code_url' => $qrCodeUrl, 'user_email' => $user->email]);

        return redirect()->route('auth.totp-setup')
            ->with('success', 'Registration successful! Please set up your authenticator app.');
    }

    public function showTotpSetup()
    {
        $secret = session('totp_secret');
        $qrCodeUrl = session('qr_code_url');

        if (!$secret || !$qrCodeUrl) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please register again.');
        }

        return view('auth.totp-setup', compact('secret', 'qrCodeUrl'));
    }

    public function confirmTotp(Request $request)
    {
        $request->validate([
            'totp_code' => 'required|digits:6',
        ]);

        $secret = session('totp_secret');
        $email = session('user_email');

        if (!$secret || !$email) {
            return redirect()->route('register')
                ->with('error', 'Session expired. Please register again.');
        }

        // Verify the TOTP code
        if (!$this->google2fa->verifyKey($secret, $request->totp_code)) {
            return redirect()->back()
                ->withErrors(['totp_code' => 'Invalid TOTP code.']);
        }

        // Clear session and redirect to login
        session()->forget(['totp_secret', 'qr_code_url', 'user_email']);

        return redirect()->route('login')
            ->with('success', 'TOTP setup confirmed. You can now log in.');
    }
}
