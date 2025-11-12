@extends('layouts.app')

@section('title', 'Reset Password - DonateKudos')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">
        <!-- Animated Card -->
        <div class="card shadow-2xl overflow-hidden">
            <!-- Header Background -->
            <div class="h-24 bg-gradient-to-br from-orange-600 via-red-500 to-pink-500 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full mix-blend-multiply filter blur-2xl"></div>
                </div>
                <div class="relative z-10 flex items-center justify-center h-full">
                    <i class="fas fa-key text-white text-4xl"></i>
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Reset Password</h1>
                    <p class="text-gray-500 flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i>
                        Verify your identity to continue
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-900">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Enter your email address and the 6-digit code from your authenticator app to reset your password.
                    </p>
                </div>

                <form action="{{ route('password.request') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope text-orange-600 mr-2"></i>
                            Email Address
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required
                                class="input-modern w-full pl-10"
                                placeholder="your@email.com"
                                autocomplete="email"
                            >
                            <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        @error('email')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2 bg-red-50 p-2 rounded border border-red-200">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- TOTP Code Field -->
                    <div>
                        <label for="totp_code" class="form-label">
                            <i class="fas fa-barcode text-orange-600 mr-2"></i>
                            6-Digit Code
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="totp_code" 
                                name="totp_code" 
                                placeholder="000000" 
                                maxlength="6" 
                                inputmode="numeric" 
                                pattern="[0-9]{6}" 
                                required
                                class="input-modern w-full text-center text-3xl tracking-[0.5em] font-bold font-mono"
                                autocomplete="off"
                            >
                            <i class="fas fa-shield-alt absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <i class="fas fa-mobile-alt"></i>
                            Enter the code from Google Authenticator, Authy, or your authenticator app
                        </p>
                        @error('totp_code')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2 bg-red-50 p-2 rounded border border-red-200">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary-lg w-full group">
                        <i class="fas fa-redo group-hover:scale-110 transition-transform"></i>
                        Verify & Reset Password
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-orange-600 hover:text-orange-700 font-semibold transition hover:gap-3">
                            <i class="fas fa-arrow-left"></i>
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Notice -->
        <p class="text-center text-gray-500 text-xs mt-6">
            <i class="fas fa-lock text-green-600 mr-1"></i>
            Your information is protected with 256-bit encryption
        </p>
    </div>
</div>
@endsection
