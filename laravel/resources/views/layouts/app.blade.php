<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DonateKudos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        .gradient-brand { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-text { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-primary { @apply px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg font-semibold hover:shadow-lg transition; }
        .btn-secondary { @apply px-4 py-3 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition; }
        .btn-ghost { @apply px-4 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition; }
        .card { @apply bg-white rounded-lg shadow-sm border border-gray-200; }
        .input-modern { @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none; }
        .input-focus-ring { @apply focus:border-purple-500 focus:ring-2 focus:ring-purple-200; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .fade-in { animation: fadeIn 0.3s ease-in; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-40 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 gradient-brand rounded-lg"></div>
                    <span class="font-bold text-lg gradient-text">DonateKudos</span>
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 font-semibold">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-purple-600 font-semibold">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto mx-4 mt-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 fade-in">
            <span class="text-2xl">✓</span>
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto mx-4 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 fade-in">
            <span class="text-2xl">✕</span>
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-16rem)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">DonateKudos</h3>
                    <p class="text-gray-400">A modern platform for donation profiling.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Features</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Profile Management</a></li>
                        <li><a href="#" class="hover:text-white">Secure Donations</a></li>
                        <li><a href="#" class="hover:text-white">Two-Factor Auth</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Security</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Terms</a></li>
                        <li><a href="#" class="hover:text-white">Security Policy</a></li>
                        <li><a href="#" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 DonateKudos. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
