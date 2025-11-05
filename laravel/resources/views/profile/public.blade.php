@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-8 sm:px-10">
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-gray-900">{{ $user->name }}'s Profile</h1>
                    <p class="text-gray-600 mt-2">Profile URL: {{ url('/@' . $profile->profile_url) }}</p>
                </div>

                <!-- Profile Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                        <dl class="space-y-3">
                            @if($profile->phone)
                                <div>
                                    <dt class="text-sm font-medium text-gray-700">Phone</dt>
                                    <dd class="text-gray-900">{{ $profile->phone }}</dd>
                                </div>
                            @endif
                            @if($profile->bio)
                                <div>
                                    <dt class="text-sm font-medium text-gray-700">Bio</dt>
                                    <dd class="text-gray-900 whitespace-pre-line">{{ $profile->bio }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Cryptocurrency Addresses</h2>
                        <dl class="space-y-3">
                            @if($profile->bitcoin_address)
                                <div>
                                    <dt class="text-sm font-medium text-gray-700">Bitcoin</dt>
                                    <dd class="text-gray-900 font-mono text-sm break-all">{{ $profile->bitcoin_address }}</dd>
                                </div>
                            @endif
                            @if($profile->ethereum_address)
                                <div>
                                    <dt class="text-sm font-medium text-gray-700">Ethereum</dt>
                                    <dd class="text-gray-900 font-mono text-sm break-all">{{ $profile->ethereum_address }}</dd>
                                </div>
                            @endif
                            @if($profile->other_addresses && count($profile->other_addresses) > 0)
                                <div>
                                    <dt class="text-sm font-medium text-gray-700">Other Addresses</dt>
                                    <dd class="text-gray-900">
                                        <ul class="space-y-1">
                                            @foreach($profile->other_addresses as $type => $address)
                                                <li class="text-sm"><strong>{{ ucfirst($type) }}:</strong> <span class="font-mono">{{ $address }}</span></li>
                                            @endforeach
                                        </ul>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Social Media -->
                @if($profile->social_media && count($profile->social_media) > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Social Media</h2>
                        <div class="flex gap-4 flex-wrap">
                            @foreach($profile->social_media as $platform => $url)
                                <a href="{{ $url }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ ucfirst($platform) }} →
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Wallet QR Codes Section -->
        @if($profile->walletQrCodes->count() > 0)
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="px-6 py-8 sm:px-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Wallet QR Codes</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($profile->walletQrCodes as $wallet)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <img src="{{ asset('storage/' . $wallet->image_path) }}" alt="{{ $wallet->cryptocurrency_type }}" class="w-full h-64 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 capitalize">{{ $wallet->cryptocurrency_type }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Gallery Section -->
        @if($galleryItems->count() > 0)
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-8 sm:px-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Gallery</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($galleryItems as $item)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow group">
                                <div class="relative overflow-hidden bg-gray-200 h-48">
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->description }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                                <div class="p-4">
                                    @if($item->description)
                                        <p class="text-sm text-gray-700 mb-2">{{ $item->description }}</p>
                                    @endif
                                    @if($item->category)
                                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded">{{ $item->category }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($galleryItems->hasPages())
                        <div class="mt-8">
                            {{ $galleryItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <p class="text-gray-600">This profile hasn't shared any gallery images yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
