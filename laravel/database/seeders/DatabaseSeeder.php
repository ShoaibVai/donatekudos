<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => true,
        ]);

        // Regular User 1 (Techy)
        $user1 = User::create([
            'name' => 'Tech Enthusiast',
            'email' => 'tech@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
        Profile::create([
            'user_id' => $user1->id,
            'slug' => 'tech-guru',
            'bio' => 'I love 8-bit art and retro gaming. Support my collection!',
            'theme' => 'techy',
        ]);

        // Regular User 2 (Artsy)
        $user2 = User::create([
            'name' => 'Art Lover',
            'email' => 'art@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
        Profile::create([
            'user_id' => $user2->id,
            'slug' => 'art-gallery',
            'bio' => 'Creating beautiful things every day.',
            'theme' => 'artsy',
        ]);

        // Regular User 3 (Monochrome)
        $user3 = User::create([
            'name' => 'Minimalist',
            'email' => 'minimal@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
        Profile::create([
            'user_id' => $user3->id,
            'slug' => 'minimal-life',
            'bio' => 'Less is more.',
            'theme' => 'monochrome',
        ]);
    }
}
