<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        // Authorization is handled by route middleware
        $users = User::with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $stats = [
            'total_users' => User::count(),
            'total_profiles' => \App\Models\Profile::count(),
            'total_images' => \App\Models\GalleryImage::count(),
        ];
        
        return view('admin.dashboard', compact('users', 'stats'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        try {
            $user->delete();
            return back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user.');
        }
    }
}
