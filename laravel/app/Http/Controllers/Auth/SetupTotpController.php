<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use OTPHP\TOTP;

class SetupTotpController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $userId = session('totp_setup_user_id');
        $totpSecret = session('totp_setup_secret');

        if (!$userId || !$totpSecret) {
            return redirect()->route('login')->with('error', 'Invalid setup session.');
        }

        $user = User::find($userId);

        // Generate TOTP object with issuer and label
        $totp = TOTP::create($totpSecret);
        $totp->setIssuer('DonateKudos');
        $totp->setLabel($user->email);

        // Get the provisioning URI for QR code
        $qrCodeUri = $totp->getProvisioningUri();

        // Generate QR code URL using external service
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrCodeUri);

        return view('auth.setup-totp', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $totpSecret,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $userId = session('totp_setup_user_id');
        $totpSecret = session('totp_setup_secret');

        if (!$userId || !$totpSecret) {
            return redirect()->route('login')->with('error', 'Invalid setup session.');
        }

        $request->validate([
            'code' => 'required|string|size:6|regex:/^\d+$/',
        ]);

        // Verify TOTP code
        $totp = TOTP::create($totpSecret);
        if (!$totp->verify($request->code)) {
            return back()->with('error', 'Invalid verification code. Please try again.');
        }

        // Code is valid, log in user and clear session
        $user = User::find($userId);
        Auth::login($user);

        session()->forget(['totp_setup_user_id', 'totp_setup_secret']);

        return redirect()->route('dashboard')->with('status', 'TOTP setup complete! You are now logged in.');
    }
}
