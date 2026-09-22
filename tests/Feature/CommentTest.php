<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Shayari;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected User $otherUser;
    protected User $adminUser;
    protected Shayari $shayari;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::firstOrCreate(
            ['email' => 'reflection_poet@alfaaz.com'],
            [
                'name' => 'Reflection Poet',
                'password' => Hash::make('password123'),
                'pen_name' => 'Reflector',
                'avatar_color' => '#7052FF',
                'role' => 'user',
            ]
        );

        $this->otherUser = User::firstOrCreate(
            ['email' => 'other_poet@alfaaz.com'],
            [
                'name' => 'Other Poet',
                'password' => Hash::make('password123'),
                'pen_name' => 'Other',
                'avatar_color' => '#DF7656',
                'role' => 'user',
            ]
        );

        $this->adminUser = User::firstOrCreate(
            ['email' => 'admin_test_poet@alfaaz.com'],
            [
                'name' => 'Admin Moderator',
                'password' => Hash::make('password123'),
                'pen_name' => 'Admin',
                'avatar_color' => '#1C1917',
                'role' => 'admin',
            ]
        );

        // Find or create test couplet
        $this->shayari = Shayari::first() ?? Shayari::create([
            'user_id' => $this->user->id,
            'title' => 'Test Couplet For Reflections',
            'quote' => 'Har alfaaz mein ek kahani chhipi hoti hai.',
            'status' => 'published',
            'language' => 'Urdu',
            'likes_count' => 0,
        ]);
    }

    public function test_guest_can_list_comments_publicly(): void
    {
        Comment::create([
            'shayari_id' => $this->shayari->id,
            'user_id' => $this->user->id,
            'body' => 'A wonderful verse.',
            'status' => 'approved',
        ]);

        $response = $this->getJson("/shayaris/{$this->shayari->id}/comments");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'comments',
                'comments_count',
            ]);
    }

    public function test_guest_cannot_post_comment(): void
    {
        $response = $this->postJson("/shayaris/{$this->shayari->id}/comments", [
            'body' => 'This should be unauthorized.',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_post_comment_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->postJson("/shayaris/{$this->shayari->id}/comments", [
            'body' => 'Truly a touching couplet with deep resonance.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Your reflection has been posted.',
            ])
            ->assertJsonPath('comment.body', 'Truly a touching couplet with deep resonance.')
            ->assertJsonPath('comment.can_delete', true);

        $this->assertDatabaseHas('comments', [
            'shayari_id' => $this->shayari->id,
            'user_id' => $this->user->id,
            'body' => 'Truly a touching couplet with deep resonance.',
            'status' => 'approved',
        ]);
    }

    public function test_comment_requires_minimum_two_characters(): void
    {
        $response = $this->actingAs($this->user)->postJson("/shayaris/{$this->shayari->id}/comments", [
            'body' => 'A',
        ]);

        $response->assertStatus(422);
    }

    public function test_comment_cannot_exceed_1000_characters(): void
    {
        $response = $this->actingAs($this->user)->postJson("/shayaris/{$this->shayari->id}/comments", [
            'body' => str_repeat('A', 1001),
        ]);

        $response->assertStatus(422);
    }

    public function test_comment_strips_html_tags_for_xss_protection(): void
    {
        $response = $this->actingAs($this->user)->postJson("/shayaris/{$this->shayari->id}/comments", [
            'body' => '<script>alert("xss")</script>Subhanallah!',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'shayari_id' => $this->shayari->id,
            'body' => 'Subhanallah!',
        ]);
        $this->assertDatabaseMissing('comments', [
            'body' => '<script>alert("xss")</script>Subhanallah!',
        ]);
    }

    public function test_author_can_delete_own_comment(): void
    {
        $comment = Comment::create([
            'shayari_id' => $this->shayari->id,
            'user_id' => $this->user->id,
            'body' => 'Temporary reflection to delete.',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->user)->deleteJson("/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Reflection removed.',
            ]);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_non_author_cannot_delete_other_users_comment(): void
    {
        $comment = Comment::create([
            'shayari_id' => $this->shayari->id,
            'user_id' => $this->user->id,
            'body' => 'User comment that other cannot delete.',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->otherUser)->deleteJson("/comments/{$comment->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_admin_can_delete_any_users_comment(): void
    {
        $comment = Comment::create([
            'shayari_id' => $this->shayari->id,
            'user_id' => $this->user->id,
            'body' => 'User comment that admin will moderate.',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->adminUser)->deleteJson("/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Reflection removed.',
            ]);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_dashboard_renders_comment_button_and_drawer(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee("commentBtn_{$this->shayari->id}", false);
        $response->assertSee("commentsDrawer_{$this->shayari->id}", false);
        $response->assertSee("commentInput_{$this->shayari->id}", false);
        $response->assertSee('Reflections & Notes', false);
    }
}
