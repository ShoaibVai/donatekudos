<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->user->name }}'s Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        /* Base Styles */
        [x-cloak] { display: none !important; }
        
        /* Custom CSS from User (sanitized) */
        {!! $profile->safe_custom_css !!}
    </style>
    @if($profile->theme === 'techy')
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Press Start 2P', cursive; background-color: #2d3748; color: #00ff00; }
            .card { border: 4px solid #00ff00; box-shadow: 5px 5px 0px #00ff00; background-color: #1a202c; }
            .btn { background-color: #00ff00; color: #000; border: none; padding: 10px 20px; cursor: pointer; }
            .btn:hover { background-color: #00cc00; }
        </style>
    @elseif($profile->theme === 'artsy')
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Playfair Display', serif; background-color: #fdf2f8; color: #831843; }
            .card { border: 1px solid #fbcfe8; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-radius: 1rem; background-color: #fff; }
            .btn { background-color: #db2777; color: #fff; border-radius: 9999px; padding: 10px 25px; }
            .btn:hover { background-color: #be185d; }
        </style>
    @else
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Comfortaa', cursive; background-color: #ffffff; color: #000000; }
            .card { border: 1px solid #e5e7eb; border-radius: 0.5rem; background-color: #f9fafb; }
            .btn { background-color: #000; color: #fff; border-radius: 0.25rem; padding: 10px 20px; }
            .btn:hover { background-color: #333; }
        </style>
    @endif
</head>
<body class="min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="card p-8 mb-8 animate-fade-in">
            <h1 class="text-4xl font-bold mb-4">{{ $profile->user->name }}</h1>
            <div class="prose max-w-none mb-6">
                {{ $profile->bio }}
            </div>
            
            @if($profile->custom_html)
                <div class="custom-content mb-8">
                    {!! $profile->safe_custom_html !!}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($profile->galleryImages as $image)
                <div class="card overflow-hidden animate-slide-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                    <img src="{{ $image->url }}" alt="Gallery Image {{ $loop->iteration }}" class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>

    @auth
        @if(Auth::id() === $profile->user_id)
            <div class="fixed bottom-4 right-4">
                <a href="{{ route('public_profile.edit') }}" class="btn shadow">
                    Edit My Profile
                </a>
            </div>
        @endif
    @endauth

    <script>
        // Simple Animation Setup
        anime({
            targets: '.animate-fade-in',
            opacity: [0, 1],
            translateY: [20, 0],
            duration: 1000,
            easing: 'easeOutExpo'
        });

        anime({
            targets: '.animate-slide-up',
            opacity: [0, 1],
            translateY: [50, 0],
            delay: anime.stagger(100),
            duration: 800,
            easing: 'easeOutQuad'
        });

        // Custom JavaScript is disabled for security
        console.log('DonateKudos Profile Loaded');
    </script>
</body>
</html>
