<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\DailyVerse;
use App\Models\Poet;
use App\Models\Shayari;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    public function test_user_can_sign_up_successfully(): void
    {
        $email = 'newpoet_' . uniqid() . '@alfaaz.com';

        $response = $this->post('/signup', [
            'name' => 'Mirza Asad',
            'email' => $email,
            'password' => 'secretword123',
            'terms' => '1',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('Mirza Asad', $user->name);
        $this->assertEquals('user', $user->role);
    }

    public function test_signup_fails_if_password_too_short(): void
    {
        $response = $this->from('/signup')->post('/signup', [
            'name' => 'Short Pass',
            'email' => 'shortpass@example.com',
            'password' => '12345',
            'terms' => '1',
        ]);

        $response->assertRedirect('/signup');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_signup_fails_if_password_lacks_numbers(): void
    {
        $response = $this->from('/signup')->post('/signup', [
            'name' => 'Weak Pass',
            'email' => 'weakpass@example.com',
            'password' => 'onlylettershere',
            'terms' => '1',
        ]);

        $response->assertRedirect('/signup');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_signup_fails_if_password_exceeds_max_length(): void
    {
        // 129 character password with letters and numbers
        $longPassword = str_repeat('a1', 64) . 'b'; // 129 chars

        $response = $this->from('/signup')->post('/signup', [
            'name' => 'Long Pass User',
            'email' => 'longpass@example.com',
            'password' => $longPassword,
            'terms' => '1',
        ]);

        $response->assertRedirect('/signup');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_signup_fails_if_terms_not_accepted(): void
    {
        $response = $this->from('/signup')->post('/signup', [
            'name' => 'No Terms',
            'email' => 'noterms@example.com',
            'password' => 'validpassword123',
        ]);

        $response->assertRedirect('/signup');
        $response->assertSessionHasErrors('terms');
        $this->assertGuest();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'auth_test@alfaaz.com'],
            [
                'name' => 'Test Login Poet',
                'password' => Hash::make('mypassword123'),
                'pen_name' => 'Test Poet',
                'role' => 'user',
            ]
        );

        $response = $this->post('/login', [
            'email' => 'auth_test@alfaaz.com',
            'password' => 'mypassword123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'nonexistent@alfaaz.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_if_password_exceeds_max_length(): void
    {
        $longPassword = str_repeat('x', 129);

        $response = $this->from('/login')->post('/login', [
            'email' => 'auth_test@alfaaz.com',
            'password' => $longPassword,
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_guest_sees_write_button_in_header(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('btn-header-write', false);
        $response->assertDontSee('user-avatar-btn', false);
    }

    public function test_authenticated_user_sees_avatar_circle_and_dropdown_in_header(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('btn-header-write', false);
        $response->assertSee('user-avatar-btn', false);
        $response->assertSee('user-dropdown-menu', false);
        $response->assertSee('Profile');
        $response->assertSee("Poet's Desk", false);
        $response->assertSee('Log out');
        $response->assertSee($user->name);
    }

    public function test_authenticated_user_can_access_profile_page(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee("Open Poet's Desk", false);
    }

    public function test_guest_is_redirected_from_profile_page(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_visiting_login_redirected_to_dashboard(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    public function test_authenticated_user_visiting_signup_redirected_to_dashboard(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/signup');

        $response->assertRedirect('/dashboard');
    }

    public function test_database_seeded_models_and_relationships(): void
    {
        // Check categories and poets
        $this->assertGreaterThanOrEqual(6, Poet::count());
        $this->assertGreaterThanOrEqual(6, Category::count());

        // Check seeded admin user
        $admin = User::where('email', 'r.sharmaxd2108@gmail.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());
        $this->assertEquals('admin', $admin->role);

        // Check old dummy accounts are purged
        $this->assertNull(User::where('email', 'author@alfaaz.com')->first());
        $this->assertNull(User::where('email', 'reader@alfaaz.com')->first());

        // Check comment threading relationship works
        $poet = Poet::first();
        $category = Category::first();
        $shayari = Shayari::create([
            'user_id' => $admin->id,
            'poet_id' => $poet->id,
            'category_id' => $category->id,
            'title' => 'Test Verse',
            'quote' => "Line 1\nLine 2",
            'english_translation' => 'Test meaning',
            'status' => 'published',
        ]);

        $parentComment = Comment::create([
            'shayari_id' => $shayari->id,
            'user_id' => $admin->id,
            'body' => 'Parent thoughtful comment',
        ]);
        $childComment = Comment::create([
            'shayari_id' => $shayari->id,
            'user_id' => $admin->id,
            'parent_id' => $parentComment->id,
            'body' => 'Child thoughtful reply',
        ]);

        $this->assertGreaterThanOrEqual(1, $parentComment->fresh()->replies->count());
    }

    public function test_login_is_rate_limited_after_repeated_failures(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'ratelimit@example.com',
                'password' => 'wrongpass123',
            ]);
        }

        // 6th attempt should be blocked with 429 Too Many Requests
        $response = $this->post('/login', [
            'email' => 'ratelimit@example.com',
            'password' => 'wrongpass123',
        ]);

        $response->assertStatus(429);
    }

    public function test_google_oauth_redirect_when_credentials_missing(): void
    {
        config(['services.google.client_id' => null]);
        config(['services.google.client_secret' => null]);

        $response = $this->get('/auth/google');
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_google_oauth_redirects_to_provider_when_configured(): void
    {
        config([
            'services.google.client_id' => 'test-google-client-id',
            'services.google.client_secret' => 'test-google-client-secret',
            'services.google.redirect' => 'http://localhost:8000/auth/google/callback',
        ]);

        $response = $this->get('/auth/google');
        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', (string) $response->headers->get('Location'));
    }

    public function test_google_oauth_callback_creates_and_logs_in_new_user(): void
    {
        config([
            'services.google.client_id' => 'test-google-client-id',
            'services.google.client_secret' => 'test-google-client-secret',
        ]);

        $mockEmail = 'ghalib_' . uniqid() . '@delhi.com';

        $abstractUser = \Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-unique-id-12345');
        $abstractUser->shouldReceive('getName')->andReturn('Mirza Ghalib');
        $abstractUser->shouldReceive('getEmail')->andReturn($mockEmail);
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/a/test');

        $provider = \Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $user = User::where('email', $mockEmail)->first();
        $this->assertNotNull($user);
        $this->assertEquals('google-unique-id-12345', $user->google_id);
        $this->assertEquals('Mirza Ghalib', $user->name);
        $this->assertEquals('https://lh3.googleusercontent.com/a/test', $user->avatar_url);

        $user->delete();
    }

    public function test_google_oauth_callback_links_existing_user(): void
    {
        config([
            'services.google.client_id' => 'test-google-client-id',
            'services.google.client_secret' => 'test-google-client-secret',
        ]);

        $linkEmail = 'link_' . uniqid() . '@alfaaz.com';
        $existingUser = User::create([
            'name' => 'Existing Poet',
            'email' => $linkEmail,
            'password' => Hash::make('password123'),
            'pen_name' => 'Existing Poet',
            'role' => 'user',
        ]);

        $abstractUser = \Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-existing-999');
        $abstractUser->shouldReceive('getName')->andReturn('Existing Poet');
        $abstractUser->shouldReceive('getEmail')->andReturn($linkEmail);
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/a/existing');

        $provider = \Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($existingUser);

        $this->assertEquals('google-existing-999', $existingUser->fresh()->google_id);

        $existingUser->delete();
    }
}
