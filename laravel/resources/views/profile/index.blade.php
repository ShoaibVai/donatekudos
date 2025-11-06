@extends('layouts.app')

@section('title', $user->name . ' - DonateKudos')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h1>{{ $user->name }}'s Profile</h1>
        <p>{{ $user->email }}</p>

        @if(Auth::check() && Auth::user()->id === $user->id)
            <div style="margin-top: 1rem;">
                <a href="{{ route('profile.edit') }}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #3498db; color: white; text-decoration: none; border-radius: 4px;">Edit Profile</a>
            </div>
        @endif
    </div>

    @if($profile)
        <div class="card">
            <h2>Contact Information</h2>
            @if($profile->contact_info)
                <pre>{{ json_encode($profile->contact_info, JSON_PRETTY_PRINT) }}</pre>
            @else
                <p style="color: #666;">No contact information provided.</p>
            @endif
        </div>

        <div class="card">
            <h2>Wallet Addresses</h2>
            @if($profile->wallet_addresses)
                <pre>{{ json_encode($profile->wallet_addresses, JSON_PRETTY_PRINT) }}</pre>
            @else
                <p style="color: #666;">No wallet addresses provided.</p>
            @endif
        </div>

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

    @if(Auth::check() && Auth::user()->id === $user->id)
        <div class="card" style="background-color: #ffe6e6; border: 1px solid #ffcccc;">
            <h2 style="color: #c0392b;">Danger Zone</h2>
            <p style="margin-bottom: 1rem;">Deleting your account is permanent and cannot be undone. All your data will be archived in our system.</p>
            <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete My Account</button>
            </form>
        </div>
    @endif
</div>
@endsection
