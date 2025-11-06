@extends('layouts.app')

@section('title', 'Verify OTP - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Verify OTP</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">A 6-digit OTP has been generated for your account. Enter it below to proceed with password reset.</p>

        <div style="background-color: #e3f2fd; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; text-align: center;">
            <p style="color: #1976d2; font-weight: bold; font-size: 1.5rem; margin: 0; letter-spacing: 0.3em;">{{ $otp }}</p>
            <small style="color: #1976d2; display: block; margin-top: 0.5rem;">Your OTP (valid for 10 minutes)</small>
        </div>

        <p style="background-color: #f5f5f5; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.875rem;">
            Account: <strong>{{ $email }}</strong>
        </p>

        <form action="{{ route('password.reset.otp.verify') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="otp_code">Enter 6-digit OTP Code</label>
                <input type="text" id="otp_code" name="otp_code" placeholder="000000" maxlength="6" inputmode="numeric" required autofocus>
                <small style="color: #666; display: block; margin-top: 0.25rem;">Enter the OTP shown above or the one sent to your email.</small>
                @error('otp_code')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Verify OTP</button>

            <p style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('password.request') }}">Request new OTP</a>
            </p>
        </form>
    </div>
</div>
@endsection
