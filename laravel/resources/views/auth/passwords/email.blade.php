@extends('layouts.app')

@section('title', 'Reset Password - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Forgot Password?</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">Enter your email address and the 6-digit code from your authenticator app to reset your password.</p>

        <form action="{{ route('password.request') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="totp_code">6-Digit Authenticator Code</label>
                <input type="text" id="totp_code" name="totp_code" placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required>
                <small style="color: #666; display: block; margin-top: 0.25rem;">Enter the 6-digit code from Google Authenticator, Authy, or your authenticator app.</small>
                @error('totp_code')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Verify & Reset Password</button>

            <p style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </form>
    </div>
</div>
@endsection
