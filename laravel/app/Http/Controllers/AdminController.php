<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DeletedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleXMLElement;

class AdminController extends Controller
{
    /**
     * Show admin login form
     */
    public function login()
    {
        if (Session::has('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Verify admin password
     */
    public function verifyPassword(Request $request)
    {
        $password = $request->validate([
            'password' => 'required|string',
        ])['password'];

        // Admin password
        $adminPassword = 'Rishbish$$';

        if ($password === $adminPassword) {
            Session::put('admin_authenticated', true);
            return redirect()->route('admin.dashboard')->with('success', 'Admin panel access granted');
        }

        return back()->with('error', 'Invalid password');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard(Request $request)
    {
        $this->checkAdminAuth();

        $search = $request->query('search');
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->paginate(15);

        return view('admin.dashboard', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Show deleted users
     */
    public function deletedUsers(Request $request)
    {
        $this->checkAdminAuth();

        $search = $request->query('search');
        $query = DeletedUser::query();

        if ($search) {
            $query->whereRaw('user_data->>\'name\' ILIKE ?', ["%{$search}%"])
                  ->orWhereRaw('user_data->>\'email\' ILIKE ?', ["%{$search}%"]);
        }

        $deletedUsers = $query->paginate(15);

        return view('admin.deleted-users', [
            'deletedUsers' => $deletedUsers,
            'search' => $search,
        ]);
    }

    /**
     * Delete user (admin action)
     */
    public function deleteUser($id)
    {
        $this->checkAdminAuth();

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', "User '{$user->name}' deleted successfully");
    }

    /**
     * Export users as XML
     */
    public function exportXml()
    {
        $this->checkAdminAuth();

        $users = User::with('profile')->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><users/>');

        foreach ($users as $user) {
            $userNode = $xml->addChild('user');
            $userNode->addChild('id', $user->id);
            $userNode->addChild('name', htmlspecialchars($user->name));
            $userNode->addChild('email', htmlspecialchars($user->email));
            $userNode->addChild('created_at', $user->created_at->toIso8601String());
            $userNode->addChild('updated_at', $user->updated_at->toIso8601String());

            if ($user->profile) {
                $profileNode = $userNode->addChild('profile');
                $profileNode->addChild('profile_url', htmlspecialchars($user->profile->profile_url));
                $profileNode->addChild('phone', htmlspecialchars($user->profile->phone ?? ''));
                $profileNode->addChild('bio', htmlspecialchars($user->profile->bio ?? ''));
                $profileNode->addChild('bitcoin_address', htmlspecialchars($user->profile->bitcoin_address ?? ''));
                $profileNode->addChild('ethereum_address', htmlspecialchars($user->profile->ethereum_address ?? ''));
                
                // Gallery items
                $galleryNode = $profileNode->addChild('gallery');
                foreach ($user->profile->galleryItems as $item) {
                    $itemNode = $galleryNode->addChild('item');
                    $itemNode->addChild('image_path', htmlspecialchars($item->image_path));
                    $itemNode->addChild('description', htmlspecialchars($item->description ?? ''));
                    $itemNode->addChild('category', htmlspecialchars($item->category ?? ''));
                }

                // Wallet QR codes
                $walletsNode = $profileNode->addChild('wallets');
                foreach ($user->profile->walletQrCodes as $wallet) {
                    $walletNode = $walletsNode->addChild('wallet');
                    $walletNode->addChild('cryptocurrency_type', htmlspecialchars($wallet->cryptocurrency_type));
                    $walletNode->addChild('image_path', htmlspecialchars($wallet->image_path));
                }
            }
        }

        $xmlString = $xml->asXML();

        return response($xmlString, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="users_export_' . now()->format('Y-m-d_His') . '.xml"');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Session::forget('admin_authenticated');
        return redirect('/')->with('success', 'Admin session ended');
    }

    /**
     * Check if user is authenticated as admin
     */
    private function checkAdminAuth()
    {
        if (!Session::has('admin_authenticated') || !Session::get('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin authentication required');
        }
    }
}
