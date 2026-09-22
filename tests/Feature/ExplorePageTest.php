<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExplorePageTest extends TestCase
{
    public function test_explore_page_renders_successfully_without_search_and_category_and_language(): void
    {
        $response = $this->get('/explore');

        $response->assertStatus(200);
        $response->assertDontSee('header-search-form', false);
        $response->assertDontSee('explore-search-bar', false);
        $response->assertDontSee('category-pills-list', false);
        $response->assertDontSee('results-meta-bar', false);
        $response->assertDontSee('language-toggle-group', false);
        $response->assertDontSee('Language:', false);
        // Ensure cards grid is present with both large and small blocks
        $response->assertSee('cards-grid');
        $response->assertSee('card-large');
        $response->assertSee('card-small');
        $response->assertDontSee('like-badge', false);
        $response->assertDontSee('publish-date', false);
        // Check that 4 cards are rendered
        $this->assertEquals(4, substr_count($response->getContent(), 'class="shayari-card'));
    }

    public function test_home_page_explore_section_renders_without_search_and_category_and_language(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('header-search-form', false);
        $response->assertDontSee('homeExploreSearchForm', false);
        $response->assertDontSee('homeCategoryPills', false);
        $response->assertDontSee('homeResultsCount', false);
        $response->assertDontSee('homeLanguagePills', false);
        $response->assertDontSee('Language:', false);
        $response->assertDontSee('homeCardsGrid" class="cards-grid"><article class="shayari-card ... like-badge');
        // Ensure cards grid is present with both large and small blocks
        $response->assertSee('homeCardsGrid');
        $response->assertSee('card-large');
        $response->assertSee('card-small');
        // Check that 4 cards are rendered in home explore grid
        $homeGridHtml = explode('id="homeCardsGrid"', $response->getContent())[1] ?? '';
        $homeGridHtml = explode('</section>', $homeGridHtml)[0] ?? '';
        $this->assertEquals(4, substr_count($homeGridHtml, 'class="shayari-card'));
        $this->assertStringNotContainsString('like-badge', $homeGridHtml);
        $this->assertStringNotContainsString('publish-date', $homeGridHtml);
    }

    public function test_footer_links_on_home_and_subpages(): void
    {
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<a href="#explore" class="footer-nav-link">Explore</a>', false);
        $homeResponse->assertSee('<a href="#daily-verse" class="footer-nav-link">Daily Verse</a>', false);
        $homeResponse->assertSee('<a href="#home" class="footer-brand">', false);

        $subResponse = $this->get('/explore');
        $subResponse->assertStatus(200);
        $subResponse->assertSee('<a href="' . route('home') . '#explore" class="footer-nav-link">Explore</a>', false);
        $subResponse->assertSee('<a href="' . route('home') . '#daily-verse" class="footer-nav-link">Daily Verse</a>', false);
    }

    public function test_explore_verses_rotate_daily_with_correct_structure(): void
    {
        $day1 = \Carbon\Carbon::parse('2026-09-21');
        $day2 = \Carbon\Carbon::parse('2026-09-22');

        $verses1 = \App\Models\Shayari::getExploreVerses($day1);
        $verses2 = \App\Models\Shayari::getExploreVerses($day2);

        $this->assertCount(4, $verses1);
        $this->assertCount(4, $verses2);

        // Verify asymmetric sizing
        $this->assertEquals('large', $verses1[0]->card_size);
        $this->assertEquals('small', $verses1[1]->card_size);
        $this->assertEquals('small', $verses1[2]->card_size);
        $this->assertEquals('large', $verses1[3]->card_size);

        // Verify dynamic rotation across days
        $this->assertNotEquals($verses1[0]->quote, $verses2[0]->quote);

        // Verify required properties are present
        foreach ($verses1 as $verse) {
            $this->assertNotEmpty($verse->quote);
            $this->assertNotEmpty($verse->author);
            $this->assertNotEmpty($verse->category);
            $this->assertNotEmpty($verse->category_type);
            $this->assertNotEmpty($verse->language);
            $this->assertNotEmpty($verse->date);
            $this->assertIsInt($verse->likes);
            $this->assertNotEmpty($verse->avatar_color);
        }
    }
}
