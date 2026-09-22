<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\PoetController;
use App\Http\Controllers\DailyVerseController;
use App\Http\Controllers\WriteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CoupletController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Public browsing routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/poets', [PoetController::class, 'index'])->name('poets');
Route::get('/daily-verse', [DailyVerseController::class, 'index'])->name('daily-verse');
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/shayaris/{id}/comments', [CommentController::class, 'index'])->name('comments.index');

// Dynamic XML Sitemap for Search Engines
Route::get('/sitemap.xml', function () {
    $baseUrl = url('/');
    $lastMod = date('Y-m-d');
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= "<url><loc>{$baseUrl}</loc><lastmod>{$lastMod}</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>";
    $xml .= "<url><loc>{$baseUrl}/explore</loc><lastmod>{$lastMod}</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>";
    $xml .= "<url><loc>{$baseUrl}/daily-verse</loc><lastmod>{$lastMod}</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>";
    $xml .= "<url><loc>{$baseUrl}/privacy</loc><lastmod>{$lastMod}</lastmod><changefreq>monthly</changefreq><priority>0.5</priority></url>";
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'text/xml');
})->name('sitemap');

// Smart Write route (routes guests to signup, authenticated to dashboard)
Route::get('/write', [WriteController::class, 'index'])->name('write');

// Guest authentication routes (with brute-force rate-limiting)
Route::middleware('guest')->group(function () {
    Route::get('/signup', [AuthController::class, 'signupView'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup'])->middleware('throttle:signup')->name('signup.post');

    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.post');

    // Google OAuth
    Route::get('/auth/google', [OAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [OAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->middleware('throttle:10,1')->name('password.update');
});

// Protected member routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Couplet management from dashboard studio
    Route::post('/dashboard/couplets', [CoupletController::class, 'store'])->middleware('throttle:30,1')->name('couplets.store');
    Route::delete('/dashboard/couplets/{id}', [CoupletController::class, 'destroy'])->middleware('throttle:30,1')->name('couplets.destroy');
    Route::post('/dashboard/couplets/{id}/toggle-status', [CoupletController::class, 'toggleStatus'])->middleware('throttle:30,1')->name('couplets.toggle-status');

    // Couplet interactions (likes & bookmarks)
    Route::post('/shayaris/{id}/toggle-like', [InteractionController::class, 'toggleLike'])->middleware('throttle:60,1')->name('shayaris.toggle-like');
    Route::post('/shayaris/{id}/toggle-bookmark', [InteractionController::class, 'toggleBookmark'])->middleware('throttle:60,1')->name('shayaris.toggle-bookmark');

    // Couplet comments
    Route::post('/shayaris/{id}/comments', [CommentController::class, 'store'])->middleware('throttle:20,1')->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('throttle:30,1')->name('comments.destroy');
});
