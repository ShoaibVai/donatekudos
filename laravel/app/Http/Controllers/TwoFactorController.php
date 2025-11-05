<?php

namespace App\Http\Controllers;

use App\Models\RecoveryToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    /**
     * Enable 2FA for the user
     */
    public function enable(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        // Generate new secret
        $secret = $google2fa->generateSecretKey();

        // Get QR code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('2fa.setup', [
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    /**
     * Verify and save 2FA
     */
    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:6',
            'secret' => 'required|string',
        ]);

        $google2fa = new Google2FA();
        $user = Auth::user();

        // Verify token
        if (!$google2fa->verifyKey($request->secret, $request->token)) {
            return redirect()->back()->withErrors(['token' => 'Invalid token']);
        }

        // Save or update recovery token
        RecoveryToken::updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $request->secret,
                'is_enabled' => true,
                'is_verified' => true,
            ]
        );

        return redirect()->route('profile.dashboard')->with('success', '2FA enabled successfully.');
    }

    /**
     * Disable 2FA for the user
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        // Verify password
        if (!password_verify($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The password is incorrect.']);
        }

        // Disable 2FA
        RecoveryToken::where('user_id', $user->id)->update([
            'is_enabled' => false,
        ]);

        return redirect()->route('profile.dashboard')->with('success', '2FA disabled successfully.');
    }
}
