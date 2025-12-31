<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_edit_page()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/my-page');
        
        $response->assertStatus(200);
        $response->assertViewIs('public_profile.edit');
    }

    public function test_profile_is_created_automatically_for_new_user()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/my-page');
        
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $response = $this->actingAs($user)->put('/my-page', [
            'slug' => 'updated-slug',
            'bio' => 'Updated bio',
            'theme' => 'techy',
            'template_id' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'slug' => 'updated-slug',
            'bio' => 'Updated bio',
            'theme' => 'techy',
        ]);
    }

    public function test_profile_slug_must_be_unique()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        Profile::create([
            'user_id' => $user1->id,
            'slug' => 'existing-slug',
            'theme' => 'monochrome',
        ]);

        $profile2 = Profile::create([
            'user_id' => $user2->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $response = $this->actingAs($user2)->put('/my-page', [
            'slug' => 'existing-slug',
            'bio' => 'Test',
            'theme' => 'techy',
            'template_id' => 1,
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_user_can_upload_images()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        // Create fake image with dimensions (500x500)
        $file = UploadedFile::fake()->image('photo.jpg', 500, 500);

        $response = $this->actingAs($user)->post('/my-page/image', [
            'image' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('gallery_images', [
            'profile_id' => $profile->id,
        ]);

        // Verify a file was stored in the gallery directory
        $galleryImages = $profile->galleryImages()->get();
        $this->assertCount(1, $galleryImages);
        Storage::disk('public')->assertExists($galleryImages->first()->image_path);
    }

    public function test_user_cannot_upload_more_than_10_images()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        // Create 10 images
        for ($i = 0; $i < 10; $i++) {
            GalleryImage::create([
                'profile_id' => $profile->id,
                'image_path' => 'test-path-' . $i . '.jpg',
                'order' => $i,
            ]);
        }

        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($user)->post('/my-page/image', [
            'image' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_user_can_delete_image()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-slug',
            'theme' => 'monochrome',
        ]);

        $image = GalleryImage::create([
            'profile_id' => $profile->id,
            'image_path' => 'gallery/test.jpg',
            'order' => 0,
        ]);

        Storage::disk('public')->put('gallery/test.jpg', 'fake content');

        $response = $this->actingAs($user)->delete("/my-page/image/{$image->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('gallery_images', [
            'id' => $image->id,
        ]);

        Storage::disk('public')->assertMissing('gallery/test.jpg');
    }

    public function test_public_profile_can_be_viewed_by_slug()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-profile',
            'bio' => 'Test bio',
            'theme' => 'techy',
        ]);

        $response = $this->get('/test-profile');

        $response->assertStatus(200);
        $response->assertSee('Test bio');
    }

    public function test_themes_are_applied_correctly()
    {
        $user = User::factory()->create();
        
        // Test Techy theme
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'techy-profile',
            'theme' => 'techy',
        ]);
        
        $response = $this->get('/techy-profile');
        $response->assertStatus(200);
        $response->assertSee('Press+Start+2P', false); // Techy font

        // Test Artsy theme
        $profile->update(['theme' => 'artsy', 'slug' => 'artsy-profile']);
        $response = $this->get('/artsy-profile');
        $response->assertStatus(200);
        $response->assertSee('Playfair+Display', false); // Artsy font

        // Test Monochrome theme
        $profile->update(['theme' => 'monochrome', 'slug' => 'mono-profile']);
        $response = $this->get('/mono-profile');
        $response->assertStatus(200);
        $response->assertSee('Comfortaa', false); // Check that theme fonts are loaded
    }
}
