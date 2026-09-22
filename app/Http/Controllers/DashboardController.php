<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Poet;
use App\Models\Shayari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the editorial Sunday Anthology and Poet's Desk.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // Active filter tab (writing, spoken, visual, desk)
        $activeTab = $request->query('tab', 'writing');
        $searchQuery = trim((string) $request->query('q', ''));

        $scope = $request->query('scope', 'mine');

        // Desk shayaris query: if admin and scope is 'all', watch all platform couplets
        if ($user->isAdmin() && $scope === 'all') {
            $userShayarisQuery = Shayari::with(['user', 'categoryModel'])
                ->withCount(['comments' => fn($q) => $q->where('status', 'approved')])
                ->latest();
        } else {
            $userShayarisQuery = $user->shayaris()
                ->withCount(['comments' => fn($q) => $q->where('status', 'approved')])
                ->latest();
        }

        if (!empty($searchQuery)) {
            $userShayarisQuery->where(function ($q) use ($searchQuery) {
                $q->where('quote', 'like', "%{$searchQuery}%")
                  ->orWhere('title', 'like', "%{$searchQuery}%")
                  ->orWhere('author_name', 'like', "%{$searchQuery}%")
                  ->orWhere('english_translation', 'like', "%{$searchQuery}%");
            });
        }
        $userShayaris = $userShayarisQuery->get();

        $publishedCount = $user->shayaris()->where('status', 'published')->count();
        $draftsCount = $user->shayaris()->where('status', 'draft')->count();
        $totalLikes = $user->shayaris()->sum('likes_count');
        $allPlatformCount = $user->isAdmin() ? Shayari::count() : 0;

        // Community / Feed shayaris (genuine published couplets only)
        $feedShayarisQuery = Shayari::with(['poet', 'categoryModel', 'user'])
            ->withCount(['comments' => fn($q) => $q->where('status', 'approved')])
            ->where('status', 'published')
            ->latest();

        if (!empty($searchQuery)) {
            $feedShayarisQuery->where(function ($q) use ($searchQuery) {
                $q->where('quote', 'like', "%{$searchQuery}%")
                  ->orWhere('title', 'like', "%{$searchQuery}%")
                  ->orWhere('author_name', 'like', "%{$searchQuery}%")
                  ->orWhere('english_translation', 'like', "%{$searchQuery}%");
            });
        }

        $feedShayaris = $feedShayarisQuery->take(30)->get();

        // Bookmarked shayaris for saved collection tab
        $bookmarksCount = $user->bookmarks()->count();
        $bookmarkedShayaris = $activeTab === 'bookmarks'
            ? $user->bookmarkedShayaris()
                ->with(['poet', 'categoryModel', 'user'])
                ->withCount(['comments' => fn($q) => $q->where('status', 'approved')])
                ->latest()
                ->get()
            : collect();

        // Fast O(1) lookups for current user's liked and bookmarked couplets
        $likedShayariIds = $user->likes()->pluck('shayari_id')->flip()->toArray();
        $bookmarkedShayariIds = $user->bookmarks()->pluck('shayari_id')->flip()->toArray();

        // Categories for Couplet Composer
        try {
            $categories = Category::all();
            if ($categories->isEmpty()) {
                $categories = collect([
                    (object) ['id' => 1, 'name' => 'Ishq (Love)'],
                    (object) ['id' => 2, 'name' => 'Dukh & Gham (Sorrow)'],
                    (object) ['id' => 3, 'name' => 'Zindagi (Reflections)'],
                    (object) ['id' => 4, 'name' => 'Sufi & Rooh (Spiritual)'],
                    (object) ['id' => 5, 'name' => 'Tanhai (Solitude)'],
                ]);
            }
        } catch (\Throwable $e) {
            $categories = collect([
                (object) ['id' => 1, 'name' => 'Ishq (Love)'],
                (object) ['id' => 2, 'name' => 'Dukh & Gham (Sorrow)'],
                (object) ['id' => 3, 'name' => 'Zindagi (Reflections)'],
                (object) ['id' => 4, 'name' => 'Sufi & Rooh (Spiritual)'],
                (object) ['id' => 5, 'name' => 'Tanhai (Solitude)'],
            ]);
        }

        return view('dashboard', compact(
            'user',
            'activeTab',
            'searchQuery',
            'scope',
            'userShayaris',
            'publishedCount',
            'draftsCount',
            'totalLikes',
            'allPlatformCount',
            'feedShayaris',
            'bookmarksCount',
            'bookmarkedShayaris',
            'likedShayariIds',
            'bookmarkedShayariIds',
            'categories'
        ));
    }
}
