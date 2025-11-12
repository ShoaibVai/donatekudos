@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication - DonateKudos')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">
        <!-- Animated Card -->
        <div class="card shadow-2xl overflow-hidden">
            <!-- Header Background -->
            <div class="h-24 bg-gradient-to-br from-red-600 via-rose-500 to-pink-500 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full mix-blend-multiply filter blur-2xl"></div>
                </div>
                <div class="relative z-10 flex items-center justify-center h-full">
                    <i class="fas fa-shield-alt text-white text-4xl"></i>
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Secure Your Account</h1>
                    <p class="text-gray-500 flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i>
                        Set up two-factor authentication
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-900">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <strong>What is 2FA?</strong> Two-factor authentication adds an extra layer of security to your account by requiring a code from your authenticator app.
                    </p>
                </div>

                <form action="{{ route('auth.totp-confirm') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Step 1: Scan QR Code -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 font-bold">1</span>
                            Scan QR Code
                        </h3>
                        <div class="flex justify-center p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border-2 border-dashed border-gray-300">
                            <div class="relative">
                                <img 
                                    src="{{ $qrCodeUrl }}" 
                                    alt="QR Code" 
                                    class="w-56 h-56 border-4 border-white rounded-lg p-2 bg-white shadow-lg"
                                >
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3 text-center">
                            <i class="fas fa-check-circle text-green-600 mr-1"></i>
                            Scan with Google Authenticator, Authy, or Microsoft Authenticator
                        </p>
                    </div>

                    <!-- Step 2: Manual Entry -->
                    <div class="border-t-2 pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-600 font-bold">2</span>
                            Or Enter Manually
                        </h3>
                        <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-3 flex items-center gap-2">
                                <i class="fas fa-key text-amber-600"></i>
                                Your Secret Key:
                            </p>
                            <div class="flex items-center gap-2">
                                <code class="flex-1 text-center font-mono text-sm p-3 bg-white border border-gray-300 rounded-lg break-all text-gray-900 font-bold">{{ $secret }}</code>
                                <button 
                                    type="button" 
                                    onclick="copyToClipboard('{{ $secret }}')" 
                                    class="px-3 py-3 bg-white border-2 border-gray-300 rounded-lg hover:border-amber-400 hover:bg-amber-50 transition"
                                    title="Copy to clipboard"
                                >
                                    <i class="fas fa-copy text-amber-600"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Warning -->
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-lg p-4">
                        <p class="text-sm text-yellow-900">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <strong>Save your secret key</strong> in a safe place. You'll need it to recover your account if you lose access to your authenticator app.
                        </p>
                    </div>

                    <!-- Step 4: Verify Code -->
                    <div class="border-t-2 pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold">3</span>
                            Verify Code
                        </h3>
                        <label for="totp_code" class="form-label mb-3">
                            <i class="fas fa-check-square text-green-600 mr-2"></i>
                            Enter the 6-digit code from your app
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="totp_code" 
                                name="totp_code" 
                                placeholder="000000" 
                                maxlength="6" 
                                inputmode="numeric" 
                                pattern="[0-9]{6}" 
                                required 
                                class="input-modern w-full text-center text-4xl tracking-[0.5em] font-bold letter-spacing font-mono"
                            >
                            <i class="fas fa-barcode absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
                        </div>
                        @error('totp_code')
                            <div class="mt-3 text-sm text-red-600 flex items-center gap-2 bg-red-50 p-3 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            Code changes every 30 seconds
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary-lg w-full group">
                        <i class="fas fa-check-circle group-hover:scale-110 transition-transform"></i>
                        Verify & Continue
                    </button>
                </form>

                <!-- Security Tips -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-amber-500"></i>
                        Security Tips
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Keep your secret key in a secure location</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Never share your 2FA code with anyone</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Use an authenticator app, not SMS when possible</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target.closest('button');
        const originalIcon = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check text-green-600"></i>';
        btn.classList.add('border-green-400', 'bg-green-50');
        setTimeout(() => {
            btn.innerHTML = originalIcon;
            btn.classList.remove('border-green-400', 'bg-green-50');
        }, 2000);
    });
}
</script>
@endsection
