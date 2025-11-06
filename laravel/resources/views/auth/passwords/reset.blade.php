@extends('layouts.app')

@section('title', 'Set New Password - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Set New Password</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">Enter your new password below.</p>

        <form action="{{ route('password.reset.confirm') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Set Password</button>

            <p style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </form>
    </div>
</div>
@endsection
