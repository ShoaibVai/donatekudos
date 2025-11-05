<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * List all users
     */
    public function index()
    {
        $users = User::with('profile')->paginate(15);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show user profile
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $profile = Profile::where('user_id', $id)->first();
        $galleries = $profile?->galleries()->get() ?? [];

        return view('admin.users.show', [
            'user' => $user,
            'profile' => $profile,
            'galleries' => $galleries,
        ]);
    }
}
