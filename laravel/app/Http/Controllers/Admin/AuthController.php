<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->showLoginForm();
        }

        $credentials = $request->validate([
            'password' => 'required|string',
        ]);

        // Simple admin authentication with hardcoded password
        $adminPassword = config('app.admin_password', 'Rishbish$$');

        if ($credentials['password'] === $adminPassword) {
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['password' => 'Invalid admin password.']);
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        session()->forget('admin_authenticated');
        return redirect('/');
    }
}
