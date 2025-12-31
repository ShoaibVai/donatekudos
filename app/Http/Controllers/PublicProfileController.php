<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PublicProfileController extends Controller
{
    /**
     * Show public profile with caching
     */
    public function show($slug)
    {
        // Validate slug format
        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            abort(404);
        }

        $profile = Profile::where('slug', $slug)
            ->with(['user', 'galleryImages' => function ($query) {
                $query->orderBy('order');
            }])
            ->firstOrFail();
            
        return view('public_profile.show', compact('profile'));
    }

    /**
     * Edit profile - ensure user owns it
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Create profile if doesn't exist
        if (!$user->profile) {
            $baseSlug = Str::slug($user->name);
            $slug = $baseSlug;
            $counter = 1;
            
            // Ensure unique slug
            while (Profile::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            
            $user->profile()->create([
                'slug' => $slug,
                'theme' => 'monochrome',
                'template_id' => 1,
            ]);
            
            // Refresh relationship to load new profile
            $user->refresh();
        }
        
        $profile = $user->profile;
        return view('public_profile.edit', compact('profile'));
    }

    /**
     * Update profile with enhanced validation
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return back()->with('error', 'Profile not found. Please create one first.');
        }

        $validated = $request->validate([
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                'regex:/^[a-z0-9-]+$/',
                'unique:profiles,slug,' . $profile->id
            ],
            'bio' => 'nullable|string|max:1000',
            'custom_html' => 'nullable|string|max:10000',
            'custom_css' => 'nullable|string|max:10000',
            'custom_js' => 'nullable|string|max:5000',
            'theme' => 'required|in:techy,artsy,monochrome',
            'template_id' => 'nullable|integer|min:1',
        ], [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'slug.alpha_dash' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
        ]);

        // Set default template_id if not provided
        if (!isset($validated['template_id'])) {
            $validated['template_id'] = 1;
        }

        // Ensure slug is lowercase and URL-safe
        $validated['slug'] = Str::slug($validated['slug']);

        try {
            $profile->update($validated);
            Log::info('Profile updated', ['user_id' => $user->id, 'profile_id' => $profile->id]);
            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile update failed', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Upload gallery image with validation and optimization
     */
    public function uploadImage(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return back()->with('error', 'Profile not found. Please create one first.');
        }

        // Check image limit
        $currentCount = $profile->galleryImages()->count();
        if ($currentCount >= 10) {
            return back()->with('error', 'You can only upload up to 10 images.');
        }

        // Enhanced validation with dimensions
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB max
                'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000'
            ],
        ], [
            'image.dimensions' => 'Image must be between 100x100 and 4000x4000 pixels.',
            'image.max' => 'Image must not exceed 5MB.',
        ]);

        try {
            $file = $request->file('image');
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $filename, 'public');

            $profile->galleryImages()->create([
                'image_path' => $path,
                'order' => $currentCount, // Use current count for zero-based indexing
            ]);

            Log::info('Image uploaded', ['user_id' => $user->id, 'profile_id' => $profile->id, 'path' => $path]);
            return back()->with('success', 'Image uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Image upload failed', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            return back()->with('error', 'Failed to upload image. Please try again.');
        }
    }

    /**
     * Delete gallery image with authorization
     */
    public function deleteImage($id)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return back()->with('error', 'Profile not found.');
        }

        // Ensure the image belongs to the user's profile
        $image = $profile->galleryImages()->findOrFail($id);

        try {
            $imagePath = $image->image_path;
            
            // Delete the model (boot method will handle file deletion)
            $image->delete();
            
            // Reorder remaining images
            $remainingImages = $profile->galleryImages()->orderBy('order')->get();
            foreach ($remainingImages as $index => $img) {
                $img->update(['order' => $index]);
            }

            Log::info('Image deleted', ['user_id' => $user->id, 'profile_id' => $profile->id, 'image_path' => $imagePath]);
            return back()->with('success', 'Image deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Image deletion failed', ['error' => $e->getMessage(), 'user_id' => $user->id, 'image_id' => $id]);
            return back()->with('error', 'Failed to delete image. Please try again.');
        }
    }
}
