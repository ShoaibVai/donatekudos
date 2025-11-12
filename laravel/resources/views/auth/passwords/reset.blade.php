@extends('layouts.app')

@section('title', 'Reset Password - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Reset Password</h1>
                <p class="text-gray-600">Create a new secure password</p>
            </div>

            <form action="{{ route('password.reset.confirm') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        New Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="input-modern input-focus-ring"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm Password
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        class="input-modern input-focus-ring"
                        placeholder="••••••••"
                    >
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-800">
                        <strong>✓ Password Tips:</strong> Use a mix of uppercase, lowercase, numbers, and symbols for better security.
                    </p>
                </div>

                <button type="submit" class="w-full btn-primary">Reset Password</button>

                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-600 text-center">
                        Remember your password?
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Login here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
