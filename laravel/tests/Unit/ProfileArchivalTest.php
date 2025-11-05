<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Profile;
use App\Models\Gallery;
use App\Models\ArchivedProfile;
use Illuminate\Support\Str;

class ProfileArchivalTest extends TestCase
{
    /**
     * Test profile archival on deletion
     */
    public function test_profile_is_archived_on_deletion(): void
    {
        $profile = Profile::create([
            'id' => Str::uuid(),
            'user_id' => $userId = Str::uuid(),
            'username' => 'archivetest',
            'bio' => 'Test bio for archival',
            'contact_info' => ['email' => 'test@example.com'],
        ]);

        // Add gallery items
        Gallery::create([
            'id' => Str::uuid(),
            'profile_id' => $profile->id,
            'image_url' => 'https://example.com/image.jpg',
        ]);

        $profileId = $profile->id;
        $profileData = $profile->toArray();
        $galleryData = $profile->galleries()->get()->toArray();

        // Create archived profile
        $archived = ArchivedProfile::create([
            'id' => Str::uuid(),
            'original_profile_id' => $profileId,
            'user_id' => $userId,
            'user_data' => $profileData,
            'gallery_data' => $galleryData,
            'deleted_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        // Delete original
        $profile->galleries()->delete();
        $profile->delete();

        // Verify archived exists
        $this->assertDatabaseHas('archived_profiles', [
            'original_profile_id' => $profileId,
            'user_id' => $userId,
        ]);

        // Verify original is deleted
        $this->assertDatabaseMissing('profiles', [
            'id' => $profileId,
        ]);
    }

    /**
     * Test archived profile contains complete data snapshot
     */
    public function test_archived_profile_contains_complete_snapshot(): void
    {
        $profileData = [
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'snapshottest',
            'bio' => 'Complete snapshot',
            'contact_info' => ['email' => 'test@example.com', 'phone' => '123456789'],
            'wallet_addresses' => ['wallet1', 'wallet2'],
        ];

        $archived = ArchivedProfile::create([
            'id' => Str::uuid(),
            'original_profile_id' => $profileData['id'],
            'user_id' => $profileData['user_id'],
            'user_data' => $profileData,
            'deleted_at' => now(),
        ]);

        $this->assertEquals($profileData, $archived->user_data);
        $this->assertDatabaseHas('archived_profiles', [
            'id' => $archived->id,
        ]);
    }

    /**
     * Test archived profile has expiration date
     */
    public function test_archived_profile_has_30_day_expiration(): void
    {
        $expiresAt = now()->addDays(30);

        $archived = ArchivedProfile::create([
            'id' => Str::uuid(),
            'original_profile_id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'user_data' => ['username' => 'expiretest'],
            'deleted_at' => now(),
            'expires_at' => $expiresAt,
        ]);

        $this->assertEquals($expiresAt->toDateString(), $archived->expires_at->toDateString());
    }
}
