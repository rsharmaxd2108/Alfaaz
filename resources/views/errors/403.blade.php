@extends('layouts.app')

@section('title', '403 — Forbidden Sanctuary | Alfaaz')

@section('content')
<div class="landing-content" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div style="max-width: 620px; width: 100%; text-align: center;">
        
        <!-- Badge -->
        <div class="intro-badge" style="display: inline-flex; margin-bottom: 20px;">
            <span class="badge-dot" style="background-color: #DD6B20;"></span>
            <span class="badge-text" style="color: #C05621;">Error 403 • Restricted Chamber</span>
        </div>

        <!-- Title -->
        <h1 class="hero-title" style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 2.75rem); line-height: 1.2; margin-bottom: 16px; color: var(--text-primary);">
            A Sealed <span class="highlight-wrapper">Chamber<span class="highlight-stroke"></span></span>
        </h1>

        <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 32px;">
            You do not possess the keys to enter this manuscript room. Please return to the public halls of Alfaaz.
        </p>

        <!-- Action CTAs -->
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 26px; border-radius: 9999px; font-weight: 600; font-size: 0.95rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Return to Sanctuary</span>
            </a>
        </div>

    </div>
</div>
@endsection
