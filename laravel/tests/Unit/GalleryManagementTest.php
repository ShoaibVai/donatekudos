<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Profile;
use App\Models\Gallery;
use Illuminate\Support\Str;

class GalleryManagementTest extends TestCase
{
    /**
     * Test gallery image creation
     */
    public function test_gallery_image_creation(): void
    {
        $profile = Profile::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'gallerytest',
        ]);

        $gallery = Gallery::create([
            'id' => Str::uuid(),
            'profile_id' => $profile->id,
            'image_url' => 'https://example.com/image.jpg',
            'filename' => 'image.jpg',
            'file_size' => 1024,
            'mime_type' => 'image/jpeg',
        ]);

        $this->assertNotNull($gallery->id);
        $this->assertEquals($profile->id, $gallery->profile_id);
        $this->assertDatabaseHas('galleries', [
            'image_url' => 'https://example.com/image.jpg',
            'profile_id' => $profile->id,
        ]);
    }

    /**
     * Test gallery cascade deletion when profile is deleted
     */
    public function test_gallery_cascade_delete_on_profile_deletion(): void
    {
        $profile = Profile::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'cascadetest',
        ]);

        Gallery::create([
            'id' => Str::uuid(),
            'profile_id' => $profile->id,
            'image_url' => 'https://example.com/image1.jpg',
        ]);

        Gallery::create([
            'id' => Str::uuid(),
            'profile_id' => $profile->id,
            'image_url' => 'https://example.com/image2.jpg',
        ]);

        $profileId = $profile->id;
        $profile->delete();

        $this->assertDatabaseMissing('galleries', [
            'profile_id' => $profileId,
        ]);
    }

    /**
     * Test gallery relationship with profile
     */
    public function test_gallery_belongs_to_profile(): void
    {
        $profile = Profile::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'username' => 'relationtest',
        ]);

        $gallery = Gallery::create([
            'id' => Str::uuid(),
            'profile_id' => $profile->id,
            'image_url' => 'https://example.com/image.jpg',
        ]);

        $this->assertInstanceOf(Profile::class, $gallery->profile);
        $this->assertEquals($profile->id, $gallery->profile->id);
    }
}
