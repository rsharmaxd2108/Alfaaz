<?php

namespace Tests\Feature;

use App\Models\Shayari;
use Carbon\Carbon;
use Tests\TestCase;

class DailyVerseTest extends TestCase
{
    public function test_daily_verse_page_renders_successfully(): void
    {
        $today = Carbon::now();
        $expectedDate = $today->format('l, F j, Y');

        $response = $this->get('/daily-verse');

        $response->assertStatus(200);
        $response->assertSee('Daily <span class="highlight-wrapper">Verse', false);
        $response->assertSee($expectedDate);
        $response->assertSee('Why this verse matters');
        $response->assertSee('Meaning in English:');
        $response->assertSee('Copy Couplet');

        // Verify like badge is absent
        $response->assertDontSee('btn-daily-like');
        $response->assertDontSee('like-badge');
    }

    public function test_daily_verse_page_renders_archive_section(): void
    {
        $response = $this->get('/daily-verse');

        $response->assertStatus(200);
        $response->assertSee('Anthology Archive');
        $response->assertSee('Recent Daily Verses');
        $response->assertSee('archive-item');
    }

    public function test_daily_verse_rotates_automatically_by_day(): void
    {
        $day1 = Carbon::parse('2026-09-21');
        $day2 = Carbon::parse('2026-09-22');

        $verse1 = Shayari::getDailyVerse($day1);
        $verse2 = Shayari::getDailyVerse($day2);

        $this->assertEquals('Monday, September 21, 2026', $verse1['date']);
        $this->assertEquals('Tuesday, September 22, 2026', $verse2['date']);
        $this->assertNotEquals($verse1['quote'], $verse2['quote']);

        // Verify archive produces 4 previous days
        $archive1 = Shayari::getDailyArchive($day1);
        $this->assertCount(4, $archive1);
        $this->assertEquals('Sep 20, 2026', $archive1[0]['date']);
        $this->assertEquals('Sep 19, 2026', $archive1[1]['date']);
        $this->assertEquals('Sep 18, 2026', $archive1[2]['date']);
        $this->assertEquals('Sep 17, 2026', $archive1[3]['date']);
    }

    public function test_landing_page_daily_verse_section_renders_current_verse(): void
    {
        $today = Carbon::now();
        $dailyVerse = Shayari::getDailyVerse($today);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="daily-verse"', false);
        $response->assertSee($dailyVerse['date']);
        $response->assertSee($dailyVerse['author']);
        $response->assertSee(e($dailyVerse['quote']));
    }
}
