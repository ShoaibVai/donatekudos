<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Gallery;
use App\Models\DeletedUser;
use App\Models\DeletedProfile;
use App\Models\DeletedGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $galleries = $user->galleries;

        return view('profile.index', compact('user', 'profile', 'galleries'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $galleries = $user->galleries;

        return view('profile.edit', compact('user', 'profile', 'galleries'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'contact_info' => 'nullable|json',
            'wallet_addresses' => 'nullable|json',
            'qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        // Update contact info and wallet addresses
        if ($request->filled('contact_info')) {
            $profile->contact_info = json_decode($request->contact_info, true);
        }

        if ($request->filled('wallet_addresses')) {
            $profile->wallet_addresses = json_decode($request->wallet_addresses, true);
        }

        // Handle QR code upload
        if ($request->hasFile('qr_code')) {
            if ($profile->qr_code_path && Storage::exists($profile->qr_code_path)) {
                Storage::delete($profile->qr_code_path);
            }
            $profile->qr_code_path = $request->file('qr_code')->store('qr-codes', 'public');
        }

        $profile->save();

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('galleries', 'public');
                Gallery::create([
                    'user_id' => $user->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy()
    {
        return DB::transaction(function () {
            $user = Auth::user();
            $profile = $user->profile;
            $galleries = $user->galleries;

            // Move user to deleted_users
            DeletedUser::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'totp_secret' => $user->totp_secret,
                'deleted_at' => now(),
            ]);

            // Move profile to deleted_profiles
            if ($profile) {
                DeletedProfile::create([
                    'user_id' => $user->id,
                    'contact_info' => $profile->contact_info,
                    'wallet_addresses' => $profile->wallet_addresses,
                    'qr_code_path' => $profile->qr_code_path,
                    'deleted_at' => now(),
                ]);
            }

            // Move galleries to deleted_galleries
            foreach ($galleries as $gallery) {
                DeletedGallery::create([
                    'user_id' => $user->id,
                    'image_path' => $gallery->image_path,
                    'deleted_at' => now(),
                ]);
            }

            // Delete user (cascades to profile and galleries)
            $user->delete();

            // Log out user
            Auth::logout();

            return redirect()->route('login')
                ->with('success', 'Your account has been deleted successfully.');
        });
    }

    public function show($username)
    {
        // Find user by username (we'll use name as username)
        $user = User::where('name', $username)->firstOrFail();
        $profile = $user->profile;
        $galleries = $user->galleries;

        return view('profile.show', compact('user', 'profile', 'galleries'));
    }
}
