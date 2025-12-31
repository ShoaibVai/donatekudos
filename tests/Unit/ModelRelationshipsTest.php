<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Profile;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_one_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $this->assertInstanceOf(Profile::class, $user->profile);
        $this->assertEquals($profile->id, $user->profile->id);
    }

    public function test_profile_belongs_to_user()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $this->assertInstanceOf(User::class, $profile->user);
        $this->assertEquals($user->id, $profile->user->id);
    }

    public function test_profile_has_many_gallery_images()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $image1 = GalleryImage::create([
            'profile_id' => $profile->id,
            'image_path' => 'test1.jpg',
            'order' => 0,
        ]);

        $image2 = GalleryImage::create([
            'profile_id' => $profile->id,
            'image_path' => 'test2.jpg',
            'order' => 1,
        ]);

        $this->assertCount(2, $profile->galleryImages);
        $this->assertTrue($profile->galleryImages->contains($image1));
        $this->assertTrue($profile->galleryImages->contains($image2));
    }

    public function test_gallery_image_belongs_to_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $image = GalleryImage::create([
            'profile_id' => $profile->id,
            'image_path' => 'test.jpg',
            'order' => 0,
        ]);

        $this->assertInstanceOf(Profile::class, $image->profile);
        $this->assertEquals($profile->id, $image->profile->id);
    }

    public function test_deleting_user_cascades_to_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $profileId = $profile->id;
        $user->delete();

        $this->assertDatabaseMissing('profiles', ['id' => $profileId]);
    }

    public function test_deleting_profile_cascades_to_gallery_images()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $image = GalleryImage::create([
            'profile_id' => $profile->id,
            'image_path' => 'test.jpg',
            'order' => 0,
        ]);

        $imageId = $image->id;
        $profile->delete();

        $this->assertDatabaseMissing('gallery_images', ['id' => $imageId]);
    }
}
