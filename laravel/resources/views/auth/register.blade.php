@extends('layouts.app')

@section('title', 'Create Account - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Get Started</h1>
                <p class="text-gray-600">Create your donor profile today</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="input-modern input-focus-ring" placeholder="John Doe">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="input-modern input-focus-ring" placeholder="you@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required class="input-modern input-focus-ring" placeholder="••••••••">
                    <p class="mt-2 text-xs text-gray-500">Minimum 8 characters</p>
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="input-modern input-focus-ring" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full btn-primary">Create Account</button>

                <div class="text-center">
                    <p class="text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
