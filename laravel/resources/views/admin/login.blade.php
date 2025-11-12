@extends('layouts.app')

@section('title', 'Admin Login - DonateKudos')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="w-full max-w-md">
        <div class="card shadow-2xl">
            <!-- Header -->
            <div class="bg-gradient-brand text-white p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 mb-4">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-1.429 5.951 1.429a1 1 0 001.169-1.409l-7-14z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">Admin Access</h1>
                <p class="text-purple-100 text-sm mt-2">Enter your credentials to access the dashboard</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="{{ old('username') }}" 
                            required
                            class="input-modern input-focus-ring w-full"
                            placeholder="admin"
                            autocomplete="username"
                        >
                        @error('username')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="input-modern input-focus-ring w-full"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full">Sign In</button>
                </form>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 px-8 py-4 bg-gray-50 text-center">
                <a href="{{ route('home') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
