@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-8 sm:px-10 border-b border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Your Profile</h1>
                        <p class="text-gray-600 mt-2">Share your profile: <a href="{{ route('profile.public', $profile->profile_url) }}" target="_blank" class="text-blue-600 hover:underline">{{ url('/@' . $profile->profile_url) }}</a></p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Profile
                        </a>
                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-700 transition-colors">
                                Delete Profile
                            </button>
                        </form>
                    </div>
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
                                    {{ ucfirst($platform) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Wallet QR Codes Section -->
        <div class="bg-white rounded-lg shadow-sm mb-8">
            <div class="px-6 py-8 sm:px-10 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Wallet QR Codes</h2>

                @if($profile->walletQrCodes->isEmpty())
                    <p class="text-gray-600 mb-6">No wallet QR codes uploaded yet.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        @foreach($profile->walletQrCodes as $wallet)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <img src="{{ asset('storage/' . $wallet->image_path) }}" alt="{{ $wallet->cryptocurrency_type }}" class="w-full h-64 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 capitalize">{{ $wallet->cryptocurrency_type }}</h3>
                                    <form method="POST" action="{{ route('profile.wallet.delete', $wallet->id) }}" class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition-colors text-sm font-medium" onclick="return confirm('Delete this wallet QR code?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Upload Wallet QR Code -->
                <form action="{{ route('profile.wallet.upload') }}" method="POST" enctype="multipart/form-data" class="border-t border-gray-200 pt-6">
                    @csrf
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Wallet QR Code</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="crypto_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Cryptocurrency Type
                            </label>
                            <input 
                                type="text" 
                                id="crypto_type" 
                                name="cryptocurrency_type"
                                placeholder="e.g., Bitcoin, Ethereum, Litecoin"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            @error('cryptocurrency_type')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="wallet_image" class="block text-sm font-medium text-gray-700 mb-2">
                                QR Code Image
                            </label>
                            <input 
                                type="file" 
                                id="wallet_image" 
                                name="image"
                                accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-gray-500 text-xs mt-1">Max 2MB. Accepted formats: JPEG, PNG, GIF</p>
                            @error('image')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition-colors">
                            Upload Wallet QR Code
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-8 sm:px-10 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Gallery</h2>

                @if($profile->galleryItems->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
                                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded mb-3">{{ $item->category }}</span>
                                    @endif
                                    <form method="POST" action="{{ route('profile.gallery.delete', $item->id) }}" class="mt-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition-colors text-sm font-medium" onclick="return confirm('Delete this image?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $galleryItems->links() }}
                @else
                    <p class="text-gray-600 mb-6">No images in your gallery yet.</p>
                @endif

                <!-- Upload Gallery Image -->
                <form action="{{ route('profile.gallery.upload') }}" method="POST" enctype="multipart/form-data" class="border-t border-gray-200 pt-6">
                    @csrf
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Gallery Image</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="gallery_image" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Image
                            </label>
                            <input 
                                type="file" 
                                id="gallery_image" 
                                name="image"
                                accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-gray-500 text-xs mt-1">Max 5MB. Accepted formats: JPEG, PNG, GIF, WebP</p>
                            @error('image')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <input 
                                type="text" 
                                id="description" 
                                name="description"
                                placeholder="What's in this image?"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Category
                            </label>
                            <input 
                                type="text" 
                                id="category" 
                                name="category"
                                placeholder="e.g., Portfolio, Event, Personal"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            @error('category')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition-colors">
                            Upload Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
