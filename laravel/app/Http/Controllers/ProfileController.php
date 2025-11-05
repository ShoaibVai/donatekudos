<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\GalleryItem;
use App\Models\WalletQrCode;
use App\Models\DeletedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show user's profile
     */
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile()->first();

        if (!$profile) {
            return redirect()->route('profile.create');
        }

        $galleryItems = $profile->galleryItems()->paginate(12);

        return view('profile.show', [
            'profile' => $profile,
            'galleryItems' => $galleryItems,
        ]);
    }

    /**
     * Show profile creation form
     */
    public function create()
    {
        $user = Auth::user();
        
        if ($user->profile()->exists()) {
            return redirect()->route('profile.show');
        }

        return view('profile.create');
    }

    /**
     * Store profile
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'bitcoin_address' => 'nullable|string|max:255',
            'ethereum_address' => 'nullable|string|max:255',
            'social_media' => 'nullable|array',
        ]);

        $profileUrl = Profile::generateUniqueProfileUrl($user->name);

        $profile = $user->profile()->create([
            ...$validated,
            'profile_url' => $profileUrl,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile created successfully!');
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        return view('profile.edit', ['profile' => $profile]);
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'bitcoin_address' => 'nullable|string|max:255',
            'ethereum_address' => 'nullable|string|max:255',
            'social_media' => 'nullable|array',
        ]);

        $profile->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload gallery image
     */
    public function uploadGallery(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        $profile->galleryItems()->create([
            'image_path' => $path,
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? null,
        ]);

        return back()->with('success', 'Image uploaded successfully!');
    }

    /**
     * Delete gallery image
     */
    public function deleteGallery($id)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        $item = $profile->galleryItems()->findOrFail($id);

        Storage::disk('public')->delete($item->image_path);
        $item->delete();

        return back()->with('success', 'Image deleted successfully!');
    }

    /**
     * Upload wallet QR code
     */
    public function uploadWallet(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cryptocurrency_type' => 'required|string|max:50',
        ]);

        $path = $request->file('image')->store('wallets', 'public');

        $profile->walletQrCodes()->create([
            'image_path' => $path,
            'cryptocurrency_type' => $validated['cryptocurrency_type'],
        ]);

        return back()->with('success', 'QR code uploaded successfully!');
    }

    /**
     * Delete wallet QR code
     */
    public function deleteWallet($id)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        $wallet = $profile->walletQrCodes()->findOrFail($id);

        Storage::disk('public')->delete($wallet->image_path);
        $wallet->delete();

        return back()->with('success', 'QR code deleted successfully!');
    }

    /**
     * Get public profile
     */
    public function publicProfile($profileUrl)
    {
        $profile = Profile::where('profile_url', $profileUrl)->firstOrFail();
        $user = $profile->user;
        $galleryItems = $profile->galleryItems()->paginate(12);

        return view('profile.public', [
            'profile' => $profile,
            'user' => $user,
            'galleryItems' => $galleryItems,
        ]);
    }

    /**
     * Delete user profile and move data to deleted_users
     */
    public function destroy()
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        // Store user data in deleted_users table
        DeletedUser::create([
            'original_user_id' => $user->id,
            'user_data' => [
                'name' => $user->name,
                'email' => $user->email,
                'profile' => $profile,
            ],
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);

        // Delete user and related data
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Your profile has been deleted successfully.');
    }
}
