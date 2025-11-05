@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Set Up Authenticator</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="space-y-6">
            <!-- QR Code Section -->
            <div class="bg-gray-50 p-6 rounded-lg border-2 border-dashed border-gray-300">
                <p class="text-sm font-semibold text-gray-700 mb-4 text-center">Scan this QR code with your authenticator app</p>
                <div class="flex justify-center">
                    <img src="{{ $qrCodeUrl }}" alt="TOTP QR Code" class="w-48 h-48 border border-gray-300 rounded">
                </div>
            </div>

            <!-- Manual Entry Section -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <p class="text-sm font-semibold text-gray-700 mb-2">Can't scan the QR code?</p>
                <p class="text-xs text-gray-600 mb-3">Enter this key manually in your authenticator app:</p>
                <div class="flex items-center gap-2 bg-white p-3 rounded border border-gray-300">
                    <code class="text-sm font-mono text-gray-900 flex-1 break-all">{{ $secret }}</code>
                    <button type="button" onclick="copyToClipboard('{{ $secret }}')" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Copy
                    </button>
                </div>
            </div>

            <!-- Verification Section -->
            <form action="{{ route('verify-totp') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Enter 6-digit code from your authenticator app
                    </label>
                    <input
                        type="text"
                        id="code"
                        name="code"
                        inputmode="numeric"
                        placeholder="000000"
                        maxlength="6"
                        pattern="\d{6}"
                        class="w-full px-4 py-2 text-center text-2xl tracking-widest font-mono border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error('code') border-red-500 @enderror"
                        autocomplete="off"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                >
                    Verify & Complete Setup
                </button>
            </form>

            <!-- Info Section -->
            <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                <p class="text-xs text-gray-700">
                    <strong>Important:</strong> Save your authenticator app secret securely. You'll need it to verify your identity when resetting your password.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Secret copied to clipboard!');
    });
}
</script>
@endsection
