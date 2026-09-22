<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shayari;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoupletController extends Controller
{
    /**
     * Store a new couplet in the database authored by the logged-in user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:150'],
            'quote' => ['required', 'string'],
            'quote_urdu' => ['nullable', 'string'],
            'english_translation' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'language' => ['nullable', 'string', 'max:40'],
            'status' => ['required', 'in:published,draft'],
        ], [
            'quote.required' => 'Please write at least one couplet or line of poetry.',
            'title.max' => 'Couplet title may not exceed 150 characters.',
        ]);

        $user = Auth::user();

        $shayari = new Shayari();
        $shayari->user_id = $user->id;
        $shayari->author_name = $user->pen_name ?: $user->name;
        $shayari->title = !empty($validated['title']) ? trim($validated['title']) : null;
        $shayari->quote = trim($validated['quote']);
        $shayari->quote_urdu = !empty($validated['quote_urdu']) ? trim($validated['quote_urdu']) : null;
        $shayari->english_translation = !empty($validated['english_translation']) ? trim($validated['english_translation']) : null;
        $shayari->category_id = $validated['category_id'] ?? null;
        $shayari->language = $validated['language'] ?? 'Roman Hindi';
        $shayari->status = $validated['status'];
        $shayari->card_size = 'small';
        $shayari->likes_count = 0;
        $shayari->save();

        $message = $shayari->status === 'published'
            ? 'Your couplet has been published to the Feed!'
            : 'Draft saved to your Poet’s Desk.';

        return redirect()->route('dashboard', ['tab' => 'desk'])->with('status', $message);
    }

    /**
     * Remove a couplet (authored by user, or any couplet if admin).
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = Auth::user();
        $query = Shayari::where('id', $id);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $shayari = $query->firstOrFail();
        $shayari->delete();

        $message = $user->isAdmin() && $shayari->user_id !== $user->id
            ? 'Couplet removed by Admin moderation.'
            : 'Couplet deleted successfully.';

        return redirect()->back(fallback: route('dashboard', ['tab' => 'desk']))->with('status', $message);
    }

    /**
     * Toggle couplet status between published and draft.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $user = Auth::user();
        $query = Shayari::where('id', $id);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $shayari = $query->firstOrFail();
        $shayari->status = $shayari->status === 'published' ? 'draft' : 'published';
        $shayari->save();

        $statusLabel = $shayari->status === 'published' ? 'published to feed' : 'moved to drafts';

        return redirect()->back(fallback: route('dashboard', ['tab' => 'desk']))->with('status', "Couplet is now {$statusLabel}.");
    }
}
