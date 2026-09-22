<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyPageTest extends TestCase
{
    public function test_privacy_page_renders_successfully(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
        $response->assertSee('Privacy & Creative Trust', false);
        $response->assertSee('Privacy <span class="highlight-wrapper">Policy', false);
        $response->assertSee('Overview & Philosophy', false);
        $response->assertSee('Information We Collect', false);
        $response->assertSee('Google OAuth & Third-Party Sign-In', false);
        $response->assertSee('Copyright & Content Ownership', false);
        $response->assertSee('privacy@alfaaz.com');
    }

    public function test_footer_contains_working_privacy_link_across_pages(): void
    {
        // Landing page
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<a href="' . route('privacy') . '" class="footer-nav-link ">Privacy</a>', false);

        // Subpages
        $exploreResponse = $this->get('/explore');
        $exploreResponse->assertStatus(200);
        $exploreResponse->assertSee('<a href="' . route('privacy') . '" class="footer-nav-link ">Privacy</a>', false);

        // Privacy page itself has active class
        $privacyResponse = $this->get('/privacy');
        $privacyResponse->assertStatus(200);
        $privacyResponse->assertSee('<a href="' . route('privacy') . '" class="footer-nav-link active">Privacy</a>', false);
    }
}
