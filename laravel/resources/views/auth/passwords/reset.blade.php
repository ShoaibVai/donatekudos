@extends('layouts.app')

@section('title', 'Reset Password - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Animated Card -->
        <div class="card shadow-2xl overflow-hidden">
            <!-- Header Background -->
            <div class="h-24 bg-gradient-to-br from-green-600 via-emerald-500 to-teal-500 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full mix-blend-multiply filter blur-2xl"></div>
                </div>
                <div class="relative z-10 flex items-center justify-center h-full">
                    <i class="fas fa-lock-open text-white text-4xl"></i>
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Reset Password</h1>
                    <p class="text-gray-500 flex items-center justify-center gap-2">
                        <i class="fas fa-shield-alt"></i>
                        Create a new secure password
                    </p>
                </div>

                <form action="{{ route('password.reset.confirm') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- New Password Field -->
                    <div>
                        <label for="password" class="form-label">
                            <i class="fas fa-lock text-green-600 mr-2"></i>
                            New Password
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
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2 bg-red-50 p-2 rounded border border-red-200">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>
                            Minimum 8 characters
                        </p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
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
                        @error('password_confirmation')
                            <div class="mt-2 text-sm text-red-600 flex items-center gap-2 bg-red-50 p-2 rounded border border-red-200">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Tips -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4">
                        <p class="text-sm text-green-900 font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-shield-alt text-green-600"></i>
                            Password Security Tips:
                        </p>
                        <ul class="space-y-1 text-xs text-green-800">
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
                                Include numbers and symbols
                            </li>
                        </ul>
                    </div>

                    <!-- Reset Button -->
                    <button type="submit" class="btn-primary-lg w-full group">
                        <i class="fas fa-lock-open group-hover:scale-110 transition-transform"></i>
                        Reset Password
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            Remember your password?
                            <a href="{{ route('login') }}" class="text-green-600 font-bold hover:text-green-700 transition inline-flex items-center gap-1 ml-1">
                                Login here
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </p>
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
