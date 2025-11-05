<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Models\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $userCount = User::count();
        $profileCount = Profile::count();
        $recentUsers = User::latest()->take(10)->get();

        return view('admin.dashboard', [
            'userCount' => $userCount,
            'profileCount' => $profileCount,
            'recentUsers' => $recentUsers,
        ]);
    }
}
