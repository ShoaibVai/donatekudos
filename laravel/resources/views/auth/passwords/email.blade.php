@extends('layouts.app')

@section('title', 'Reset Password - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Reset Password</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">Enter your email and recovery token (the secret key from your registration) to reset your password.</p>

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
                <label for="recovery_token">Recovery Token (Your TOTP Secret)</label>
                <input type="text" id="recovery_token" name="recovery_token" placeholder="Paste your recovery token here" required>
                <small style="color: #666; display: block; margin-top: 0.25rem;">This is the 32-character secret key you received during registration.</small>
                @error('recovery_token')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Next Step</button>

            <p style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </form>
    </div>
</div>
@endsection
