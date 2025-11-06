@extends('layouts.app')

@section('title', 'Set Up Authenticator - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Set Up Authenticator</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">A new authenticator secret has been generated. Please set it up now.</p>

        <div style="text-align: center; margin: 1.5rem 0;">
            <img src="{{ $qrCodeUrl }}" alt="QR Code" style="width: 250px; height: 250px; border: 2px solid #ddd; padding: 1rem; background: white;">
        </div>

        <div style="background-color: #f9f9f9; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <p style="color: #666; font-size: 0.875rem; margin-bottom: 0.5rem;">Or enter this secret key manually:</p>
            <code style="font-size: 1.1rem; word-break: break-all;">{{ $secret }}</code>
        </div>

        <p style="background-color: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <strong>Save this secret key in a safe place!</strong> You'll need it to reset your password if you forget it again.
        </p>

        <a href="{{ route('login') }}" style="display: block; text-align: center; padding: 0.75rem; background-color: #3498db; color: white; text-decoration: none; border-radius: 4px;">Continue to Login</a>
    </div>
</div>
@endsection
