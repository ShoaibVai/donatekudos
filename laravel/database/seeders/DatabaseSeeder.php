<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admins
        $this->call(AdminSeeder::class);

        // Create test user with profile and galleries
        $user = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Donate',
            ]
        );

        // Create profile for test user
        Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'contact_info' => json_encode([
                    'phone' => '+1 (555) 123-4567',
                    'website' => 'https://example.com',
                    'address' => '123 Main St, New York, NY 10001',
                ]),
                'wallet_addresses' => json_encode([
                    'bitcoin' => '1A1z7agoat8VXxU8g9hJrGT8vFjUDfXFbq',
                    'ethereum' => '0x742d35Cc6634C0532925a3b844Bc9e7595f42D8F',
                    'litecoin' => 'LN8oW7d4dHvwrVKvVSDWSpBjP1mS5d2sG',
                ]),
            ]
        );

        // Create more test users
        for ($i = 1; $i <= 3; $i++) {
            $newUser = User::firstOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => "Test User {$i}",
                ]
            );

            // Create profile for each user
            Profile::firstOrCreate(
                ['user_id' => $newUser->id],
                [
                    'contact_info' => json_encode([
                        'phone' => "+1 (555) {$i}{$i}{$i}-{$i}{$i}{$i}{$i}",
                        'website' => "https://user{$i}.example.com",
                    ]),
                    'wallet_addresses' => json_encode([
                        'bitcoin' => '1A1z7agoat8VXxU8g9hJrGT8vFjUDfXFbq',
                        'ethereum' => '0x742d35Cc6634C0532925a3b844Bc9e7595f42D8F',
                    ]),
                ]
            );
        }
    }
}
