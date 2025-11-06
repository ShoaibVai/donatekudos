@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Set Up Two-Factor Authentication</h1>
        <p style="margin-bottom: 1.5rem;">Scan the QR code below with an authenticator app like Google Authenticator or Authy.</p>

        <div style="text-align: center; margin: 1.5rem 0;">
            <img src="{{ $qrCodeUrl }}" alt="QR Code" style="width: 250px; height: 250px; border: 2px solid #ddd; padding: 1rem; background: white;">
        </div>

        <div style="background-color: #f9f9f9; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <p style="color: #666; font-size: 0.875rem; margin-bottom: 0.5rem;">Or enter this secret key manually:</p>
            <code style="font-size: 1.1rem; word-break: break-all;">{{ $secret }}</code>
        </div>

        <p style="background-color: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <strong>Save this secret key in a safe place!</strong> You'll need it to recover your account if you lose access to your authenticator app.
        </p>

        <form action="{{ route('auth.totp-confirm') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="totp_code">Enter the 6-digit code from your authenticator app</label>
                <input type="text" id="totp_code" name="totp_code" placeholder="000000" maxlength="6" inputmode="numeric" required>
                @error('totp_code')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Confirm Setup</button>
        </form>
    </div>
</div>
@endsection
