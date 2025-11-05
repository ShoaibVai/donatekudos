<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Donate Kudos - Profile Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-blue-600">
                    <a href="/">Donate Kudos</a>
                </div>
                
                <div class="flex items-center gap-4">
                    @if(auth()->check())
                        <span class="text-gray-600">{{ auth()->user()->email }}</span>
                        <a href="{{ route('profile.dashboard') }}" class="text-blue-500 hover:text-blue-700">Dashboard</a>
                        <a href="{{ route('gallery.manage') }}" class="text-blue-500 hover:text-blue-700">Gallery</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; {{ date('Y') }} Donate Kudos. All rights reserved.</p>
    </footer>

    @yield('scripts')
</body>
</html>
