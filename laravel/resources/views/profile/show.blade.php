@extends('layouts.app')

@section('title', $user->name . ' - DonateKudos')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h1>{{ $user->name }}'s Profile</h1>
        <p>Member since {{ $user->created_at->format('F Y') }}</p>
    </div>

    @if($profile)
        @if($profile->contact_info)
            <div class="card">
                <h2>Contact Information</h2>
                <pre>{{ json_encode($profile->contact_info, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif

        @if($profile->wallet_addresses)
            <div class="card">
                <h2>Wallet Addresses</h2>
                <pre>{{ json_encode($profile->wallet_addresses, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif

        @if($profile->qr_code_path)
            <div class="card">
                <h2>QR Code</h2>
                <img src="{{ asset('storage/' . $profile->qr_code_path) }}" alt="QR Code" style="max-width: 300px; height: auto;">
            </div>
        @endif
    @endif

    @if($galleries->count() > 0)
        <div class="card">
            <h2>Gallery</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                @foreach($galleries as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 4px;">
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
