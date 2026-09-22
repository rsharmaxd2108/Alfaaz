<?php

namespace Tests\Feature;

use Tests\TestCase;

class ErrorPagesAndSeoTest extends TestCase
{
    public function test_custom_404_error_page_renders_with_brand_and_poetry()
    {
        $response = $this->get('/non-existent-page-' . uniqid());

        $response->assertStatus(404);
        $response->assertSee('Lost in the Stanzas', false);
        $response->assertSee('Return to Sanctuary');
        $response->assertSee('Gumnam Alfaaz');
        $response->assertSee('بھٹکتے پھرتے ہیں کچھ لفظ راستوں میں یوں', false);
    }

    public function test_seo_and_open_graph_meta_tags_present_in_layout()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta property="og:type" content="website">', false);
        $response->assertSee('<meta property="og:site_name" content="Alfaaz">', false);
        $response->assertSee('og:title', false);
        $response->assertSee('og:description', false);
        $response->assertSee('og:image', false);
        $response->assertSee('twitter:card', false);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<link rel="icon" type="image/x-icon"', false);
    }

    public function test_custom_500_view_renders_properly()
    {
        $view = $this->view('errors.500');

        $view->assertSee('An Unexpected');
        $view->assertSee('Silence');
        $view->assertSee('Return to Sanctuary');
        $view->assertSee('Khamooshi');
        $view->assertSee('سازِ دل پر کوئی نغمہ نہ چھڑ سکا اب کے', false);
    }

    public function test_custom_403_view_renders_properly()
    {
        $view = $this->view('errors.403');

        $view->assertSee('A Sealed');
        $view->assertSee('Chamber');
        $view->assertSee('Restricted Chamber');
        $view->assertSee('Return to Sanctuary');
    }

    public function test_custom_419_view_renders_properly()
    {
        $view = $this->view('errors.419');

        $view->assertSee('The Ink Has');
        $view->assertSee('Dried');
        $view->assertSee('Session Inactive');
        $view->assertSee('Refresh Page');
    }

    public function test_sitemap_xml_returns_valid_response_with_key_routes()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', $response->headers->get('Content-Type'));
        $response->assertSee('<urlset', false);
        $response->assertSee('/explore', false);
        $response->assertSee('/daily-verse', false);
        $response->assertSee('/privacy', false);
    }

    public function test_pages_have_distinct_titles_and_descriptions()
    {
        // Home
        $home = $this->get('/');
        $home->assertSee('<title>Alfaaz — Words That Feel Into The Heart', false);
        $home->assertSee('Immerse yourself in a curated sanctuary', false);
        $home->assertSee('application/ld+json', false);
        $home->assertSee('Skip to content', false);

        // Explore
        $explore = $this->get('/explore');
        $explore->assertSee('<title>Explore Shayari — Curated Urdu &amp; Hindi Couplets | Alfaaz</title>', false);
        $explore->assertSee('Explore handcrafted stanzas and couplets', false);

        // Daily Verse
        $daily = $this->get('/daily-verse');
        $daily->assertSee('Daily Verse —', false);
        $daily->assertSee('Today’s Sher:', false);
        $daily->assertSee('"@type": "Quotation"', false);

        // Privacy
        $privacy = $this->get('/privacy');
        $privacy->assertSee('Privacy Policy — Creative Trust &amp; Data Protection | Alfaaz', false);
        $privacy->assertSee('Our philosophy on honoring creative expression', false);

        // Login
        $login = $this->get('/login');
        $login->assertSee('Sign In to Your Poet Desk — Alfaaz', false);
        $login->assertSee('noindex, follow', false);

        // Signup
        $signup = $this->get('/signup');
        $signup->assertSee('Join Alfaaz — A Sanctuary For Your Words', false);
        $signup->assertSee('noindex, follow', false);
    }
}
