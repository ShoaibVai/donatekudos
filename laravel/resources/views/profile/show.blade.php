@extends('layouts.app')

@section('title', $user->name . ' - DonateKudos')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Profile Header -->
    <div class="card mb-8 overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <div class="p-12 text-center bg-gradient-to-br from-violet-600 via-purple-500 to-pink-500 relative overflow-hidden">
            <!-- Animated background pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
                <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            </div>
            
            <div class="relative z-10">
                <div class="mb-6 inline-flex items-center justify-center w-28 h-28 rounded-full bg-white/20 backdrop-blur-md border-2 border-white/40 text-white text-5xl font-bold shadow-xl">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h1 class="text-5xl font-bold text-white mb-3 drop-shadow-lg">{{ $user->name }}</h1>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-white/90">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        {{ $user->email }}
                    </span>
                    <span class="hidden sm:inline text-white/50">•</span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-calendar"></i>
                        Member since {{ $user->created_at->format('F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if($profile)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Main Content: 2/3 width -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Information Card -->
                @if($profile->contact_info)
                    <div class="card shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border-l-4 border-cyan-500">
                        <div class="bg-gradient-to-r from-cyan-50 to-cyan-100/50 px-6 py-4 border-b border-cyan-200">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-lg bg-cyan-500 text-white flex items-center justify-center">
                                    <i class="fas fa-phone"></i>
                                </span>
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
                            <div class="space-y-4">
                                @if(is_array($contactInfo) && count($contactInfo) > 0)
                                    @foreach($contactInfo as $key => $value)
                                        <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <span class="text-gray-600 font-semibold text-sm capitalize flex items-center gap-2">
                                                @if($key === 'phone')
                                                    <i class="fas fa-phone text-cyan-500"></i>
                                                @elseif($key === 'website')
                                                    <i class="fas fa-globe text-cyan-500"></i>
                                                @elseif($key === 'address')
                                                    <i class="fas fa-map-marker-alt text-cyan-500"></i>
                                                @else
                                                    <i class="fas fa-info-circle text-cyan-500"></i>
                                                @endif
                                                {{ str_replace('_', ' ', $key) }}
                                            </span>
                                            <span class="text-gray-900 font-semibold text-sm text-right break-all">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 italic text-center py-4">
                                        <i class="fas fa-inbox text-gray-400 mr-2"></i>
                                        No contact information available.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Wallet Addresses Card -->
                @if($profile->wallet_addresses)
                    <div class="card shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border-l-4 border-emerald-500">
                        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100/50 px-6 py-4 border-b border-emerald-200">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                                    <i class="fas fa-wallet"></i>
                                </span>
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
                            <div class="space-y-4">
                                @if(is_array($wallets) && count($wallets) > 0)
                                    @foreach($wallets as $key => $value)
                                        <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors border border-gray-200 hover:border-emerald-300">
                                            <span class="text-gray-600 font-semibold text-sm capitalize block mb-2">
                                                @if($key === 'bitcoin')
                                                    <i class="fab fa-bitcoin text-amber-600 mr-2"></i>
                                                @elseif($key === 'ethereum')
                                                    <i class="fab fa-ethereum text-purple-600 mr-2"></i>
                                                @elseif($key === 'litecoin')
                                                    <i class="fas fa-coins text-gray-400 mr-2"></i>
                                                @else
                                                    <i class="fas fa-coin text-emerald-600 mr-2"></i>
                                                @endif
                                                {{ str_replace('_', ' ', $key) }}
                                            </span>
                                            <span class="text-gray-800 font-mono text-sm break-all bg-white p-2 rounded border border-gray-300 block mt-2">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 italic text-center py-4">
                                        <i class="fas fa-inbox text-gray-400 mr-2"></i>
                                        No wallet addresses available.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar: 1/3 width -->
            <div class="space-y-6">
                <!-- QR Code Section -->
                @if($profile->qr_code_path)
                    <div class="card shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border-l-4 border-purple-500">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100/50 px-6 py-4 border-b border-purple-200">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-lg bg-purple-500 text-white flex items-center justify-center">
                                    <i class="fas fa-qrcode"></i>
                                </span>
                                QR Code
                            </h2>
                        </div>
                        <div class="p-6 text-center bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center min-h-64">
                            <img 
                                src="{{ asset('storage/' . $profile->qr_code_path) }}" 
                                alt="QR Code" 
                                class="w-48 h-48 object-contain rounded-lg shadow-lg border-4 border-white"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23f3f4f6%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 fill=%22%23999%22 text-anchor=%22middle%22 dy=%22.3em%22%3EQR Code Not Available%3C/text%3E%3C/svg%3E'"
                            >
                        </div>
                    </div>
                @endif
            </div>
        </div>

    <!-- Gallery Section -->
    @if($galleries->count() > 0)
        <div class="card shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border-l-4 border-pink-500">
            <div class="bg-gradient-to-r from-pink-50 to-pink-100/50 px-6 py-4 border-b border-pink-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="w-10 h-10 rounded-lg bg-pink-500 text-white flex items-center justify-center">
                        <i class="fas fa-images"></i>
                    </span>
                    Gallery ({{ $galleries->count() }} image{{ $galleries->count() !== 1 ? 's' : '' }})
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($galleries as $image)
                        <div class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer h-48">
                            <img 
                                src="{{ asset('storage/' . $image->image_path) }}" 
                                alt="Gallery Image" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Crect fill=%22%23f3f4f6%22 width=%22300%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 fill=%22%23999%22 text-anchor=%22middle%22 dy=%22.3em%22%3EImage Not Found%3C/text%3E%3C/svg%3E'"
                            >
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-md border-l-4 border-gray-300 text-center py-12">
            <i class="fas fa-images text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500 text-lg">No gallery images available.</p>
        </div>
    @endif
    @endif

    <!-- Action Buttons -->
    <div class="mt-8 flex flex-col sm:flex-row gap-4">
        <a href="{{ route('profile.index') }}" class="btn-secondary inline-flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Back to Profiles
        </a>
        <a href="{{ route('profile.edit', $user->id) }}" class="btn-primary-lg inline-flex items-center justify-center gap-2">
            <i class="fas fa-edit"></i>
            Edit Profile
        </a>
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>
@endsection
