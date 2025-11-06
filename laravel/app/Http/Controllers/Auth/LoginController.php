<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends Controller
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user and verify password
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !\Hash::check($credentials['password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput();
        }

        // Store user ID in session for TOTP verification
        session(['login_user_id' => $user->id]);

        // Redirect to TOTP verification
        return redirect()->route('auth.verify-totp')
            ->with('success', 'Please enter your TOTP code.');
    }

    public function showTotpVerification()
    {
        if (!session('login_user_id')) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please log in again.');
        }

        return view('auth.verify-totp');
    }

    public function verifyTotp(Request $request)
    {
        $request->validate([
            'totp_code' => 'required|digits:6',
        ]);

        $userId = session('login_user_id');
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please log in again.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User not found.');
        }

        // Verify TOTP code
        if (!$this->google2fa->verifyKey($user->totp_secret, $request->totp_code)) {
            return redirect()->back()
                ->withErrors(['totp_code' => 'Invalid TOTP code.']);
        }

        // Log in the user
        Auth::login($user, $request->filled('remember'));
        session()->forget('login_user_id');

        return redirect()->intended(route('profile.index'))
            ->with('success', 'Logged in successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Logged out successfully.');
    }
}
