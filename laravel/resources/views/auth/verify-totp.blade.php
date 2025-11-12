@extends('layouts.app')

@section('title', 'Verify Your Code - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Enter Your Code</h1>
                <p class="text-gray-600">Check your authenticator app</p>
            </div>

            <form action="{{ route('auth.verify-totp') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        Enter the 6-digit code from your authenticator app to verify your identity.
                    </p>
                </div>

                <div>
                    <label for="totp_code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Two-Factor Code
                    </label>
                    <input 
                        type="text" 
                        id="totp_code" 
                        name="totp_code" 
                        placeholder="000000" 
                        maxlength="6" 
                        inputmode="numeric" 
                        pattern="[0-9]{6}" 
                        required 
                        class="input-modern input-focus-ring text-center text-4xl tracking-widest font-mono"
                        autocomplete="off"
                        autofocus
                    >
                    @error('totp_code')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                            <span>❌</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-primary">Verify</button>

                <div class="border-t border-gray-200 pt-4">
                    <p class="text-xs text-gray-600 text-center">
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Back to Login
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs text-gray-600 text-center">
                💡 <strong>Tip:</strong> Your code changes every 30 seconds. Use the current code from your app.
            </p>
        </div>
    </div>
</div>
@endsection
