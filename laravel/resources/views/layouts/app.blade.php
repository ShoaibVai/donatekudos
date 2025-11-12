<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DonateKudos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --secondary: #ec4899;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        * { font-family: 'Sora', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; font-weight: 700; }
        
        .gradient-brand { background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%); }
        .gradient-text { background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%); }
        
        .btn-primary { @apply px-4 py-2.5 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-lg font-semibold hover:shadow-lg hover:shadow-violet-500/50 transition-all duration-300 active:scale-95; }
        .btn-primary-lg { @apply px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-xl hover:shadow-violet-500/50 transition-all duration-300 active:scale-95; }
        .btn-secondary { @apply px-4 py-2.5 border-2 border-violet-600 text-violet-600 rounded-lg font-semibold hover:bg-violet-50 transition-all duration-300; }
        .btn-ghost { @apply px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-all duration-300; }
        .btn-danger { @apply px-4 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 hover:shadow-lg hover:shadow-red-500/50 transition-all duration-300; }
        
        .card { @apply bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300; }
        .card-hover { @apply bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-xl hover:border-violet-300 transition-all duration-300; }
        
        .input-modern { @apply w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all duration-300 bg-white; }
        .input-modern::placeholder { @apply text-gray-500; }
        .input-modern:focus::placeholder { @apply text-gray-400; }
        
        .form-label { @apply block text-sm font-semibold text-gray-700 mb-2; }
        
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .fade-in { animation: fadeIn 0.3s ease-out; }
        .slide-in-down { animation: slideInDown 0.4s ease-out; }
        .scale-in { animation: scaleIn 0.3s ease-out; }
        
        .badge { @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold; }
        .badge-primary { @apply bg-violet-100 text-violet-700; }
        .badge-success { @apply bg-green-100 text-green-700; }
        .badge-warning { @apply bg-yellow-100 text-yellow-700; }
        .badge-danger { @apply bg-red-100 text-red-700; }
        
        .nav-link { @apply relative text-gray-700 hover:text-violet-600 font-medium transition-colors duration-300; }
        .nav-link::after { @apply absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-violet-600 to-pink-600 transition-all duration-300; }
        .nav-link:hover::after { @apply w-full; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Modern Navigation -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 gradient-brand rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">DK</div>
                    <span class="font-bold text-xl gradient-text group-hover:scale-105 transition-transform duration-300">DonateKudos</span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    @auth
                        <a href="{{ route('profile.index') }}" class="nav-link">
                            <i class="fas fa-user-circle mr-2"></i>My Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="nav-link text-red-600 hover:text-red-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            <i class="fas fa-user-plus mr-2"></i>Get Started
                        </a>
                    @endauth
                </div>
                <div class="md:hidden flex items-center gap-2">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="p-2 text-violet-600 hover:bg-violet-50 rounded-lg transition">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
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
