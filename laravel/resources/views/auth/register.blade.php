@extends('layouts.app')

@section('title', 'Create Account - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Animated Card -->
        <div class="card shadow-2xl overflow-hidden">
            <!-- Header Background -->
            <div class="h-24 bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full mix-blend-multiply filter blur-2xl"></div>
                </div>
                <div class="relative z-10 flex items-center justify-center h-full">
                    <i class="fas fa-user-plus text-white text-4xl"></i>
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Get Started</h1>
                    <p class="text-gray-500 flex items-center justify-center gap-2">
                        <i class="fas fa-sparkles"></i>
                        Create your donor profile today
                    </p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Full Name Field -->
                    <div>
                        <label for="name" class="form-label">
                            <i class="fas fa-user text-emerald-600 mr-2"></i>
                            Full Name
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                class="input-modern w-full pl-10"
                                placeholder="John Doe"
                            >
                            <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        @error('name')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope text-emerald-600 mr-2"></i>
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
                                placeholder="you@example.com"
                            >
                            <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        @error('email')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="form-label">
                            <i class="fas fa-lock text-emerald-600 mr-2"></i>
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="input-modern w-full pl-10 pr-10"
                                placeholder="••••••••"
                            >
                            <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password')" 
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 transition"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle"></i>
                            Minimum 8 characters
                        </div>
                        @error('password')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-check-circle text-emerald-600 mr-2"></i>
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                class="input-modern w-full pl-10 pr-10"
                                placeholder="••••••••"
                            >
                            <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password_confirmation')" 
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 transition"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-xs text-blue-900 font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-shield-alt"></i>
                            Password Requirements:
                        </p>
                        <ul class="space-y-1 text-xs text-blue-800">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-600"></i>
                                At least 8 characters
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-600"></i>
                                Mix of uppercase and lowercase letters
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-600"></i>
                                Include numbers
                            </li>
                        </ul>
                    </div>

                    <!-- Create Account Button -->
                    <button type="submit" class="btn-primary-lg w-full group">
                        <i class="fas fa-rocket group-hover:scale-110 transition-transform"></i>
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                        </div>
                    </div>

                    <!-- Sign In Link -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-emerald-600 font-bold hover:text-emerald-700 transition hover:gap-3">
                            Sign in here
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-gray-500 text-xs mt-6">
            <i class="fas fa-lock text-green-600 mr-1"></i>
            Your information is protected with 256-bit encryption
        </p>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = event.target.closest('button').querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
