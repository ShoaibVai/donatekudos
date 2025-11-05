@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Edit Profile</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="max-w-2xl bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" id="username" name="username" value="{{ $profile->username }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
            <textarea id="bio" name="bio" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">{{ $profile->bio }}</textarea>
        </div>

        <div class="mb-4">
            <label for="avatar_url" class="block text-gray-700 text-sm font-bold mb-2">Avatar URL</label>
            <input type="url" id="avatar_url" name="avatar_url" value="{{ $profile->avatar_url }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="contact_info" class="block text-gray-700 text-sm font-bold mb-2">Contact Info (JSON)</label>
            <textarea id="contact_info" name="contact_info" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-mono text-sm">{{ json_encode($profile->contact_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</textarea>
            <small class="text-gray-500">e.g., {"email": "user@example.com", "phone": "+1234567890"}</small>
        </div>

        <div class="mb-4">
            <label for="wallet_addresses" class="block text-gray-700 text-sm font-bold mb-2">Wallet Addresses (JSON Array)</label>
            <textarea id="wallet_addresses" name="wallet_addresses" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-mono text-sm">{{ json_encode($profile->wallet_addresses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</textarea>
            <small class="text-gray-500">e.g., ["1A1z7agoat...", "0x71C7656EC7ab88b098defB751B7401B5f6d8976F"]</small>
        </div>

        <div class="mb-4">
            <label for="qr_code_url" class="block text-gray-700 text-sm font-bold mb-2">QR Code URL</label>
            <input type="url" id="qr_code_url" name="qr_code_url" value="{{ $profile->qr_code_url }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Save Changes
            </button>
            <a href="{{ route('profile.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
