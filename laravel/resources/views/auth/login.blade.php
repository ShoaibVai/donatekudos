@extends('layouts.app')

@section('title', 'Login - DonateKudos')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h1>Sign In to DonateKudos</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">Welcome back! Please log in to your account.</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="errors">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Sign In</button>

            <p style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            </p>

            <p style="text-align: center;">
                Don't have an account? <a href="{{ route('register') }}">Create one here</a>
            </p>
        </form>
    </div>
</div>
@endsection
