@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ $profile->username }}'s Profile</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="col-span-2 bg-white rounded-lg shadow p-6">
            @if($profile->avatar_url)
                <img src="{{ $profile->avatar_url }}" alt="Avatar" class="w-32 h-32 rounded-full mb-4 object-cover">
            @endif

            <p class="text-lg text-gray-600 mb-4">{{ $profile->bio }}</p>

            @if($profile->contact_info)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-3">Contact Information</h2>
                    <dl class="space-y-2">
                        @foreach($profile->contact_info as $key => $value)
                            <div>
                                <dt class="font-medium text-gray-700">{{ ucfirst($key) }}:</dt>
                                <dd class="text-gray-600">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif

            @if($profile->wallet_addresses)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-3">Wallet Addresses</h2>
                    <div class="space-y-2">
                        @foreach($profile->wallet_addresses as $address)
                            <div class="bg-gray-50 p-2 rounded text-sm text-gray-600 break-all">
                                {{ $address }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($profile->qr_code_url)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-3">QR Code</h2>
                    <img src="{{ $profile->qr_code_url }}" alt="QR Code" class="w-48 h-48">
                </div>
            @endif
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Profile Stats</h2>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Images</span>
                    <span class="font-bold">{{ $galleries->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Member Since</span>
                    <span class="font-bold">{{ $profile->created_at->format('M Y') }}</span>
                </div>
                <div class="text-sm text-gray-500 mt-4">
                    Last updated: {{ $profile->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    @if($galleries->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold mb-6">Gallery</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($galleries as $gallery)
                    <a href="{{ $gallery->image_url }}" class="group relative overflow-hidden rounded-lg">
                        <img src="{{ $gallery->image_url }}" alt="Gallery" class="w-full h-48 object-cover group-hover:scale-105 transition">
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
