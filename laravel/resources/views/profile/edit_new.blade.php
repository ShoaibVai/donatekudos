@extends('layouts.app')

@section('title', 'Edit Profile - DonateKudos')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Header -->
    <div class="mb-12">
        <a href="{{ route('profile.index') }}" class="text-violet-600 hover:text-violet-700 font-semibold mb-4 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>Back to Profile
        </a>
        <h1 class="text-5xl font-bold gradient-text mb-3">Edit Profile</h1>
        <p class="text-gray-600 text-lg">Customize your donation profile and media</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="profileForm">
        @csrf
        @method('PUT')

        <!-- Contact Information Card -->
        <div class="card-hover overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-phone text-cyan-600"></i>Contact Information
                </h2>
                <p class="text-sm text-gray-600 mt-1">Phone, website, address, and other contact details</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Phone Number</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-phone"></i></span>
                            <input 
                                type="tel" 
                                class="input-modern pl-10" 
                                placeholder="+1 (555) 123-4567"
                                id="phone_input"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Website</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-globe"></i></span>
                            <input 
                                type="url" 
                                class="input-modern pl-10" 
                                placeholder="https://example.com"
                                id="website_input"
                            >
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Full Address</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-map-marker-alt"></i></span>
                        <textarea 
                            class="input-modern pl-10 resize-none"
                            rows="2"
                            placeholder="123 Main St, New York, NY 10001"
                            id="address_input"
                        ></textarea>
                    </div>
                </div>
                <div>
                    <label class="form-label">JSON Data (Advanced)</label>
                    <textarea 
                        id="contact_info" 
                        name="contact_info" 
                        rows="5" 
                        class="input-modern font-mono text-sm w-full"
                        placeholder='{"phone": "+1234567890", "website": "https://example.com", "address": "123 Main St"}'
                    >{{ ($profile && $profile->contact_info) ? json_encode($profile->contact_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                    <p class="text-xs text-gray-600 mt-2"><i class="fas fa-info-circle"></i> Or enter raw JSON data directly</p>
                    @error('contact_info')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Wallet Addresses Card -->
        <div class="card-hover overflow-hidden">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-wallet text-amber-600"></i>Cryptocurrency Wallets
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add your crypto wallet addresses for donations</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">
                            <i class="fab fa-bitcoin text-orange-600"></i> Bitcoin Address
                        </label>
                        <input 
                            type="text" 
                            class="input-modern" 
                            placeholder="1A1z7agoat8VXxU8g9hJrGT8vFjUDfXFbq"
                            id="bitcoin_input"
                        >
                    </div>
                    <div>
                        <label class="form-label">
                            <i class="fab fa-ethereum text-blue-600"></i> Ethereum Address
                        </label>
                        <input 
                            type="text" 
                            class="input-modern" 
                            placeholder="0x742d35Cc6634C0532925a3b844Bc9e7595f42D8F"
                            id="ethereum_input"
                        >
                    </div>
                    <div>
                        <label class="form-label">
                            Litecoin Address
                        </label>
                        <input 
                            type="text" 
                            class="input-modern" 
                            placeholder="LN8oW7d4dHvwrVKvVSDWSpBjP1mS5d2sG"
                            id="litecoin_input"
                        >
                    </div>
                    <div>
                        <label class="form-label">Other Wallet</label>
                        <input 
                            type="text" 
                            class="input-modern" 
                            placeholder="Other cryptocurrency address"
                            id="other_wallet_input"
                        >
                    </div>
                </div>
                <div>
                    <label class="form-label">JSON Data (Advanced)</label>
                    <textarea 
                        id="wallet_addresses" 
                        name="wallet_addresses" 
                        rows="5" 
                        class="input-modern font-mono text-sm w-full"
                        placeholder='{"bitcoin": "1A1z7agoat", "ethereum": "0x1234"}'
                    >{{ ($profile && $profile->wallet_addresses) ? json_encode($profile->wallet_addresses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                    <p class="text-xs text-gray-600 mt-2"><i class="fas fa-info-circle"></i> Or enter raw JSON data directly</p>
                    @error('wallet_addresses')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- QR Code Upload Card -->
        <div class="card-hover overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-qrcode text-violet-600"></i>QR Code
                </h2>
                <p class="text-sm text-gray-600 mt-1">Upload a QR code for easy profile sharing</p>
            </div>
            <div class="p-6">
                @if($profile && $profile->qr_code_path)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-700 mb-3 font-semibold">Current QR Code:</p>
                        <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="Current QR Code" class="w-32 h-32 object-contain rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Upload a new image to replace it</p>
                    </div>
                @endif
                <div>
                    <label for="qr_code" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-upload mr-2"></i>Upload QR Code
                    </label>
                    <div class="border-2 border-dashed border-violet-300 rounded-lg p-8 text-center hover:bg-violet-50 hover:border-violet-400 transition cursor-pointer" id="qr_drop_zone">
                        <input 
                            type="file" 
                            id="qr_code" 
                            name="qr_code" 
                            accept="image/*"
                            class="hidden"
                            onchange="previewQRCode(event)"
                        >
                        <div class="flex flex-col items-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-violet-400 mb-3"></i>
                            <p class="text-gray-900 font-semibold">Drop your QR code here</p>
                            <p class="text-sm text-gray-600">or click to browse (Max 2MB)</p>
                            <p class="text-xs text-gray-500 mt-2">Supported: JPG, PNG</p>
                        </div>
                    </div>
                    <div id="qr_preview" class="mt-4"></div>
                    @error('qr_code')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Gallery Upload Card -->
        <div class="card-hover overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-images text-emerald-600"></i>Photo Gallery
                </h2>
                <p class="text-sm text-gray-600 mt-1">Upload multiple photos to showcase your charitable journey</p>
            </div>
            <div class="p-6">
                @if($galleries && $galleries->count() > 0)
                    <div class="mb-6">
                        <p class="text-sm text-gray-700 font-semibold mb-3">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>Current Gallery ({{ $galleries->count() }} photos)
                        </p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($galleries as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery" class="w-full h-32 object-cover rounded-lg shadow-sm">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank" class="p-2 bg-white rounded-full hover:bg-gray-100">
                                            <i class="fas fa-expand text-gray-900"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-600 mt-3"><i class="fas fa-info-circle"></i> Add more photos below to expand your gallery</p>
                    </div>
                @endif
                <div>
                    <label for="gallery_images" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-upload mr-2"></i>Add More Photos
                    </label>
                    <div class="border-2 border-dashed border-emerald-300 rounded-lg p-8 text-center hover:bg-emerald-50 hover:border-emerald-400 transition cursor-pointer" id="gallery_drop_zone">
                        <input 
                            type="file" 
                            id="gallery_images" 
                            name="gallery_images[]" 
                            accept="image/*"
                            multiple
                            class="hidden"
                            onchange="previewGalleryImages(event)"
                        >
                        <div class="flex flex-col items-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-emerald-400 mb-3"></i>
                            <p class="text-gray-900 font-semibold">Drop images here</p>
                            <p class="text-sm text-gray-600">or click to browse (Max 2MB each)</p>
                            <p class="text-xs text-gray-500 mt-2">Supported: JPG, PNG</p>
                        </div>
                    </div>
                    <div id="gallery_preview" class="mt-4"></div>
                    @error('gallery_images.*')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <button type="submit" class="btn-primary-lg flex-1">
                <i class="fas fa-save mr-2"></i>Save Changes
            </button>
            <a href="{{ route('profile.index') }}" class="btn-ghost text-center py-2.5 px-6">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // QR Code drag and drop
    const qrDropZone = document.getElementById('qr_drop_zone');
    const qrInput = document.getElementById('qr_code');
    
    qrDropZone.addEventListener('click', () => qrInput.click());
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
        qrDropZone.addEventListener(event, preventDefaults);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    qrDropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        qrInput.files = files;
        previewQRCode({ target: { files } });
    });

    function previewQRCode(event) {
        const files = event.target.files;
        const preview = document.getElementById('qr_preview');
        preview.innerHTML = '';
        
        if (files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.innerHTML = `
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-700 mb-2">New QR Code Preview:</p>
                        <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-contain rounded">
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    }

    // Gallery drag and drop
    const galleryDropZone = document.getElementById('gallery_drop_zone');
    const galleryInput = document.getElementById('gallery_images');
    
    galleryDropZone.addEventListener('click', () => galleryInput.click());
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
        galleryDropZone.addEventListener(event, preventDefaults);
    });
    
    galleryDropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        galleryInput.files = files;
        previewGalleryImages({ target: { files } });
    });

    function previewGalleryImages(event) {
        const files = event.target.files;
        const preview = document.getElementById('gallery_preview');
        preview.innerHTML = '';
        
        if (files.length > 0) {
            let html = '<div class="p-4 bg-gray-50 rounded-lg border border-gray-200"><p class="text-sm text-gray-700 mb-3">New Images Preview:</p><div class="grid grid-cols-2 md:grid-cols-4 gap-3">';
            
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative';
                    previewItem.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded">`;
                    preview.querySelector('.grid') && preview.querySelector('.grid').appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
            
            html += '</div></div>';
            if (preview.innerHTML === '') preview.innerHTML = html;
        }
    }

    // Form submission with JSON conversion
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const phone = document.getElementById('phone_input').value;
        const website = document.getElementById('website_input').value;
        const address = document.getElementById('address_input').value;
        const contactInfo = document.getElementById('contact_info');
        
        if ((phone || website || address) && !contactInfo.value) {
            contactInfo.value = JSON.stringify({
                ...(phone && { phone }),
                ...(website && { website }),
                ...(address && { address })
            });
        }

        const bitcoin = document.getElementById('bitcoin_input').value;
        const ethereum = document.getElementById('ethereum_input').value;
        const litecoin = document.getElementById('litecoin_input').value;
        const otherWallet = document.getElementById('other_wallet_input').value;
        const walletField = document.getElementById('wallet_addresses');
        
        if ((bitcoin || ethereum || litecoin || otherWallet) && !walletField.value) {
            walletField.value = JSON.stringify({
                ...(bitcoin && { bitcoin }),
                ...(ethereum && { ethereum }),
                ...(litecoin && { litecoin }),
                ...(otherWallet && { other: otherWallet })
            });
        }
    });
</script>
@endsection
