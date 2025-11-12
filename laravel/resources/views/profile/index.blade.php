@extends('layouts.app')

@section('title', 'My Profile - DonateKudos')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <!-- Header with Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div>
            <h1 class="text-5xl font-bold gradient-text mb-3">{{ auth()->user()->name }}</h1>
            <p class="text-gray-600 text-lg">Manage your donation profile and gallery</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <a href="{{ route('profile.edit') }}" class="btn-primary-lg text-center">
                <i class="fas fa-edit mr-2"></i>Edit Profile
            </a>
            <button onclick="shareProfile()" class="btn-secondary text-center">
                <i class="fas fa-share-alt mr-2"></i>Share
            </button>
        </div>
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
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 mb-4">
                <i class="fas fa-inbox text-violet-600 text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Profile Data</h3>
            <p class="text-gray-600 mb-6">Start by editing your profile to add contact info, wallet addresses, and QR code.</p>
            <a href="{{ route('profile.edit') }}" class="inline-block btn-primary-lg">
                <i class="fas fa-plus mr-2"></i>Create Profile
            </a>
        </div>
    @endif

    <!-- Profile Stats Grid -->
    @if($profile)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12">
            <div class="card p-6 hover:border-violet-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Member Since</p>
                        <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-100 to-pink-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-violet-600 text-lg"></i>
                    </div>
                </div>
            </div>
            <div class="card p-6 hover:border-violet-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Gallery Items</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $galleries->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-image text-cyan-600 text-lg"></i>
                    </div>
                </div>
            </div>
            <div class="card p-6 hover:border-violet-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Contact Info</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $profile->contact_info ? '✓' : '✕' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-envelope text-emerald-600 text-lg"></i>
                    </div>
                </div>
            </div>
            <div class="card p-6 hover:border-violet-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Wallets Added</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $profile->wallet_addresses ? '✓' : '✕' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wallet text-amber-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Main Content (2/3 width) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Account Info -->
                <div class="card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-50 to-pink-50 border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user-circle text-violet-600"></i>Account Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-600">Full Name</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-600">Email Address</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">Member Since</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-phone text-cyan-600"></i>Contact Information
                        </h2>
                    </div>
                    <div class="p-6">
                        @php
                            $contactInfo = $profile->contact_info;
                            if (is_string($contactInfo)) {
                                $contactInfo = json_decode($contactInfo, true);
                            }
                        @endphp
                        @if(is_array($contactInfo) && count($contactInfo) > 0)
                            <div class="space-y-4">
                                @foreach($contactInfo as $key => $value)
                                    <div class="pb-4 border-b border-gray-200 last:border-b-0 last:pb-0">
                                        <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">{{ str_replace('_', ' ', $key) }}</p>
                                        <p class="text-lg text-gray-900 font-medium mt-1">
                                            @if($key === 'phone')
                                                <i class="fas fa-phone text-violet-600 mr-2"></i>
                                            @elseif($key === 'website')
                                                <i class="fas fa-globe text-violet-600 mr-2"></i>
                                                <a href="{{ $value }}" target="_blank" class="text-violet-600 hover:underline">{{ $value }}</a>
                                            @else
                                                <i class="fas fa-map-marker-alt text-violet-600 mr-2"></i>
                                            @endif
                                            {{ ($key !== 'website') ? $value : '' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-600">No contact information added yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Wallet Addresses -->
                <div class="card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-wallet text-amber-600"></i>Wallet Addresses
                        </h2>
                    </div>
                    <div class="p-6">
                        @php
                            $wallets = $profile->wallet_addresses;
                            if (is_string($wallets)) {
                                $wallets = json_decode($wallets, true);
                            }
                        @endphp
                        @if(is_array($wallets) && count($wallets) > 0)
                            <div class="space-y-4">
                                @foreach($wallets as $key => $value)
                                    <div class="pb-4 border-b border-gray-200 last:border-b-0 last:pb-0">
                                        <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">{{ str_replace('_', ' ', $key) }}</p>
                                        <div class="mt-2 p-3 bg-gray-50 rounded-lg font-mono text-sm text-gray-900 break-all border border-gray-200">
                                            {{ $value }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-600">No wallet addresses added yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/3 width) -->
            <div class="space-y-6">
                <!-- QR Code Card -->
                <div class="card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200 px-6 py-4">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-qrcode text-violet-600"></i>QR Code
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col items-center">
                        @if($profile->qr_code_path)
                            <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="QR Code" class="w-40 h-40 object-contain rounded-lg border-2 border-violet-200">
                            <p class="text-xs text-gray-600 mt-3">Scan to share your profile</p>
                        @else
                            <div class="w-40 h-40 bg-gray-100 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-xs text-gray-600">No QR code uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card-hover p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-violet-600"></i>Profile Status
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Account</span>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Contact Info</span>
                            <span class="badge {{ $profile->contact_info ? 'badge-success' : 'badge-warning' }}">
                                <i class="fas fa-{{ $profile->contact_info ? 'check-circle' : 'exclamation-circle' }} mr-1"></i>{{ $profile->contact_info ? 'Complete' : 'Missing' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Wallets</span>
                            <span class="badge {{ $profile->wallet_addresses ? 'badge-success' : 'badge-warning' }}">
                                <i class="fas fa-{{ $profile->wallet_addresses ? 'check-circle' : 'exclamation-circle' }} mr-1"></i>{{ $profile->wallet_addresses ? 'Added' : 'Empty' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Gallery</span>
                            <span class="badge badge-primary">
                                <i class="fas fa-images mr-1"></i>{{ $galleries->count() }} items
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        @if($galleries->count() > 0)
            <div class="card-hover overflow-hidden mb-12">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200 px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-image text-emerald-600"></i>Photo Gallery ({{ $galleries->count() }} photos)
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($galleries as $image)
                            <div class="relative group overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 bg-gray-100">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-300" loading="lazy">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank" class="p-2 bg-white/90 rounded-full hover:bg-white transition">
                                        <i class="fas fa-expand text-gray-900"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Danger Zone -->
        <div class="card border-2 border-red-200 bg-red-50/50 overflow-hidden mb-8">
            <div class="bg-red-100 border-b border-red-200 px-6 py-4">
                <h2 class="text-xl font-bold text-red-900 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>Danger Zone
                </h2>
            </div>
            <div class="p-6">
                <p class="text-red-800 text-sm mb-4">Deleting your account will permanently remove all your data including profile, gallery, and personal information. This action cannot be undone.</p>
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('🚨 WARNING: This will permanently delete your entire account and all associated data. Type YES to confirm.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash-alt mr-2"></i>Delete My Account Permanently
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>

<script>
    function shareProfile() {
        const currentUrl = `{{ url('/profile/' . auth()->user()->name) }}`;
        if (navigator.share) {
            navigator.share({
                title: '{{ auth()->user()->name }} on DonateKudos',
                text: 'Check out my donation profile!',
                url: currentUrl
            });
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(currentUrl);
            alert('Profile link copied to clipboard!');
        }
    }
</script>
@endsection
