@extends('layouts.app')

@section('title', '500 — An Unexpected Silence | Alfaaz')

@section('content')
<div class="landing-content" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div style="max-width: 620px; width: 100%; text-align: center;">
        
        <!-- Badge -->
        <div class="intro-badge" style="display: inline-flex; margin-bottom: 20px;">
            <span class="badge-dot" style="background-color: #E53E3E;"></span>
            <span class="badge-text" style="color: #9B2C2C;">Error 500 • Server Interruption</span>
        </div>

        <!-- Title -->
        <h1 class="hero-title" style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 2.75rem); line-height: 1.2; margin-bottom: 16px; color: var(--text-primary);">
            An Unexpected <span class="highlight-wrapper">Silence<span class="highlight-stroke"></span></span>
        </h1>

        <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 32px;">
            Our quill paused unexpectedly while preparing these verses. Our scribes have noted the disturbance and will restore harmony shortly.
        </p>

        <!-- Poetic Urdu Card -->
        <div style="background: #FFFFFF; border: 1px solid rgba(229, 62, 62, 0.15); border-radius: 20px; padding: 28px 24px; margin-bottom: 36px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); position: relative;">
            <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #FFF5F5; color: #C53030; font-size: 11px; font-weight: 600; padding: 3px 12px; border-radius: 9999px; letter-spacing: 0.5px; text-transform: uppercase;">
                Khamooshi
            </div>
            
            <div style="font-family: 'Noto Nastaliq Urdu', serif; font-size: 1.45rem; line-height: 2.2; color: #1C1917; direction: rtl; margin-top: 6px; margin-bottom: 12px;">
                سازِ دل پر کوئی نغمہ نہ چھڑ سکا اب کے<br>
                تار ہی ٹوٹ گئے ساز سنبھالے نہ گئے
            </div>
            
            <p style="font-size: 0.88rem; color: var(--text-muted); font-style: italic; margin: 0;">
                "No song could rise upon the heart's strings this time; the chords broke before the melody could unfold..."
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
            <a href="javascript:window.location.reload();" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 24px; border-radius: 9999px; font-weight: 600; font-size: 0.95rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                </svg>
                <span>Refresh Page</span>
            </a>
        </div>

    </div>
</div>
@endsection
