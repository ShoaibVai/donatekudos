@extends('layouts.app')

@section('title', 'Edit Profile - DonateKudos')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Edit Profile</h1>
        <p class="text-gray-600">Update your profile information and media</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Contact Information Section -->
        <div class="card mb-6">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900">Contact Information</h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label for="contact_info" class="block text-sm font-semibold text-gray-700 mb-2">Contact Details (JSON)</label>
                    <textarea 
                        id="contact_info" 
                        name="contact_info" 
                        rows="6" 
                        class="input-modern input-focus-ring w-full font-mono text-sm"
                        placeholder='{"phone": "+1234567890", "website": "https://example.com"}'
                    >{{ ($profile && $profile->contact_info) ? json_encode($profile->contact_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                    <p class="text-xs text-gray-600 mt-2">📝 Enter your contact details in JSON format. Common fields: phone, website, email, address</p>
                    @error('contact_info')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Wallet Addresses Section -->
        <div class="card mb-6">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900">Wallet Addresses</h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label for="wallet_addresses" class="block text-sm font-semibold text-gray-700 mb-2">Crypto Wallets (JSON)</label>
                    <textarea 
                        id="wallet_addresses" 
                        name="wallet_addresses" 
                        rows="6" 
                        class="input-modern input-focus-ring w-full font-mono text-sm"
                        placeholder='{"bitcoin": "1A1z7agoat", "ethereum": "0x1234"}'
                    >{{ ($profile && $profile->wallet_addresses) ? json_encode($profile->wallet_addresses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                    <p class="text-xs text-gray-600 mt-2">💰 Add your cryptocurrency wallet addresses. Supported: bitcoin, ethereum, litecoin, and more</p>
                    @error('wallet_addresses')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="card mb-6">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900">QR Code</h2>
            </div>
            <div class="p-6">
                @if($profile && $profile->qr_code_path)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700 mb-3 font-semibold">Current QR Code:</p>
                        <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="Current QR Code" class="w-48 h-48 object-cover rounded-lg">
                    </div>
                @endif
                <div>
                    <label for="qr_code" class="block text-sm font-semibold text-gray-700 mb-3">Upload New QR Code</label>
                    <div class="border-2 border-dashed border-purple-300 rounded-lg p-6 text-center cursor-pointer hover:bg-purple-50 transition">
                        <input 
                            type="file" 
                            id="qr_code" 
                            name="qr_code" 
                            accept="image/*"
                            class="hidden"
                            onchange="document.getElementById('qr-filename').textContent = this.files[0]?.name || 'Select file'"
                        >
                        <label for="qr_code" class="cursor-pointer block">
                            <svg class="w-10 h-10 mx-auto text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-sm font-semibold text-gray-700">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-600">JPG, PNG up to 2MB</p>
                        </label>
                    </div>
                    <p id="qr-filename" class="text-sm text-gray-600 mt-2"></p>
                    @error('qr_code')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="card mb-6">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900">Gallery Images</h2>
            </div>
            <div class="p-6">
                <!-- Current Gallery -->
                @if($galleries && $galleries->count() > 0)
                    <div class="mb-8">
                        <p class="text-sm font-semibold text-gray-700 mb-4">📸 Current Gallery ({{ $galleries->count() }} images)</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($galleries as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="w-full h-32 object-cover rounded-lg">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-8"></div>
                @endif

                <!-- Upload New Images -->
                <div>
                    <label for="gallery_images" class="block text-sm font-semibold text-gray-700 mb-3">Upload New Images</label>
                    <div class="border-2 border-dashed border-purple-300 rounded-lg p-8 text-center cursor-pointer hover:bg-purple-50 transition">
                        <input 
                            type="file" 
                            id="gallery_images" 
                            name="gallery_images[]" 
                            accept="image/*" 
                            multiple
                            class="hidden"
                            onchange="document.getElementById('gallery-count').textContent = this.files.length + ' file(s) selected'"
                        >
                        <label for="gallery_images" class="cursor-pointer block">
                            <svg class="w-10 h-10 mx-auto text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-semibold text-gray-700">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-600">JPG, PNG up to 2MB each. Select multiple files</p>
                        </label>
                    </div>
                    <p id="gallery-count" class="text-sm text-gray-600 mt-2"></p>
                    @error('gallery_images.*')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('profile.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
