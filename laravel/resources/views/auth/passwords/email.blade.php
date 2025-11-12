@extends('layouts.app')

@section('title', 'Reset Password - DonateKudos')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="w-full max-w-md">
        <div class="card shadow-2xl">
            <!-- Header -->
            <div class="bg-gradient-brand text-white p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">Reset Password</h1>
                <p class="text-purple-100 text-sm mt-2">Verify your identity to continue</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <p class="text-gray-600 text-sm mb-6">Enter your email address and the 6-digit code from your authenticator app to reset your password.</p>

                <form action="{{ route('password.request') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            class="input-modern input-focus-ring w-full"
                            placeholder="your@email.com"
                            autocomplete="email"
                        >
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- TOTP Code -->
                    <div>
                        <label for="totp_code" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-1.418 1.418a1 1 0 101.414 1.414L9 9.414V6z" clip-rule="evenodd"></path>
                            </svg>
                            6-Digit Code
                        </label>
                        <input 
                            type="text" 
                            id="totp_code" 
                            name="totp_code" 
                            placeholder="000000" 
                            maxlength="6" 
                            inputmode="numeric" 
                            pattern="[0-9]{6}" 
                            required
                            class="input-modern input-focus-ring w-full text-center text-2xl tracking-widest font-mono"
                            autocomplete="off"
                        >
                        <p class="text-xs text-gray-600 mt-2">📱 Enter the 6-digit code from Google Authenticator, Authy, or your authenticator app</p>
                        @error('totp_code')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full">Verify & Reset Password</button>
                </form>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 px-8 py-4 bg-gray-50 text-center">
                <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
