<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DonateKudos - Show Off Your Best Self</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        .hero-bg {
            background-color: #0f172a;
            background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
        .floating-card {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="antialiased text-white hero-bg min-h-screen flex flex-col">

    <nav class="w-full p-6 flex justify-between items-center z-50">
        <div class="text-2xl font-bold tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
            DonateKudos
        </div>
        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold hover:text-pink-400 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold hover:text-pink-400 transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-pink-600 hover:bg-pink-700 transition font-semibold">Get Started</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center text-center px-4 relative overflow-hidden">
        
        <!-- Animated Background Elements -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/3 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>

        <div class="z-10 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight">
                Your Profile, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 anime-title">
                    Reimagined.
                </span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                Create a stunning, animated personal page in seconds. Choose your vibe: Techy, Artsy, or Monochrome. Show off your best moments.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-500 hover:to-purple-500 text-white font-bold text-lg shadow-lg transform hover:scale-105 transition duration-300">
                    Create Your Page
                </a>
                <a href="#features" class="px-8 py-4 rounded-full border border-gray-600 hover:border-gray-400 text-gray-300 hover:text-white font-semibold text-lg transition duration-300">
                    Learn More
                </a>
            </div>
        </div>

        <!-- Mockup Cards -->
        <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto perspective-1000">
            <div class="floating-card bg-gray-800/50 backdrop-blur-md p-4 rounded-xl border border-gray-700 transform rotate-y-12 hover:rotate-0 transition duration-500">
                <div class="h-40 bg-gradient-to-br from-gray-900 to-gray-800 rounded-lg mb-4 flex items-center justify-center border border-green-500/30">
                    <span class="text-green-400 font-mono">&lt;Techy /&gt;</span>
                </div>
                <div class="h-4 w-3/4 bg-gray-700 rounded mb-2"></div>
                <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
            </div>
            
            <div class="floating-card bg-gray-800/50 backdrop-blur-md p-4 rounded-xl border border-gray-700 transform -translate-y-12 z-20 shadow-2xl shadow-purple-500/20">
                <div class="h-40 bg-gradient-to-br from-pink-200 to-purple-200 rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-purple-600 font-serif italic text-2xl">Artsy</span>
                </div>
                <div class="h-4 w-3/4 bg-gray-700 rounded mb-2"></div>
                <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
            </div>

            <div class="floating-card bg-gray-800/50 backdrop-blur-md p-4 rounded-xl border border-gray-700 transform -rotate-y-12 hover:rotate-0 transition duration-500">
                <div class="h-40 bg-white rounded-lg mb-4 flex items-center justify-center border border-gray-200">
                    <span class="text-black font-bold tracking-widest uppercase">Mono</span>
                </div>
                <div class="h-4 w-3/4 bg-gray-700 rounded mb-2"></div>
                <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
            </div>
        </div>

    </main>

    <footer class="py-8 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} DonateKudos. All rights reserved.
    </footer>

    <script>
        // Simple entrance animation
        anime({
            targets: '.anime-title',
            opacity: [0, 1],
            translateY: [20, 0],
            easing: 'easeOutExpo',
            duration: 1500,
            delay: 500
        });
    </script>
</body>
</html>
