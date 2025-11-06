<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DeletedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Admin logged in successfully.');
        }

        return redirect()->back()
            ->withErrors(['username' => 'Invalid admin credentials.'])
            ->withInput();
    }

    public function dashboard()
    {
        $this->authorizeAdmin();

        $totalUsers = User::count();
        $totalDeletedUsers = DeletedUser::count();

        return view('admin.dashboard', compact('totalUsers', 'totalDeletedUsers'));
    }

    public function users()
    {
        $this->authorizeAdmin();

        $users = User::with('profile', 'galleries')->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function deletedUsers()
    {
        $this->authorizeAdmin();

        $deletedUsers = DeletedUser::paginate(15);

        return view('admin.deleted-users', compact('deletedUsers'));
    }

    public function exportUserXml($userId)
    {
        $this->authorizeAdmin();

        // Try to find in active users first
        $user = User::find($userId);
        $isDeleted = false;

        if (!$user) {
            // Try deleted users
            $user = DeletedUser::find($userId);
            $isDeleted = true;
        }

        if (!$user) {
            abort(404, 'User not found.');
        }

        // Create XML
        $xml = new SimpleXMLElement('<user/>');
        $xml->addChild('id', $user->id);
        $xml->addChild('name', $user->name);
        $xml->addChild('email', $user->email);
        $xml->addChild('status', $isDeleted ? 'deleted' : 'active');

        if ($isDeleted && isset($user->deleted_at)) {
            $xml->addChild('deleted_at', $user->deleted_at);
        }

        if (!$isDeleted) {
            // Add profile and galleries for active users
            if ($user->profile) {
                $profileNode = $xml->addChild('profile');
                $profileNode->addChild('contact_info', json_encode($user->profile->contact_info ?? []));
                $profileNode->addChild('wallet_addresses', json_encode($user->profile->wallet_addresses ?? []));
                $profileNode->addChild('qr_code_path', $user->profile->qr_code_path ?? '');
            }

            if ($user->galleries->count() > 0) {
                $galleriesNode = $xml->addChild('galleries');
                foreach ($user->galleries as $gallery) {
                    $galleriesNode->addChild('image', $gallery->image_path);
                }
            }
        }

        $xmlString = $xml->asXML();

        return response($xmlString, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="user_' . $user->id . '.xml"');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Admin logged out successfully.');
    }

    protected function authorizeAdmin()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized. Admin access required.');
        }
    }
}
