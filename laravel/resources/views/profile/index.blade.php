@extends('layouts.app')

@section('title', 'My Profile - DonateKudos')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">{{ auth()->user()->name }}'s Profile</h1>
        <p class="text-gray-600">Manage your donation profile and gallery</p>
    </div>

    @if($profile)
        <!-- Profile Card -->
        <div class="card mb-8">
            <div class="p-8 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                        <p class="text-sm text-gray-600">Email: <span class="font-semibold text-gray-900">{{ auth()->user()->email }}</span></p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn-primary">Edit Profile</a>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="p-6">
                <!-- Contact Information -->
                @if($profile->contact_info)
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Contact Information
                        </h3>
                        <div class="space-y-2">
                            @php
                                $contactInfo = $profile->contact_info;
                                if (is_string($contactInfo)) {
                                    $contactInfo = json_decode($contactInfo, true);
                                }
                            @endphp
                            @if(is_array($contactInfo) && count($contactInfo) > 0)
                                @foreach($contactInfo as $key => $value)
                                    <p class="text-gray-700"><span class="font-semibold capitalize">{{ str_replace('_', ' ', $key) }}:</span> {{ $value }}</p>
                                @endforeach
                            @else
                                <p class="text-gray-600 italic">No contact information added yet.</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Wallet Addresses -->
                @if($profile->wallet_addresses)
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                            Wallet Addresses
                        </h3>
                        <div class="space-y-2 font-mono text-sm">
                            @php
                                $wallets = $profile->wallet_addresses;
                                if (is_string($wallets)) {
                                    $wallets = json_decode($wallets, true);
                                }
                            @endphp
                            @if(is_array($wallets) && count($wallets) > 0)
                                @foreach($wallets as $key => $value)
                                    <p class="text-gray-700"><span class="font-semibold capitalize">{{ str_replace('_', ' ', $key) }}:</span> <span class="break-all">{{ $value }}</span></p>
                                @endforeach
                            @else
                                <p class="text-gray-600 italic">No wallet addresses added yet.</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- QR Code -->
                @if($profile->qr_code_path)
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2h1V5H5v1zm5-2a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2h1V5h-1v1zM3 14a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2h1v-1H5v1zm5-2a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1v-3a1 1 0 00-1-1h-3zm1 2h1v-1h-1v1z"></path>
                            </svg>
                            QR Code
                        </h3>
                        <div class="flex justify-center p-4 bg-gray-50 rounded-lg">
                            <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="QR Code" class="w-48 h-48 object-contain">
                        </div>
                    </div>
                @endif

                <!-- Gallery -->
                @if($galleries->count() > 0)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4.5-4.5 3 3 4-4 2.5 2.5V5a1 1 0 011 1v10z"></path>
                            </svg>
                            Gallery ({{ $galleries->count() }} images)
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($galleries as $image)
                                <div class="relative group overflow-hidden rounded-lg shadow hover:shadow-lg transition">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery" class="w-full h-32 object-cover group-hover:scale-105 transition">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Danger Zone -->
            <div class="px-6 py-4 bg-red-50 border-t border-red-200">
                <h3 class="text-lg font-bold text-red-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Danger Zone
                </h3>
                <p class="text-red-800 text-sm mb-3">Deleting your account will permanently remove all your data.</p>
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">Delete My Account</button>
                </form>
            </div>
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Profile Data</h3>
            <p class="text-gray-600 mb-6">Start by editing your profile to add contact info, wallet addresses, and QR code.</p>
            <a href="{{ route('profile.edit') }}" class="inline-block btn-primary">Create Profile</a>
        </div>
    @endif
</div>
@endsection
