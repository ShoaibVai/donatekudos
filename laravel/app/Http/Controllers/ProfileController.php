<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ArchivedProfile;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Show the user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $galleries = $profile?->galleries()->get() ?? [];

        return view('profile.dashboard', [
            'profile' => $profile,
            'galleries' => $galleries,
        ]);
    }

    /**
     * Show the public profile
     */
    public function show($username)
    {
        $profile = Profile::where('username', $username)->firstOrFail();
        $galleries = $profile->galleries()->get();

        return view('profile.show', [
            'profile' => $profile,
            'galleries' => $galleries,
        ]);
    }

    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->firstOrFail();

        return view('profile.edit', ['profile' => $profile]);
    }

    /**
     * Update the user profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:profiles,username,' . Auth::user()->id . ',user_id',
            'bio' => 'nullable|string|max:500',
            'avatar_url' => 'nullable|string|url',
            'contact_info' => 'nullable|json',
            'wallet_addresses' => 'nullable|json',
            'qr_code_url' => 'nullable|string|url',
        ]);

        $profile = Profile::where('user_id', Auth::user()->id)->firstOrFail();
        $profile->update($validated);

        return redirect()->route('profile.dashboard')->with('success', 'Profile updated successfully.');
    }

    /**
     * Archive and delete the user profile
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->firstOrFail();

        // Verify password
        if (!password_verify($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The password is incorrect.']);
        }

        // Archive the profile
        $archived = ArchivedProfile::create([
            'id' => DB::raw('gen_random_uuid()'),
            'original_profile_id' => $profile->id,
            'user_id' => $user->id,
            'user_data' => $profile->toArray(),
            'gallery_data' => $profile->galleries()->get()->toArray(),
            'deleted_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        // Delete galleries
        $profile->galleries()->delete();

        // Delete profile
        $profile->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Your profile has been archived and deleted.');
    }
}
