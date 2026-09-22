<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    /**
     * Redirect user to Google OAuth consent screen.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google Sign-in credentials are not yet configured in .env file.',
            ]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle incoming OAuth callback from Google.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google Sign-in credentials are not yet configured in .env file.',
            ]);
        }

        try {
            /** @var \Laravel\Socialite\Two\User $googleUser */
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to authenticate with Google. Please try again or sign in with email.',
            ]);
        }

        $email = strtolower(trim((string) $googleUser->getEmail()));
        if (empty($email)) {
            return redirect()->route('login')->withErrors([
                'email' => 'No verified email returned from Google.',
            ]);
        }

        // 1. Check if user with this google_id already exists
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // 2. Check if a user with this email exists (link account)
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->google_id = $googleUser->getId();
                if (empty($user->avatar_path) && !empty($googleUser->getAvatar())) {
                    $user->avatar_path = $googleUser->getAvatar();
                }
                $user->save();
            } else {
                // 3. Register new user via Google
                $palette = ['#7052FF', '#DF7656', '#2E9D61', '#5B7BE8', '#8B5CF6'];
                $avatarColor = $palette[array_rand($palette)];

                $name = trim((string) $googleUser->getName()) ?: 'Poet';

                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->google_id = $googleUser->getId();
                $user->pen_name = $name;
                $user->avatar_color = $avatarColor;
                $user->avatar_path = $googleUser->getAvatar();
                $user->role = 'user';
                $user->email_verified_at = now();
                $user->save();
            }
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', "Welcome, {$user->name}!");
    }
}
