@extends('layouts.app')

@section('title', $user->name . ' - DonateKudos')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <!-- Profile Header -->
    <div class="card mb-8">
        <div class="p-8 text-center bg-gradient-to-r from-purple-50 to-blue-50">
            <div class="mb-4 inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-brand text-white text-3xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h1 class="text-4xl font-bold gradient-text mb-2">{{ $user->name }}</h1>
            <p class="text-gray-600 mb-1">{{ $user->email }}</p>
            <p class="text-sm text-gray-500">Member since {{ $user->created_at->format('F Y') }}</p>
        </div>
    </div>

    @if($profile)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Contact Information Card -->
            @if($profile->contact_info)
                <div class="card">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.058.3.102.605.102.924 0 1.748.585 3.364 1.56 4.657L9.322 16.5h2.831l2.362-2.36c1.974-1.933 3.185-4.612 3.185-7.556 0-.319-.044-.624-.102-.924l1.548-.773a1 1 0 01.54-1.06l.74-4.435A1 1 0 0116.847 3H14a1 1 0 01-.986-.836l-.74-4.435a1 1 0 01.54-1.06l1.548-.773C13.942.743 13 0 11.5 0H8.5c-1.5 0-2.442.743-2.91 1.836l1.548.773a1 1 0 01.54 1.06l-.74 4.435A1 1 0 015.153 8H3a1 1 0 01-1-1V3z"></path>
                            </svg>
                            Contact Information
                        </h2>
                    </div>
                    <div class="p-6">
                        @php
                            $contactInfo = $profile->contact_info;
                            if (is_string($contactInfo)) {
                                $contactInfo = json_decode($contactInfo, true);
                            }
                        @endphp
                        <div class="space-y-3">
                            @if(is_array($contactInfo) && count($contactInfo) > 0)
                                @foreach($contactInfo as $key => $value)
                                    <div class="flex items-start justify-between py-2 border-b border-gray-100 last:border-0">
                                        <span class="text-gray-600 font-semibold text-sm capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                        <span class="text-gray-900 font-semibold text-sm text-right break-all">{{ $value }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-600 italic">No contact information available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Wallet Addresses Card -->
            @if($profile->wallet_addresses)
                <div class="card">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                            Wallet Addresses
                        </h2>
                    </div>
                    <div class="p-6">
                        @php
                            $wallets = $profile->wallet_addresses;
                            if (is_string($wallets)) {
                                $wallets = json_decode($wallets, true);
                            }
                        @endphp
                        <div class="space-y-3">
                            @if(is_array($wallets) && count($wallets) > 0)
                                @foreach($wallets as $key => $value)
                                    <div class="flex items-start justify-between py-2 border-b border-gray-100 last:border-0">
                                        <span class="text-gray-600 font-semibold text-sm capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                        <span class="text-gray-900 font-semibold text-sm text-right font-mono break-all">{{ $value }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-600 italic">No wallet addresses available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- QR Code Section -->
        @if($profile->qr_code_path)
            <div class="card mb-8">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2h1V5H5v1zm5-2a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2h1V5h-1v1zM3 14a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2h1v-1H5v1zm5-2a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1v-3a1 1 0 00-1-1h-3zm1 2h1v-1h-1v1z"></path>
                        </svg>
                        QR Code
                    </h2>
                </div>
                <div class="p-8 text-center bg-gradient-to-br from-gray-50 to-gray-100">
                    <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="QR Code" class="w-64 h-64 object-contain mx-auto">
                </div>
            </div>
        @endif
    @endif

    <!-- Gallery Section -->
    @if($galleries->count() > 0)
        <div class="card">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4.5-4.5 3 3 4-4 2.5 2.5V5a1 1 0 011 1v10z"></path>
                    </svg>
                    Gallery ({{ $galleries->count() }} images)
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($galleries as $image)
                        <div class="relative group overflow-hidden rounded-lg shadow hover:shadow-lg transition-all duration-300">
                            <img 
                                src="{{ asset('storage/' . $image->image_path) }}" 
                                alt="Gallery Image" 
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('profile.index') }}" class="btn-secondary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Profiles
        </a>
    </div>
</div>
@endsection
