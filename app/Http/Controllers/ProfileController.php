<?php

namespace App\Http\Controllers;

use App\Models\Shayari;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user profile with literary analytics.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('status', 'Please sign in to view your profile.');
        }

        // Compute literary stats
        $publishedCount = Shayari::where('user_id', $user->id)
            ->where('status', 'published')
            ->count();

        $draftsCount = Shayari::where('user_id', $user->id)
            ->where('status', 'draft')
            ->count();

        $totalLikes = (int) Shayari::where('user_id', $user->id)->sum('likes_count');
        $bookmarksCount = $user->bookmarks()->count();

        $memberSince = $user->created_at ? $user->created_at->format('F Y') : 'September 2026';

        return view('profile', compact('user', 'publishedCount', 'draftsCount', 'totalLikes', 'bookmarksCount', 'memberSince'));
    }

    /**
     * Update user details and avatar.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'pen_name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email:rfc', 'max:150', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar_color' => ['nullable', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Your name is required.',
            'email.required' => 'A valid email address is required.',
            'email.unique' => 'This email address is already associated with another account.',
            'avatar.image' => 'The uploaded file must be an image.',
            'avatar.mimes' => 'Profile picture must be a JPG, PNG, or WEBP file.',
            'avatar.max' => 'Profile picture size may not exceed 2MB.',
        ]);

        // 1. Handle remove avatar flag
        if ($request->boolean('remove_avatar')) {
            if (!empty($user->avatar_path) && File::exists(public_path($user->avatar_path))) {
                File::delete(public_path($user->avatar_path));
            }
            $user->avatar_path = null;
        }

        // 2. Handle photo upload
        if ($request->hasFile('avatar')) {
            // Delete previous photo if exists
            if (!empty($user->avatar_path) && File::exists(public_path($user->avatar_path))) {
                File::delete(public_path($user->avatar_path));
            }

            $file = $request->file('avatar');
            $extension = $file->guessExtension() ?: 'jpg';
            $filename = 'avatar_' . $user->id . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
            $destinationPath = public_path('uploads/avatars');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $filename);
            $user->avatar_path = 'uploads/avatars/' . $filename;
        }

        // 3. Update text fields
        $user->name = trim($validated['name']);
        $user->pen_name = !empty($validated['pen_name']) ? trim($validated['pen_name']) : null;
        $user->email = trim($validated['email']);
        $user->bio = !empty($validated['bio']) ? trim($validated['bio']) : null;
        if (!empty($validated['avatar_color'])) {
            $user->avatar_color = $validated['avatar_color'];
        }

        $user->save();

        return redirect()->route('profile')->with('status', 'Profile details updated successfully.');
    }

    /**
     * Update user password securely.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:128',
                'confirmed',
                Password::min(8)->letters()->numbers()->symbols(),
            ],
        ], [
            'current_password.required' => 'Current password is required to verify identity.',
            'current_password.current_password' => 'The current password you provided does not match our records.',
            'password.required' => 'A new password is required.',
            'password.min' => 'New password must be at least 8 characters long.',
            'password.max' => 'Password length may not exceed 128 characters.',
            'password.confirmed' => 'New password confirmation does not match.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('profile')->with('status', 'Password updated successfully.');
    }
}

