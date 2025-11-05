@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 text-center">Verify Your Identity</h1>
        <p class="text-sm text-gray-600 text-center mb-6">
            Enter the 6-digit code from your authenticator app to reset your password
        </p>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('verify-totp-forgot.store') }}" class="space-y-6">
            @csrf

            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <p class="text-sm text-blue-800">
                    Enter the 6-digit code from the authenticator app where you set up your account.
                </p>
            </div>

            <div>
                <label for="totp_code" class="block text-sm font-semibold text-gray-700 mb-2">
                    Authenticator Code
                </label>
                <input
                    type="text"
                    id="totp_code"
                    name="totp_code"
                    inputmode="numeric"
                    placeholder="000000"
                    maxlength="6"
                    pattern="\d{6}"
                    class="w-full px-4 py-2 text-center text-2xl tracking-widest font-mono border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error('totp_code') border-red-500 @enderror"
                    autocomplete="off"
                    required
                />
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
            >
                Verify & Reset Password
            </button>

            <div class="text-center">
                <a href="{{ route('forgot-password') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    ← Start over
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
