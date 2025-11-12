<?php

// Script to recreate all modernized blade files

$files = [
    'auth/login.blade.php' => '@extends(\'layouts.app\')

@section(\'title\', \'Sign In - DonateKudos\')

@section(\'content\')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Welcome Back</h1>
                <p class="text-gray-600">Sign in to your account</p>
            </div>

            <form action="{{ route(\'login\') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old(\'email\') }}" required class="input-modern input-focus-ring" placeholder="you@example.com">
                    @error(\'email\')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required class="input-modern input-focus-ring" placeholder="••••••••">
                    @error(\'password\')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-primary">Sign In</button>

                <div class="border-t border-gray-200 pt-4">
                    <p class="text-gray-600 text-center">Forgot your password? <a href="{{ route(\'password.email\') }}" class="text-purple-600 hover:text-purple-700 font-semibold">Reset it</a></p>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Don\'t have an account? <a href="{{ route(\'register\') }}" class="text-purple-600 font-semibold hover:text-purple-700">Sign up here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection',
];

$basePath = __DIR__ . '/../../resources/views/';

foreach ($files as $path => $content) {
    $fullPath = $basePath . $path;
    $dir = dirname($fullPath);
    
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    file_put_contents($fullPath, $content);
    echo "Created: {$path}\n";
}

echo "Done!\n";
