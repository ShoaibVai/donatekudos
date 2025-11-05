<?php

namespace App\Http\Controllers\Api;

use App\Models\Profile;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Get public profile by username
     */
    public function show($username)
    {
        $profile = Profile::where('username', $username)->firstOrFail();
        
        return response()->json([
            'id' => $profile->id,
            'username' => $profile->username,
            'bio' => $profile->bio,
            'avatar_url' => $profile->avatar_url,
            'contact_info' => $profile->contact_info,
            'wallet_addresses' => $profile->wallet_addresses,
            'galleries' => $profile->galleries()->get(),
            'created_at' => $profile->created_at,
        ]);
    }
}
