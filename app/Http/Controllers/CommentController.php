<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Shayari;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Get approved comments for a shayari.
     */
    public function index(int $shayariId): JsonResponse
    {
        $shayari = Shayari::findOrFail($shayariId);
        $currentUser = Auth::user();

        $comments = $shayari->comments()
            ->with('user')
            ->where('status', 'approved')
            ->oldest()
            ->get()
            ->map(function ($comment) use ($currentUser) {
                $user = $comment->user;
                $authorName = $user ? ($user->pen_name ?: $user->name) : 'Alfaaz Reader';
                $initial = strtoupper(mb_substr($authorName, 0, 1));

                return [
                    'id' => $comment->id,
                    'shayari_id' => $comment->shayari_id,
                    'user_id' => $comment->user_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at ? $comment->created_at->diffForHumans() : 'Just now',
                    'author_name' => $authorName,
                    'author_initial' => $initial,
                    'avatar_color' => $user->avatar_color ?? '#7052FF',
                    'avatar_url' => $user->avatar_url ?? null,
                    'is_admin' => $user ? $user->isAdmin() : false,
                    'can_delete' => $currentUser && ($currentUser->id === $comment->user_id || $currentUser->isAdmin()),
                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments,
            'comments_count' => $comments->count(),
        ]);
    }

    /**
     * Store a new comment on a couplet.
     */
    public function store(Request $request, int $shayariId): JsonResponse
    {
        $shayari = Shayari::findOrFail($shayariId);
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in to share your reflection.',
            ], 401);
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        $rawBody = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $validated['body']);
        $cleanBody = strip_tags(trim($rawBody));
        if (mb_strlen($cleanBody) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Your reflection must contain at least 2 characters.',
            ], 422);
        }

        $comment = new Comment();
        $comment->shayari_id = $shayari->id;
        $comment->user_id = $user->id;
        $comment->parent_id = $validated['parent_id'] ?? null;
        $comment->body = $cleanBody;
        $comment->status = 'approved';
        $comment->save();

        $authorName = $user->pen_name ?: $user->name;
        $initial = strtoupper(mb_substr($authorName, 0, 1));
        $totalCount = $shayari->comments()->where('status', 'approved')->count();

        return response()->json([
            'success' => true,
            'message' => 'Your reflection has been posted.',
            'comment' => [
                'id' => $comment->id,
                'shayari_id' => $comment->shayari_id,
                'user_id' => $comment->user_id,
                'body' => $comment->body,
                'created_at' => 'Just now',
                'author_name' => $authorName,
                'author_initial' => $initial,
                'avatar_color' => $user->avatar_color ?? '#7052FF',
                'avatar_url' => $user->avatar_url ?? null,
                'is_admin' => $user->isAdmin(),
                'can_delete' => true,
            ],
            'comments_count' => $totalCount,
        ], 201);
    }

    /**
     * Delete a comment (author or admin only).
     */
    public function destroy(int $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        if ($comment->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete this reflection.',
            ], 403);
        }

        $shayariId = $comment->shayari_id;
        $comment->delete();

        $remainingCount = Comment::where('shayari_id', $shayariId)
            ->where('status', 'approved')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Reflection removed.',
            'comments_count' => $remainingCount,
        ]);
    }
}
