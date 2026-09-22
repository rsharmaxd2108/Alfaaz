@extends('layouts.app')

@section('title', '404 — Lost in the Stanzas | Alfaaz')

@section('content')
<div class="landing-content" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div style="max-width: 620px; width: 100%; text-align: center;">
        
        <!-- Badge -->
        <div class="intro-badge" style="display: inline-flex; margin-bottom: 20px;">
            <span class="badge-dot" style="background-color: var(--brand-purple);"></span>
            <span class="badge-text">Error 404 • Page Not Found</span>
        </div>

        <!-- Title -->
        <h1 class="hero-title" style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 2.75rem); line-height: 1.2; margin-bottom: 16px; color: var(--text-primary);">
            Lost in the <span class="highlight-wrapper">Stanzas<span class="highlight-stroke"></span></span>
        </h1>

        <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 32px;">
            The page or couplet you were wandering towards seems to have faded like ink with time. Let us guide your steps back to the sanctuary.
        </p>

        <!-- Poetic Urdu Card -->
        <div style="background: #FFFFFF; border: 1px solid rgba(112, 82, 255, 0.12); border-radius: 20px; padding: 28px 24px; margin-bottom: 36px; box-shadow: 0 10px 30px rgba(112, 82, 255, 0.05); position: relative;">
            <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #F0EDFE; color: var(--brand-purple); font-size: 11px; font-weight: 600; padding: 3px 12px; border-radius: 9999px; letter-spacing: 0.5px; text-transform: uppercase;">
                Gumnam Alfaaz
            </div>
            
            <div style="font-family: 'Noto Nastaliq Urdu', serif; font-size: 1.45rem; line-height: 2.2; color: #1C1917; direction: rtl; margin-top: 6px; margin-bottom: 12px;">
                بھٹکتے پھرتے ہیں کچھ لفظ راستوں میں یوں<br>
                کہ جیسے ان کا کوئی ٹھکانہ نہ رہا ہو
            </div>
            
            <p style="font-size: 0.88rem; color: var(--text-muted); font-style: italic; margin: 0;">
                "Some words wander upon lost paths, as if they possess no home..."
            </p>
        </div>

        <!-- Action CTAs -->
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 26px; border-radius: 9999px; font-weight: 600; font-size: 0.95rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Return to Sanctuary</span>
            </a>
            <a href="{{ route('home') }}#explore" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 24px; border-radius: 9999px; font-weight: 600; font-size: 0.95rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <span>Explore Verses</span>
            </a>
        </div>

    </div>
</div>
@endsection
