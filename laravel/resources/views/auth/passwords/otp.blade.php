@extends('layouts.app')

@section('title', 'Verify OTP - DonateKudos')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="w-full max-w-md">
        <div class="card shadow-2xl">
            <!-- Header -->
            <div class="bg-gradient-brand text-white p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 mb-4">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">Verify Your Identity</h1>
                <p class="text-purple-100 text-sm mt-2">Enter the 6-digit code to continue</p>
            </div>

            <!-- OTP Display -->
            <div class="px-8 pt-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center mb-6">
                    <p class="text-xs text-blue-600 uppercase font-semibold mb-3">Your One-Time Password</p>
                    <p class="text-4xl font-bold text-blue-600 font-mono tracking-widest">{{ $otp }}</p>
                    <p class="text-xs text-blue-600 mt-3">⏱️ Valid for 10 minutes</p>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                    <p class="text-xs text-gray-600 uppercase font-semibold mb-2">Account Email</p>
                    <p class="text-sm font-mono text-gray-900">{{ $email }}</p>
                </div>
            </div>

            <!-- Form -->
            <div class="px-8 pb-8">
                <p class="text-gray-600 text-sm mb-6">Enter the 6-digit code shown above to verify your identity.</p>

                <form action="{{ route('password.reset.otp.verify') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- OTP Input -->
                    <div>
                        <label for="otp_code" class="block text-sm font-semibold text-gray-700 mb-3">Enter Code</label>
                        <input 
                            type="text" 
                            id="otp_code" 
                            name="otp_code" 
                            placeholder="000000" 
                            maxlength="6" 
                            inputmode="numeric" 
                            required
                            autofocus
                            class="input-modern input-focus-ring w-full text-center text-2xl tracking-widest font-mono"
                            autocomplete="off"
                        >
                        <p class="text-xs text-gray-600 mt-2">📨 Or check your email for the code</p>
                        @error('otp_code')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full">Verify OTP</button>
                </form>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 px-8 py-4 bg-gray-50 text-center">
                <a href="{{ route('password.request') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm inline-flex items-center gap-1 justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Request New OTP
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
