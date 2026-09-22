<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WriteController extends Controller
{
    /**
     * Handle the Write button action:
     * If user is authenticated or active session exists, direct to dashboard; otherwise redirect to signup.
     */
    public function index(Request $request): RedirectResponse
    {
        if (Auth::check() || session()->has('user')) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('signup');
    }
}
