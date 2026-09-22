<?php

namespace Tests\Feature;

use Tests\TestCase;

class WriteAndAuthTest extends TestCase
{
    public function test_write_button_redirects_to_signup_when_guest(): void
    {
        $response = $this->get('/write');

        $response->assertRedirect('/signup');
    }

    public function test_write_button_redirects_to_dashboard_when_session_present(): void
    {
        $response = $this->withSession(['user' => ['name' => 'Poet']])->get('/write');

        $response->assertRedirect('/dashboard');
    }

    public function test_signup_page_renders_successfully_matching_mockup(): void
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);

        // Branding and header
        $response->assertSee('A L F A A Z');
        $response->assertSee('Begin a home for your words');

        // Floating notes
        $response->assertSee('Khamoshi bhi ek');
        $response->assertSee('jawab hoti hai.');
        $response->assertSee('Lafz dil tak raasta bana');
        $response->assertSee('lete hain.');

        // Google authentication
        $response->assertSee('Continue with Google');

        // Form fields
        $response->assertSee('YOUR NAME');
        $response->assertSee('What should we call you?');
        $response->assertSee('EMAIL ADDRESS');
        $response->assertSee('poet@alfaaz.com');
        $response->assertSee('PASSWORD');
        $response->assertSee('At least 8 characters');

        // Terms and guarantee
        $response->assertSee('I agree to the');
        $response->assertSee('Terms');
        $response->assertSee('Privacy Policy');
        $response->assertSee('BEGIN YOUR JOURNEY');
        $response->assertSee('Your drafts stay yours. We never publish without your permission.');

        // Top bar link to login
        $response->assertSee('Already have an account?');
        $response->assertSee(route('login'));
    }

    public function test_login_page_renders_successfully_matching_mockup(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        // Branding and header
        $response->assertSee('A L F A A Z');
        $response->assertSee('Where every word finds its soul');

        // Top bar switch to signup
        $response->assertSee('New to Alfaaz?');
        $response->assertSee('Create account');
        $response->assertSee(route('signup'));

        // Floating notes
        $response->assertSee('Khamoshi bhi ek');
        $response->assertSee('jawab hoti hai.');
        $response->assertSee('Lafz dil tak raasta bana');
        $response->assertSee('lete hain.');

        // Google authentication
        $response->assertSee('Continue with Google');

        // Form fields
        $response->assertSee('EMAIL ADDRESS');
        $response->assertSee('poet@alfaaz.com');
        $response->assertSee('PASSWORD');
        $response->assertSee('Forgot password?');
        $response->assertSee('Enter your password');

        // Keep me signed in and CTA
        $response->assertSee('Keep me signed in on this device');
        $response->assertSee('ENTER THE CIRCLE');
        $response->assertSee('Your drafts stay yours. We never publish without your permission.');
    }

    public function test_dashboard_renders_successfully(): void
    {
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Alfaaz Studio');
        $response->assertSee('Desk');
    }

    public function test_header_write_button_links_to_write_route(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('write'));
    }
}
