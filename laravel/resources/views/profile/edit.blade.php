@extends('layouts.app')

@section('title', 'Edit Profile - DonateKudos')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h1>Edit Your Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2>Contact Information</h2>
            <div class="form-group">
                <label for="contact_info">Contact Information (JSON)</label>
                <textarea id="contact_info" name="contact_info" rows="6" placeholder='{"phone": "+1234567890", "website": "https://example.com"}'>{{ $profile->contact_info ? json_encode($profile->contact_info, JSON_PRETTY_PRINT) : '' }}</textarea>
                <small style="color: #666; display: block; margin-top: 0.25rem;">Enter contact details as JSON format.</small>
                @error('contact_info')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <h2>Wallet Addresses</h2>
            <div class="form-group">
                <label for="wallet_addresses">Wallet Addresses (JSON)</label>
                <textarea id="wallet_addresses" name="wallet_addresses" rows="6" placeholder='{"bitcoin": "1A1z7agoat", "ethereum": "0x1234"}'>{{ $profile->wallet_addresses ? json_encode($profile->wallet_addresses, JSON_PRETTY_PRINT) : '' }}</textarea>
                <small style="color: #666; display: block; margin-top: 0.25rem;">Enter wallet addresses as JSON format.</small>
                @error('wallet_addresses')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <h2>QR Code</h2>
            <div class="form-group">
                <label for="qr_code">Upload QR Code</label>
                @if($profile->qr_code_path)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="Current QR Code" style="max-width: 200px; height: auto;">
                    </div>
                @endif
                <input type="file" id="qr_code" name="qr_code" accept="image/*">
                <small style="color: #666; display: block; margin-top: 0.25rem;">JPG, PNG up to 2MB</small>
                @error('qr_code')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <h2>Gallery Images</h2>
            <div class="form-group">
                <label for="gallery_images">Upload Gallery Images</label>
                <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                <small style="color: #666; display: block; margin-top: 0.25rem;">JPG, PNG up to 2MB each. You can select multiple files.</small>
                @error('gallery_images.*')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            @if($galleries->count() > 0)
                <div style="margin-bottom: 1.5rem;">
                    <h3>Current Gallery</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        @foreach($galleries as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                        @endforeach
                    </div>
                </div>
            @endif

            <div style="display: flex; gap: 1rem;">
                <button type="submit">Save Changes</button>
                <a href="{{ route('profile.index') }}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #95a5a6; color: white; text-decoration: none; border-radius: 4px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
