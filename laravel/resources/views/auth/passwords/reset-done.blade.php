@extends('layouts.app')

@section('title', 'Password Reset - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="card p-8 text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-bold gradient-text mb-3">Password Reset!</h1>
            <p class="text-gray-600 mb-6">Your password has been successfully reset.</p>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-800">
                    <strong>✓ Success!</strong> You can now login with your new password.
                </p>
            </div>

            <a href="{{ route('login') }}" class="inline-block btn-primary w-full mb-4">
                Login to Your Account
            </a>

            <div class="border-t border-gray-200 pt-4">
                <p class="text-xs text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                        Create one now
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
