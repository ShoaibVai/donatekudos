<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user()->loadMissing([
            'profile.galleryItems',
            'profile.walletQrCodes',
        ]);

        $profile = $user->profile;

        return view('dashboard', [
            'user' => $user,
            'profile' => $profile,
            'galleryCount' => $profile?->galleryItems->count() ?? 0,
            'walletCount' => $profile?->walletQrCodes->count() ?? 0,
        ]);
    }
}
