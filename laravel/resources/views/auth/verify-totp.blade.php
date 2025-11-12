@extends('layouts.app')

@section('title', 'Verify Your Code - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Animated Card -->
        <div class="card shadow-2xl overflow-hidden">
            <!-- Header Background -->
            <div class="h-24 bg-gradient-to-br from-indigo-600 via-purple-500 to-pink-500 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full mix-blend-multiply filter blur-2xl"></div>
                </div>
                <div class="relative z-10 flex items-center justify-center h-full">
                    <i class="fas fa-key text-white text-4xl"></i>
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Enter Your Code</h1>
                    <p class="text-gray-500 flex items-center justify-center gap-2">
                        <i class="fas fa-mobile-alt"></i>
                        Check your authenticator app
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-900">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Enter the 6-digit code from your authenticator app to verify your identity.
                    </p>
                </div>

                <form action="{{ route('auth.verify-totp') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- TOTP Code Input -->
                    <div>
                        <label for="totp_code" class="form-label">
                            <i class="fas fa-barcode text-indigo-600 mr-2"></i>
                            Two-Factor Code
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
                                class="input-modern w-full text-center text-4xl tracking-[0.5em] font-bold letter-spacing font-mono"
                                autocomplete="off"
                                autofocus
                            >
                            <i class="fas fa-shield-alt absolute right-3 top-3 text-gray-400 text-lg"></i>
                        </div>
                        @error('totp_code')
                            <div class="mt-3 text-sm text-red-600 flex items-center gap-2 bg-red-50 p-3 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Verify Button -->
                    <button type="submit" class="btn-primary-lg w-full group">
                        <i class="fas fa-check group-hover:scale-110 transition-transform"></i>
                        Verify Code
                    </button>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold transition hover:gap-3">
                            <i class="fas fa-arrow-left"></i>
                            Back to Login
                        </a>
                    </div>
                </form>

                <!-- Tip Section -->
                <div class="mt-8 pt-8 border-t border-gray-200 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-lg p-4 border-l-4 border-amber-400">
                    <p class="text-sm text-amber-900">
                        <i class="fas fa-lightbulb text-amber-500 mr-2"></i>
                        <strong>Tip:</strong> Your code changes every 30 seconds. Make sure you're using the current code from your authenticator app.
                    </p>
                </div>
            </div>
        </div>

        <!-- Security Info -->
        <div class="mt-6 flex items-center justify-center gap-2 text-gray-500 text-xs">
            <i class="fas fa-lock text-green-600"></i>
            <span>This connection is encrypted and secure</span>
        </div>
    </div>
</div>
@endsection
