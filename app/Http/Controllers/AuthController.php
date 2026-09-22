<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the signup page.
     */
    public function signupView(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.signup');
    }

    /**
     * Display the login page.
     */
    public function loginView(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Process user signup with strict validation, email canonicalization, and single hashing.
     */
    public function signup(Request $request): RedirectResponse
    {
        if ($request->has('email')) {
            $request->merge([
                'email' => strtolower(trim((string) $request->email)),
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:191', 'unique:users,email'],
            'password' => ['required', 'string', 'max:128', Password::min(8)->letters()->numbers()],
            'terms' => ['accepted'],
        ], [
            'name.required' => 'Please provide your name or pen name.',
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'An account with this email address already exists.',
            'password.required' => 'A password is required.',
            'password.max' => 'Your password may not exceed 128 characters.',
            'terms.accepted' => 'Please agree to the Terms and Privacy Policy to create an account.',
        ]);

        // User model casts password => 'hashed', so passing validated string will hash it once
        $user = new User();
        $user->name = trim($validated['name']);
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->pen_name = trim($validated['name']);
        $user->avatar_color = '#7052FF';
        $user->role = 'user'; // Explicitly assign role (protected from mass-assignment)
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Welcome to Alfaaz!');
    }

    /**
     * Process user login with canonical email lookup and session regeneration.
     */
    public function login(Request $request): RedirectResponse
    {
        if ($request->has('email')) {
            $request->merge([
                'email' => strtolower(trim((string) $request->email)),
            ]);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'max:128'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
            'password.max' => 'Your password may not exceed 128 characters.',
        ]);

        $remember = $request->boolean('remember', true);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out authenticated user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'You have been safely signed out.');
    }
}
