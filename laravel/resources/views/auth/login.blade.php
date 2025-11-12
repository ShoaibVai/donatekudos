@extends('layouts.app')

@section('title', 'Sign In - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Animated Card -->
        <div class="card shadow-2xl overflow-hidden">
            <!-- Header Background -->
            <div class="h-24 bg-gradient-to-br from-violet-600 via-purple-500 to-pink-500 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full mix-blend-multiply filter blur-2xl"></div>
                </div>
                <div class="relative z-10 flex items-center justify-center h-full">
                    <i class="fas fa-lock text-white text-4xl"></i>
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome Back</h1>
                    <p class="text-gray-500 flex items-center justify-center gap-2">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign in to your account
                    </p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope text-violet-600 mr-2"></i>
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
                            <i class="fas fa-lock text-violet-600 mr-2"></i>
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
                        @error('password')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded border-2 border-gray-300 text-violet-600 cursor-pointer transition accent-violet-600">
                        <span class="text-gray-600 group-hover:text-gray-900 transition">Remember me</span>
                    </label>

                    <!-- Sign In Button -->
                    <button type="submit" class="btn-primary-lg w-full group">
                        <i class="fas fa-sign-in-alt group-hover:scale-110 transition-transform"></i>
                        Sign In
                    </button>

                    <!-- Divider -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">or</span>
                        </div>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="inline-flex items-center gap-2 text-violet-600 hover:text-violet-700 font-semibold transition hover:gap-3">
                            <i class="fas fa-redo"></i>
                            Forgot your password?
                        </a>
                    </div>
                </form>

                <!-- Sign Up Link -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-violet-600 font-bold hover:text-violet-700 transition inline-flex items-center gap-1 ml-1">
                            Sign up now
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-gray-500 text-xs mt-6">
            <i class="fas fa-shield-alt text-green-600 mr-1"></i>
            Your data is secure and encrypted
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
