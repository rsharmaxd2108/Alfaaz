<?php

namespace Tests\Feature;

use App\Models\Shayari;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::updateOrCreate(
            ['email' => 'test_profile_poet@alfaaz.com'],
            [
                'name' => 'Profile Test Poet',
                'password' => Hash::make('SecretPass@123'),
                'pen_name' => 'TakhallusTest',
                'bio' => 'Original test bio.',
                'avatar_color' => '#7052FF',
                'avatar_path' => null,
                'role' => 'poet',
            ]
        );
    }

    protected function tearDown(): void
    {
        // Clean up test avatar file if created
        if (!empty($this->user->avatar_path) && File::exists(public_path($this->user->avatar_path))) {
            File::delete(public_path($this->user->avatar_path));
        }

        parent::tearDown();
    }

    public function test_guest_redirected_to_login_from_profile(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile_with_stats(): void
    {
        // Create 1 published and 1 draft shayari for user
        Shayari::create([
            'user_id' => $this->user->id,
            'title' => 'Test Published Verse',
            'quote' => 'Chand sitare bhi chup chap dekh rahe the.',
            'status' => 'published',
            'likes_count' => 5,
        ]);

        Shayari::create([
            'user_id' => $this->user->id,
            'title' => 'Test Draft Verse',
            'quote' => 'Ek adhuri dastaan thi jo panno pe reh gayi.',
            'status' => 'draft',
            'likes_count' => 0,
        ]);

        $response = $this->actingAs($this->user)->get('/profile');

        $response->assertOk();
        $response->assertSee('Profile Test Poet');
        $response->assertSee('test_profile_poet@alfaaz.com');
        $response->assertSee('TakhallusTest');
        $response->assertSee('Published Verses');
        $response->assertSee('Drafts on Desk');
        $response->assertSee('Hearts Received');
    }

    public function test_user_can_update_profile_details(): void
    {
        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => 'Updated Poet Name',
            'pen_name' => 'NewTakhallus',
            'email' => 'test_profile_poet@alfaaz.com',
            'bio' => 'New soulful poetry bio.',
            'avatar_color' => '#DF7656',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('status', 'Profile details updated successfully.');

        $this->user->refresh();
        $this->assertEquals('Updated Poet Name', $this->user->name);
        $this->assertEquals('NewTakhallus', $this->user->pen_name);
        $this->assertEquals('New soulful poetry bio.', $this->user->bio);
        $this->assertEquals('#DF7656', $this->user->avatar_color);
    }

    public function test_user_can_upload_and_remove_profile_photo(): void
    {
        $fakeImage = UploadedFile::fake()->image('profile_photo.jpg', 200, 200);

        // Upload photo
        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'avatar' => $fakeImage,
        ]);

        $response->assertRedirect('/profile');
        $this->user->refresh();

        $this->assertNotNull($this->user->avatar_path);
        $this->assertFileExists(public_path($this->user->avatar_path));
        $this->assertNotNull($this->user->avatar_url);

        $uploadedPath = $this->user->avatar_path;

        // Remove photo
        $removeResponse = $this->actingAs($this->user)->put('/profile', [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'remove_avatar' => '1',
        ]);

        $removeResponse->assertRedirect('/profile');
        $this->user->refresh();

        $this->assertNull($this->user->avatar_path);
        $this->assertNull($this->user->avatar_url);
        $this->assertFileDoesNotExist(public_path($uploadedPath));
    }

    public function test_user_can_update_password_with_valid_credentials(): void
    {
        $response = $this->actingAs($this->user)->put('/profile/password', [
            'current_password' => 'SecretPass@123',
            'password' => 'NewBrandPass@2026',
            'password_confirmation' => 'NewBrandPass@2026',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('status', 'Password updated successfully.');

        $this->user->refresh();
        $this->assertTrue(Hash::check('NewBrandPass@2026', $this->user->password));

        // Restore original password for clean teardown
        $this->user->password = Hash::make('SecretPass@123');
        $this->user->save();
    }

    public function test_password_update_fails_if_current_password_wrong(): void
    {
        $response = $this->actingAs($this->user)->put('/profile/password', [
            'current_password' => 'WrongPassword123',
            'password' => 'NewBrandPass@2026',
            'password_confirmation' => 'NewBrandPass@2026',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('current_password');

        $this->user->refresh();
        $this->assertTrue(Hash::check('SecretPass@123', $this->user->password));
    }

    public function test_password_update_fails_if_new_password_weak_or_unconfirmed(): void
    {
        // Missing confirmation
        $response = $this->actingAs($this->user)->put('/profile/password', [
            'current_password' => 'SecretPass@123',
            'password' => 'Weak123',
            'password_confirmation' => 'DifferentPass123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('password');
    }

    public function test_email_uniqueness_validation_ignores_self_but_blocks_taken_email(): void
    {
        $otherUser = User::firstOrCreate(
            ['email' => 'existing_poet@alfaaz.com'],
            ['name' => 'Existing Poet', 'password' => Hash::make('Pass@12345')]
        );

        // Attempt to take other user's email
        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => $this->user->name,
            'email' => 'existing_poet@alfaaz.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');

        // Self email should succeed without validation error
        $selfResponse = $this->actingAs($this->user)->put('/profile', [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ]);

        $selfResponse->assertRedirect('/profile');
        $selfResponse->assertSessionHasNoErrors();
    }
}
