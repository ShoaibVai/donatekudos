<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Show gallery management page
     */
    public function manage()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->firstOrFail();
        $galleries = $profile->galleries()->get();

        return view('gallery.manage', [
            'profile' => $profile,
            'galleries' => $galleries,
        ]);
    }

    /**
     * Upload a new gallery image
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->firstOrFail();

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Store in Supabase Storage
        $path = "profile-galleries/{$profile->id}/{$filename}";
        Storage::disk('supabase')->put($path, file_get_contents($file));

        // Get the public URL
        $imageUrl = Storage::disk('supabase')->url($path);

        // Save to database
        $gallery = Gallery::create([
            'profile_id' => $profile->id,
            'image_url' => $imageUrl,
            'filename' => $filename,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
        ]);

        return redirect()->route('gallery.manage')->with('success', 'Image uploaded successfully.');
    }

    /**
     * Delete a gallery image
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->firstOrFail();

        if ($gallery->profile_id !== $profile->id) {
            abort(403, 'Unauthorized');
        }

        // Delete from storage
        $path = "profile-galleries/{$gallery->profile_id}/{$gallery->filename}";
        Storage::disk('supabase')->delete($path);

        $gallery->delete();

        return redirect()->route('gallery.manage')->with('success', 'Image deleted successfully.');
    }
}
