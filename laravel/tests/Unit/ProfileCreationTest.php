<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Profile;
use App\Models\RecoveryToken;
use Illuminate\Support\Str;

class ProfileCreationTest extends TestCase
{
    /**
     * Test profile creation with valid data
     */
    public function test_profile_creation_with_valid_data(): void
    {
        $userId = Str::uuid();
        
        $profile = Profile::create([
            'id' => Str::uuid(),
            'user_id' => $userId,
            'username' => 'testuser',
            'bio' => 'Test bio',
            'contact_info' => [
                'email' => 'test@example.com',
                'phone' => '+1234567890',
            ],
            'wallet_addresses' => [
                '1A1z7agoat',
                '0x71C7656EC7ab88b098defB751B7401B5f6d8976F',
            ],
        ]);

        $this->assertNotNull($profile->id);
        $this->assertEquals('testuser', $profile->username);
        $this->assertEquals('Test bio', $profile->bio);
        $this->assertIsArray($profile->contact_info);
        $this->assertCount(2, $profile->wallet_addresses);
        $this->assertDatabaseHas('profiles', [
            'username' => 'testuser',
            'user_id' => $userId,
        ]);
    }

    /**
     * Test profile username uniqueness
     */
    public function test_profile_username_must_be_unique(): void
    {
        Profile::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'uniqueuser',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Profile::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'uniqueuser',
        ]);
    }

    /**
     * Test profile with JSON contact info
     */
    public function test_profile_stores_contact_info_as_json(): void
    {
        $contactInfo = [
            'email' => 'user@example.com',
            'phone' => '+1234567890',
            'address' => '123 Main St',
        ];

        $profile = Profile::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'jsontest',
            'contact_info' => $contactInfo,
        ]);

        $this->assertEquals($contactInfo, $profile->contact_info);
        $this->assertIsArray($profile->contact_info);
    }
}
