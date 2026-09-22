@extends('layouts.app')

@section('title', '419 — Page Expired | Alfaaz')

@section('content')
<div class="landing-content" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div style="max-width: 620px; width: 100%; text-align: center;">
        
        <!-- Badge -->
        <div class="intro-badge" style="display: inline-flex; margin-bottom: 20px;">
            <span class="badge-dot" style="background-color: var(--brand-purple);"></span>
            <span class="badge-text">Error 419 • Session Inactive</span>
        </div>

        <!-- Title -->
        <h1 class="hero-title" style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 2.75rem); line-height: 1.2; margin-bottom: 16px; color: var(--text-primary);">
            The Ink Has <span class="highlight-wrapper">Dried<span class="highlight-stroke"></span></span>
        </h1>

        <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 32px;">
            Your parchment was left open for too long and the security token has expired. Please refresh the page to dip your quill again.
        </p>

        <!-- Action CTAs -->
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
            <a href="javascript:window.location.reload();" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 26px; border-radius: 9999px; font-weight: 600; font-size: 0.95rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                </svg>
                <span>Refresh Page</span>
            </a>
            <a href="{{ route('home') }}" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 24px; border-radius: 9999px; font-weight: 600; font-size: 0.95rem;">
                <span>Return to Sanctuary</span>
            </a>
        </div>

    </div>
</div>
@endsection
