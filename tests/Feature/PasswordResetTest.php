<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_forgot_password_page_renders_successfully(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Recover your sanctuary of words');
        $response->assertSee('SEND RESET LINK');
    }

    public function test_authenticated_user_visiting_forgot_password_redirects_to_dashboard(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/forgot-password');

        $response->assertRedirect('/dashboard');
    }

    public function test_reset_link_can_be_requested_for_valid_user(): void
    {
        Notification::fake();

        $email = 'reset_test_' . uniqid() . '@alfaaz.com';
        $user = User::create([
            'name' => 'Reset Poet',
            'email' => $email,
            'password' => Hash::make('oldpassword123'),
            'pen_name' => 'Reset Poet',
            'role' => 'user',
        ]);

        $response = $this->from('/forgot-password')->post('/forgot-password', [
            'email' => $email,
        ]);

        $response->assertRedirect('/forgot-password');
        $response->assertSessionHas('status', __('passwords.sent'));

        Notification::assertSentTo($user, ResetPasswordNotification::class);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $email,
        ]);
    }

    public function test_reset_link_request_fails_if_email_not_found(): void
    {
        $response = $this->from('/forgot-password')->post('/forgot-password', [
            'email' => 'nonexistent_poet@alfaaz.com',
        ]);

        $response->assertRedirect('/forgot-password');
        $response->assertSessionHasErrors('email');
    }

    public function test_reset_link_request_is_rate_limited(): void
    {
        $email = 'ratelimit_reset@alfaaz.com';

        for ($i = 0; $i < 5; $i++) {
            $this->post('/forgot-password', [
                'email' => $email,
            ]);
        }

        // 6th request should hit 429 Too Many Requests (throttle:5,1)
        $response = $this->post('/forgot-password', [
            'email' => $email,
        ]);

        $response->assertStatus(429);
    }

    public function test_reset_password_page_renders_with_token(): void
    {
        $token = 'sample-secret-token-12345';
        $email = 'sample@alfaaz.com';

        $response = $this->get("/reset-password/{$token}?email=" . urlencode($email));

        $response->assertStatus(200);
        $response->assertSee('Create a new passphrase');
        $response->assertSee($token);
        $response->assertSee($email);
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        $email = 'valid_reset_' . uniqid() . '@alfaaz.com';
        $user = User::create([
            'name' => 'Resetting Poet',
            'email' => $email,
            'password' => Hash::make('oldpassword123'),
            'pen_name' => 'Resetting Poet',
            'role' => 'user',
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $email,
            'password' => 'newSecret456',
            'password_confirmation' => 'newSecret456',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('status');

        $freshUser = $user->fresh();
        $this->assertTrue(Hash::check('newSecret456', $freshUser->password));

        // Token should be consumed
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $email,
        ]);
    }

    public function test_password_reset_fails_with_invalid_token(): void
    {
        $email = 'invalid_token_' . uniqid() . '@alfaaz.com';
        User::create([
            'name' => 'Invalid Token Poet',
            'email' => $email,
            'password' => Hash::make('oldpassword123'),
            'pen_name' => 'Invalid Token Poet',
            'role' => 'user',
        ]);

        $response = $this->from('/reset-password/bogus-token')->post('/reset-password', [
            'token' => 'bogus-token',
            'email' => $email,
            'password' => 'newSecret456',
            'password_confirmation' => 'newSecret456',
        ]);

        $response->assertRedirect('/reset-password/bogus-token');
        $response->assertSessionHasErrors('email');
    }

    public function test_password_reset_fails_if_password_weak_or_unconfirmed(): void
    {
        $email = 'weak_reset_' . uniqid() . '@alfaaz.com';
        $user = User::create([
            'name' => 'Weak Reset Poet',
            'email' => $email,
            'password' => Hash::make('oldpassword123'),
            'pen_name' => 'Weak Reset Poet',
            'role' => 'user',
        ]);

        $token = Password::broker()->createToken($user);

        // Password too short
        $response = $this->from('/reset-password/' . $token)->post('/reset-password', [
            'token' => $token,
            'email' => $email,
            'password' => 'short1',
            'password_confirmation' => 'short1',
        ]);

        $response->assertRedirect('/reset-password/' . $token);
        $response->assertSessionHasErrors('password');

        // Password lacking numbers
        $response = $this->from('/reset-password/' . $token)->post('/reset-password', [
            'token' => $token,
            'email' => $email,
            'password' => 'onlyletterspassword',
            'password_confirmation' => 'onlyletterspassword',
        ]);

        $response->assertRedirect('/reset-password/' . $token);
        $response->assertSessionHasErrors('password');

        // Password confirmation mismatch
        $response = $this->from('/reset-password/' . $token)->post('/reset-password', [
            'token' => $token,
            'email' => $email,
            'password' => 'validPass123',
            'password_confirmation' => 'differentPass456',
        ]);

        $response->assertRedirect('/reset-password/' . $token);
        $response->assertSessionHasErrors('password');
    }
}
