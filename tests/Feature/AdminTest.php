<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_regular_user_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_all_users()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $users = User::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        foreach ($users as $user) {
            $response->assertSee($user->email);
        }
    }

    public function test_admin_can_delete_regular_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($admin)->delete("/admin/user/{$user->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->delete("/admin/user/{$admin->id}");

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }

    public function test_regular_user_cannot_delete_users()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $targetUser = User::factory()->create();

        $response = $this->actingAs($user)->delete("/admin/user/{$targetUser->id}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
        ]);
    }

    public function test_deleting_user_cascades_to_profile_and_images()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        
        $profile = Profile::create([
            'user_id' => $user->id,
            'slug' => 'test-profile',
            'theme' => 'monochrome',
        ]);

        $profile->galleryImages()->create([
            'image_path' => 'test.jpg',
            'order' => 0,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/user/{$user->id}");

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);
        $this->assertDatabaseMissing('gallery_images', ['profile_id' => $profile->id]);
    }

    public function test_admin_dashboard_shows_stats()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        User::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Total Users');
        $response->assertSee('Total Profiles');
        $response->assertSee('Total Images');
    }
}
