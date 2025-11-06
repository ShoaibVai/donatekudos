@extends('layouts.app')

@section('title', 'Verify Two-Factor Code - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Two-Factor Authentication</h1>
        <p style="margin-bottom: 1.5rem;">Please enter the 6-digit code from your authenticator app.</p>

        <form action="{{ route('auth.verify-totp') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="totp_code">Authenticator Code</label>
                <input type="text" id="totp_code" name="totp_code" placeholder="000000" maxlength="6" inputmode="numeric" required autofocus>
                @error('totp_code')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" value="1">
                    Remember this device for 30 days
                </label>
            </div>

            <button type="submit">Verify</button>

            <p style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </form>
    </div>
</div>
@endsection
