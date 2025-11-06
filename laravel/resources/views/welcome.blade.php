<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonateKudos - Share Impact, Inspire Change</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Poppins', sans-serif; }
        .gradient-brand { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hero-text { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg gradient-brand flex items-center justify-center">
                        <span class="text-white font-bold text-lg">DK</span>
                    </div>
                    <h1 class="text-xl font-bold hero-text">DonateKudos</h1>
                </div>
                <div class="hidden md:flex gap-6 items-center">
                    <a href="#features" class="text-gray-600 hover:text-purple-600 font-medium">Features</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-purple-600 font-medium">How It Works</a>
                    @auth
                        <a href="{{ route('profile.index') }}" class="text-gray-600 hover:text-purple-600 font-medium">My Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 font-medium">Sign In</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 gradient-brand text-white rounded-lg font-medium hover:shadow-lg transition">Join Now</a>
                    @endauth
                </div>
                <div class="md:hidden flex gap-3">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-gray-100 rounded text-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600">Sign In</a>
                        <a href="{{ route('register') }}" class="px-3 py-1 gradient-brand text-white rounded text-sm">Join</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-20 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 gradient-brand opacity-5"></div>
        <div class="relative max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-6 hero-text">Share Your Impact, Inspire Change</h2>
                    <p class="text-xl text-gray-600 mb-8">Create your donor profile, showcase your charitable journey, and connect with a community of changemakers. Secure, transparent, and inspiring.</p>
                    @auth
                        <a href="{{ route('profile.index') }}" class="inline-block px-8 py-4 gradient-brand text-white rounded-lg font-semibold hover:shadow-xl transition">View Your Profile</a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="inline-block px-8 py-4 gradient-brand text-white rounded-lg font-semibold hover:shadow-xl transition text-center">Create Your Profile</a>
                            <a href="{{ route('login') }}" class="inline-block px-8 py-4 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition text-center">Sign In</a>
                        </div>
                    @endauth
                </div>
                <div class="hidden md:block">
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-12 border border-purple-100">
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg gradient-brand flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Verified Profiles</h3>
                                    <p class="text-sm text-gray-600">Your authentic story, secured with 2FA</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg gradient-brand flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Impact Tracking</h3>
                                    <p class="text-sm text-gray-600">Visualize your giving journey over time</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg gradient-brand flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Community Connection</h3>
                                    <p class="text-sm text-gray-600">Connect with fellow changemakers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 hero-text">Why DonateKudos?</h2>
                <p class="text-xl text-gray-600">Everything you need to share your giving story</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 gradient-brand rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Bank-Level Security</h3>
                    <p class="text-gray-600">Two-factor authentication with TOTP ensures your profile is protected with military-grade encryption.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 gradient-brand rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 107.753 1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Media Gallery</h3>
                    <p class="text-gray-600">Upload photos from your charitable events and showcase your impact with a beautiful gallery interface.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 gradient-brand rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Data Export</h3>
                    <p class="text-gray-600">Export your profile data to XML format anytime. Your data, your control - complete transparency.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 gradient-brand rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Community</h3>
                    <p class="text-gray-600">Discover and connect with other donors, amplify your impact, and build meaningful relationships.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 gradient-brand rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.914 6.025a1 1 0 00-1.828 1.05c.07.119.17.235.283.336l7.753 6.936 7.753-6.936c.113-.1.213-.217.283-.336a1 1 0 10-1.828-1.05l-6.43 5.739-6.984-6.403z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Rich Profiles</h3>
                    <p class="text-gray-600">Add bio, contact info, social links, and wallet addresses to create a comprehensive donor profile.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 gradient-brand rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.657 14.243a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM11 17a1 1 0 102 0v-1a1 1 0 10-2 0v1zM5.757 15.657a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM4 11a1 1 0 01-1-1 1 1 0 110-2h1a1 1 0 011 1 1 1 0 01-1 1zM5.757 5.757a1 1 0 000-1.414L5.05 3.636a1 1 0 10-1.414 1.414l.707.707z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Admin Dashboard</h3>
                    <p class="text-gray-600">Admins can manage users, track statistics, and maintain data integrity across the platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 hero-text">How It Works</h2>
                <p class="text-xl text-gray-600">Get started in just 3 simple steps</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="relative">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 gradient-brand rounded-full flex items-center justify-center mb-6 text-white text-2xl font-bold">1</div>
                        <h3 class="text-xl font-bold mb-3 text-center">Create Account</h3>
                        <p class="text-gray-600 text-center">Sign up with your email and create a secure password</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 gradient-brand rounded-full flex items-center justify-center mb-6 text-white text-2xl font-bold">2</div>
                        <h3 class="text-xl font-bold mb-3 text-center">Set Up 2FA</h3>
                        <p class="text-gray-600 text-center">Secure your account with two-factor authentication</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 gradient-brand rounded-full flex items-center justify-center mb-6 text-white text-2xl font-bold">3</div>
                        <h3 class="text-xl font-bold mb-3 text-center">Build Profile</h3>
                        <p class="text-gray-600 text-center">Add your story, photos, and share your impact</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 gradient-brand text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Make Your Impact?</h2>
            <p class="text-xl mb-10 opacity-90">Join hundreds of donors sharing their stories and inspiring change</p>
            @auth
                <a href="{{ route('profile.edit') }}" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Complete Your Profile</a>
            @else
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Create Your Profile Now</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 rounded-lg gradient-brand flex items-center justify-center">
                            <span class="text-white font-bold">DK</span>
                        </div>
                        <span class="text-white font-bold text-lg">DonateKudos</span>
                    </div>
                    <p class="text-sm">Share your impact, inspire change, build community.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-purple-400 transition">Features</a></li>
                        <li><a href="#how-it-works" class="hover:text-purple-400 transition">How It Works</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Account</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-purple-400 transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-purple-400 transition">Register</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Admin</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('admin.login') }}" class="hover:text-purple-400 transition">Admin Portal</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2025 DonateKudos. Inspiring change through transparency and community.</p>
            </div>
        </div>
    </footer>
</body>
</html>
