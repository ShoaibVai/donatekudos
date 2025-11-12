@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Secure Your Account</h1>
                <p class="text-gray-600">Set up two-factor authentication</p>
            </div>

            <form action="{{ route('auth.totp-confirm') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        <strong>📱 What is 2FA?</strong> Two-factor authentication adds an extra layer of security to your account by requiring a code from your authenticator app.
                    </p>
                </div>

                <div class="text-center">
                    <p class="text-sm font-semibold text-gray-700 mb-4">Step 1: Scan QR Code</p>
                    <div class="flex justify-center">
                        <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-48 h-48 border-4 border-purple-200 rounded-lg p-2 bg-white">
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Scan with Google Authenticator, Authy, or Microsoft Authenticator</p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <p class="text-xs font-semibold text-gray-600 mb-2">Or enter manually:</p>
                    <div class="flex items-center gap-2">
                        <code class="flex-1 text-center font-mono text-sm p-2 bg-white border border-gray-200 rounded break-all">{{ $secret }}</code>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $secret }}')" class="px-3 py-2 bg-white border border-gray-200 rounded hover:bg-gray-100 transition">
                            📋
                        </button>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">
                        <strong>⚠️ Save your secret key</strong> in a safe place. You'll need it to recover your account if you lose access to your authenticator app.
                    </p>
                </div>

                <div>
                    <label for="totp_code" class="block text-sm font-semibold text-gray-700 mb-2">Enter the 6-digit code from your app</label>
                    <input type="text" id="totp_code" name="totp_code" placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required class="input-modern input-focus-ring text-center text-2xl tracking-widest">
                    @error('totp_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-primary">Verify & Continue</button>
            </form>
        </div>
    </div>
</div>
@endsection
