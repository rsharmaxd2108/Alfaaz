<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Like;
use App\Models\Shayari;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    /**
     * Toggle like appreciation on a couplet.
     */
    public function toggleLike(Request $request, int $id): JsonResponse
    {
        $shayari = Shayari::findOrFail($id);
        $user = Auth::user();
        $sessionId = $request->session()->getId();

        $query = Like::where('shayari_id', $shayari->id);
        if ($user) {
            $query->where('user_id', $user->id);
        } else {
            $query->where('session_id', $sessionId);
        }

        $existingLike = $query->first();

        if ($existingLike) {
            $existingLike->delete();
            $shayari->decrement('likes_count');
            $liked = false;
        } else {
            $like = new Like();
            $like->shayari_id = $shayari->id;
            if ($user) {
                $like->user_id = $user->id;
            }
            $like->session_id = $sessionId;
            $like->save();

            $shayari->increment('likes_count');
            $liked = true;
        }

        $freshCount = max(0, (int) $shayari->fresh()->likes_count);

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $freshCount,
            'message' => $liked ? 'Added to your appreciated couplets.' : 'Removed appreciation.',
        ]);
    }

    /**
     * Toggle bookmark save on a couplet (authenticated poets only).
     */
    public function toggleBookmark(Request $request, int $id): JsonResponse
    {
        $shayari = Shayari::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in to save couplets.',
            ], 401);
        }

        $existingBookmark = Bookmark::where('user_id', $user->id)
            ->where('shayari_id', $shayari->id)
            ->first();

        if ($existingBookmark) {
            $existingBookmark->delete();
            $bookmarked = false;
        } else {
            $bookmark = new Bookmark();
            $bookmark->user_id = $user->id;
            $bookmark->shayari_id = $shayari->id;
            $bookmark->save();
            $bookmarked = true;
        }

        $bookmarksCount = $user->bookmarks()->count();

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'bookmarks_count' => $bookmarksCount,
            'message' => $bookmarked ? 'Couplet saved to your collection.' : 'Removed from your saved collection.',
        ]);
    }
}
