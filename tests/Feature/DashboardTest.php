<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Shayari;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::firstOrCreate(
            ['email' => 'poet_dash@alfaaz.com'],
            [
                'name' => 'Dashboard Poet',
                'password' => Hash::make('secretpass123'),
                'pen_name' => 'DashPoet',
                'avatar_color' => '#7052FF',
                'role' => 'user',
            ]
        );
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_sunday_anthology_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Diwan-e-Alfaaz.');
        $response->assertSee('COMMUNITY DIWAN');
        $response->assertSee('tab=writing');
        $response->assertSee('tab=desk');
        $response->assertDontSee('tab=spoken');
        $response->assertDontSee('tab=visual');
        $response->assertDontSee('TOP CONTRIBUTORS');
        $response->assertDontSee('PROMPT OF THE WEEK');
        $response->assertDontSee('YOUR COLLECTIONS');
        $response->assertDontSee('FEATURED CREATOR');
        $response->assertDontSee('Public Homepage');
        $response->assertDontSee('Explore Archive');
        $response->assertDontSee('Explore Couplets');
    }

    public function test_latest_post_appears_on_top_of_dashboard_feed(): void
    {
        $uniquePhrase = 'Brand new latest couplet ' . uniqid();
        $newSher = Shayari::create([
            'user_id' => $this->user->id,
            'author_name' => 'Recent Poet',
            'quote' => $uniquePhrase,
            'status' => 'published',
            'card_size' => 'small',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee($uniquePhrase);
        $response->assertDontSee('FEATURED CREATOR');
    }

    public function test_user_can_view_my_desk_tab(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard?tab=desk');

        $response->assertStatus(200);
        $response->assertSee('Published Couplets');
        $response->assertSee('Drafts in Studio');
    }

    public function test_user_can_compose_and_publish_couplet(): void
    {
        $quote = 'Dard ki dhoop mein saaya jo bana karta tha, ' . uniqid();

        $response = $this->actingAs($this->user)->post('/dashboard/couplets', [
            'quote' => $quote,
            'quote_urdu' => 'درد کی دھوپ میں سایا جو بنا کرتا تھا',
            'english_translation' => 'The one who used to become shade in the scorching sun of pain.',
            'language' => 'Roman Hindi',
            'status' => 'published',
        ]);

        $response->assertRedirect('/dashboard?tab=desk');
        $response->assertSessionHas('status', 'Your couplet has been published to the Feed!');

        $this->assertDatabaseHas('shayaris', [
            'user_id' => $this->user->id,
            'quote' => $quote,
            'status' => 'published',
        ]);
    }

    public function test_user_can_compose_couplet_with_title(): void
    {
        $title = 'Aatish-e-Ishq ' . uniqid();
        $quote = 'Dard ki dhoop mein saaya jo bana karta tha, ' . uniqid();

        $response = $this->actingAs($this->user)->post('/dashboard/couplets', [
            'title' => $title,
            'quote' => $quote,
            'language' => 'Roman Hindi',
            'status' => 'published',
        ]);

        $response->assertRedirect('/dashboard?tab=desk');

        $this->assertDatabaseHas('shayaris', [
            'user_id' => $this->user->id,
            'title' => $title,
            'quote' => $quote,
            'status' => 'published',
        ]);

        // Check that title appears on feed
        $feedResponse = $this->actingAs($this->user)->get('/dashboard');
        $feedResponse->assertSee($title);

        // Check that title appears on poet desk
        $deskResponse = $this->actingAs($this->user)->get('/dashboard?tab=desk');
        $deskResponse->assertSee($title);
    }

    public function test_user_can_save_couplet_as_draft(): void
    {
        $quote = 'Khamoshi bhi ik zabaan hoti hai, ' . uniqid();

        $response = $this->actingAs($this->user)->post('/dashboard/couplets', [
            'quote' => $quote,
            'language' => 'Roman Hindi',
            'status' => 'draft',
        ]);

        $response->assertRedirect('/dashboard?tab=desk');
        $response->assertSessionHas('status', 'Draft saved to your Poet’s Desk.');

        $this->assertDatabaseHas('shayaris', [
            'user_id' => $this->user->id,
            'quote' => $quote,
            'status' => 'draft',
        ]);
    }

    public function test_couplet_validation_fails_if_quote_empty(): void
    {
        $response = $this->actingAs($this->user)->from('/dashboard')->post('/dashboard/couplets', [
            'quote' => '',
            'status' => 'published',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHasErrors('quote');
    }

    public function test_user_can_compose_long_shayari_without_word_or_character_limit(): void
    {
        // Multi-stanza ghazal / long nazm exceeding 2,500 characters
        $longPoem = str_repeat("Ye husn-e-kalam hai, ye alfaz ka dariya hai, dil se jo nikla hai wo rooh ka hissa hai.\n", 35);
        $this->assertGreaterThan(2500, strlen($longPoem));

        $response = $this->actingAs($this->user)->from('/dashboard')->post('/dashboard/couplets', [
            'title' => 'Long Ghazal Title',
            'quote' => $longPoem,
            'quote_urdu' => str_repeat("یہ حسن کلام ہے، یہ الفاظ کا دریا ہے۔\n", 20),
            'english_translation' => str_repeat("This is the beauty of words, an unending river of expressions.", 15),
            'status' => 'published',
        ]);

        $response->assertRedirect('/dashboard?tab=desk');
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('shayaris', [
            'user_id' => $this->user->id,
            'title' => 'Long Ghazal Title',
            'status' => 'published',
        ]);
    }

    public function test_user_can_toggle_couplet_status(): void
    {
        $shayari = Shayari::create([
            'user_id' => $this->user->id,
            'quote' => 'Test toggle verse ' . uniqid(),
            'status' => 'published',
            'card_size' => 'small',
        ]);

        $response = $this->actingAs($this->user)->post("/dashboard/couplets/{$shayari->id}/toggle-status");
        $response->assertRedirect('/dashboard?tab=desk');

        $shayari->refresh();
        $this->assertEquals('draft', $shayari->status);
    }

    public function test_user_can_delete_own_couplet(): void
    {
        $shayari = Shayari::create([
            'user_id' => $this->user->id,
            'quote' => 'Verse to be deleted ' . uniqid(),
            'status' => 'published',
            'card_size' => 'small',
        ]);

        $response = $this->actingAs($this->user)->delete("/dashboard/couplets/{$shayari->id}");
        $response->assertRedirect('/dashboard?tab=desk');

        $this->assertDatabaseMissing('shayaris', [
            'id' => $shayari->id,
        ]);
    }

    public function test_user_cannot_delete_another_users_couplet(): void
    {
        $otherUser = User::firstOrCreate(
            ['email' => 'other_poet@alfaaz.com'],
            [
                'name' => 'Other Poet',
                'password' => Hash::make('secretpass123'),
                'pen_name' => 'OtherPoet',
                'role' => 'user',
            ]
        );

        $otherShayari = Shayari::create([
            'user_id' => $otherUser->id,
            'quote' => 'Protected verse by someone else ' . uniqid(),
            'status' => 'published',
            'card_size' => 'small',
        ]);

        $response = $this->actingAs($this->user)->delete("/dashboard/couplets/{$otherShayari->id}");
        $response->assertStatus(404);

        $this->assertDatabaseHas('shayaris', [
            'id' => $otherShayari->id,
        ]);
    }

    public function test_admin_can_delete_any_users_couplet(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'r.sharmaxd2108@gmail.com'],
            [
                'name' => 'Rahul Sharma',
                'password' => Hash::make('Rahul@123'),
                'pen_name' => 'Rahul',
                'role' => 'admin',
            ]
        );

        $victimPoet = User::firstOrCreate(
            ['email' => 'poet_to_moderate@alfaaz.com'],
            [
                'name' => 'Flagged Poet',
                'password' => Hash::make('secretpass123'),
                'pen_name' => 'FlaggedPoet',
                'role' => 'user',
            ]
        );

        $spamCouplet = Shayari::create([
            'user_id' => $victimPoet->id,
            'quote' => 'Inappropriate or spam couplet ' . uniqid(),
            'status' => 'published',
            'card_size' => 'small',
        ]);

        // Admin deletes it
        $response = $this->actingAs($admin)->delete("/dashboard/couplets/{$spamCouplet->id}");
        $response->assertRedirect('/dashboard?tab=desk');
        $response->assertSessionHas('status', 'Couplet removed by Admin moderation.');

        $this->assertDatabaseMissing('shayaris', [
            'id' => $spamCouplet->id,
        ]);
    }

    public function test_admin_sees_moderation_controls_on_feed(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'r.sharmaxd2108@gmail.com'],
            [
                'name' => 'Rahul Sharma',
                'password' => Hash::make('Rahul@123'),
                'pen_name' => 'Rahul',
                'role' => 'admin',
            ]
        );

        $regularUser = $this->user;

        $sher = Shayari::create([
            'user_id' => $regularUser->id,
            'quote' => 'Feed couplet for admin test ' . uniqid(),
            'status' => 'published',
            'card_size' => 'small',
        ]);

        // Regular user should not see admin moderation button
        $regularResponse = $this->actingAs($regularUser)->get('/dashboard');
        $regularResponse->assertDontSee('Moderate: Delete Couplet (Admin)');

        // Admin should see admin moderation button
        $adminResponse = $this->actingAs($admin)->get('/dashboard');
        $adminResponse->assertSee('Moderate: Delete Couplet (Admin)');
    }

    public function test_empty_feed_displays_welcoming_state(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard?q=__empty_feed_test_no_match__');
        $response->assertStatus(200);
        $response->assertSee('The Feed awaits its first verse');
        $response->assertSee('Pen First Couplet');
    }

    public function test_user_can_like_and_unlike_shayari(): void
    {
        $sher = Shayari::create([
            'user_id' => $this->user->id,
            'quote' => 'Like interaction test verse ' . uniqid(),
            'status' => 'published',
            'likes_count' => 0,
        ]);

        // 1. Like the couplet
        $likeResponse = $this->actingAs($this->user)->postJson("/shayaris/{$sher->id}/toggle-like");
        $likeResponse->assertOk();
        $likeResponse->assertJson([
            'success' => true,
            'liked' => true,
            'likes_count' => 1,
        ]);

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'shayari_id' => $sher->id,
        ]);
        $this->assertEquals(1, $sher->fresh()->likes_count);

        // 2. Unlike the couplet
        $unlikeResponse = $this->actingAs($this->user)->postJson("/shayaris/{$sher->id}/toggle-like");
        $unlikeResponse->assertOk();
        $unlikeResponse->assertJson([
            'success' => true,
            'liked' => false,
            'likes_count' => 0,
        ]);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'shayari_id' => $sher->id,
        ]);
        $this->assertEquals(0, $sher->fresh()->likes_count);
    }

    public function test_user_can_bookmark_and_unbookmark_shayari(): void
    {
        $sher = Shayari::create([
            'user_id' => $this->user->id,
            'quote' => 'Bookmark interaction test verse ' . uniqid(),
            'status' => 'published',
        ]);

        // 1. Bookmark the couplet
        $bmResponse = $this->actingAs($this->user)->postJson("/shayaris/{$sher->id}/toggle-bookmark");
        $bmResponse->assertOk();
        $bmResponse->assertJson([
            'success' => true,
            'bookmarked' => true,
        ]);

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $this->user->id,
            'shayari_id' => $sher->id,
        ]);

        // 2. View bookmarked tab
        $tabResponse = $this->actingAs($this->user)->get('/dashboard?tab=bookmarks');
        $tabResponse->assertOk();
        $tabResponse->assertSee($sher->quote);

        // 3. Unbookmark the couplet
        $unbmResponse = $this->actingAs($this->user)->postJson("/shayaris/{$sher->id}/toggle-bookmark");
        $unbmResponse->assertOk();
        $unbmResponse->assertJson([
            'success' => true,
            'bookmarked' => false,
        ]);

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $this->user->id,
            'shayari_id' => $sher->id,
        ]);
    }

    public function test_guest_cannot_bookmark_shayari(): void
    {
        $sher = Shayari::first();
        $response = $this->postJson("/shayaris/{$sher->id}/toggle-bookmark");
        $response->assertStatus(401);
    }

    public function test_saved_option_is_in_profile_dropdown_and_not_in_primary_dock(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertOk();

        // Saved Couplets link should be visible in dropdown
        $response->assertSee('Saved Couplets');
        $response->assertSee('rail-dropdown-menu');

        // Verify mobile bottom nav does not contain Saved tab
        $content = $response->getContent();
        $this->assertStringContainsString('mobile-bottom-nav', $content);
        $bottomNav = substr($content, strpos($content, '<nav class="mobile-bottom-nav"'));
        $bottomNav = substr($bottomNav, 0, strpos($bottomNav, '</nav>'));
        $this->assertStringNotContainsString('<span>Saved</span>', $bottomNav);
    }
}
