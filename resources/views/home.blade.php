@extends('layouts.app')

@section('title', 'Alfaaz — Words That Feel Into The Heart | Urdu & Hindi Shayari Anthology')
@section('meta_description', 'Immerse yourself in a curated sanctuary of timeless Urdu and Hindi shayari, daily couplets of love, sadness, and longing, and a quiet haven for poets and readers.')
@section('og_title', 'Alfaaz — Words That Feel Into The Heart')
@section('og_description', 'Discover timeless Urdu & Hindi couplets, daily rotating verses, and an intimate sanctuary for poetry lovers.')

@section('content')
<div class="landing-content">
    <section id="home" class="hero-section scroll-section">
        <div class="hero-left">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                <span class="badge-text">Shayari, kept in one place</span>
            </div>

            <h1 class="hero-title">
                Words that <span class="highlight-wrapper">feel<span class="highlight-stroke"></span></span> <br class="desktop-only-break">into the heart.
            </h1>

            <p class="hero-description hero-shayari-desc">
                &ldquo;Kuch rishte bas khamoshiyon mein dam tod dete hain, na koi shikayat hoti hai, na koi alvida.&rdquo;
            </p>

            <div class="hero-actions">
                <a href="#explore" class="btn btn-primary" style="text-decoration: none;">Explore Verses</a>
                <a href="#daily-verse" class="btn btn-secondary" style="text-decoration: none;">Today's Sher</a>
            </div>

            <div class="social-proof">
                <div class="avatar-chips">
                    <span class="chip-dot chip-peach"></span>
                    <span class="chip-dot chip-mint"></span>
                    <span class="chip-dot chip-lavender"></span>
                </div>
                <span class="proof-label">Hearted by readers, one verse at a time</span>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-visual-wrapper">
                <div class="floating-quote quote-top">
                    <p class="quote-verse">"{{ $heroVerses['top']['quote'] }}"</p>
                    <span class="quote-by">— {{ $heroVerses['top']['author'] }}</span>
                </div>

                <div class="illustration-frame">
                    <img src="{{ asset('images/hero-poet.jpg') }}" 
                         alt="Alfaaz illustration - poet writing shayari in quiet room with sleeping cat and chai" 
                         class="illustration-img">
                </div>

                <div class="floating-quote quote-bottom">
                    <p class="quote-verse">"{{ $heroVerses['bottom']['quote'] }}"</p>
                    <span class="quote-by">— {{ $heroVerses['bottom']['author'] }}</span>
                </div>
            </div>
        </div>
    </section>

    <section id="explore" class="page-explore scroll-section">
        <div class="page-intro-section">
            <div class="intro-badge">
                <span class="badge-dot" style="background-color: #7052FF;"></span>
                <span class="badge-text">Curated Anthology</span>
            </div>
            <h2 class="page-title">Explore <span class="highlight-wrapper">Shayari<span class="highlight-stroke"></span></span></h2>
            <p class="page-subtitle" style="margin-bottom: 32px;">Immerse yourself in verses of love, companionship, solitude, and hope from timeless masters and modern voices.</p>
        </div>

        <div class="explore-results-section">
            <div class="cards-grid" id="homeCardsGrid">
                @foreach($featuredShayaris as $shayari)
                    @php
                        $isLarge = ($shayari->card_size ?? null) === 'large' || in_array($loop->index, [0, 3]);
                        $words = preg_split('/\s+/', trim($shayari->author));
                        $authorInitials = count($words) >= 2 
                            ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1)) 
                            : strtoupper(mb_substr($shayari->author, 0, 2));
                    @endphp
                    <article class="shayari-card {{ $isLarge ? 'card-large' : 'card-small' }}" 
                             data-category="{{ $shayari->category_type }}"
                             data-language="{{ str_contains(strtolower($shayari->language), 'roman') ? 'roman-hindi' : 'english' }}"
                             data-author="{{ strtolower($shayari->author) }}"
                             data-quote="{{ strtolower($shayari->quote) }}">
                        <div class="card-tags">
                            <span class="tag-badge tag-{{ $shayari->category_type }}">
                                {{ $shayari->category }}
                            </span>
                            <span class="tag-badge tag-lang">{{ $shayari->language }}</span>
                        </div>

                        @if(!empty($shayari->title))
                            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 18px; font-weight: 700; color: #1C1917; margin: 12px 0 4px;">{{ $shayari->title }}</h3>
                        @endif

                        <p class="card-quote">&ldquo;{!! nl2br(e($shayari->quote)) !!}&rdquo;</p>

                        <div class="card-footer">
                            <div class="author-block">
                                <div class="author-circle" style="background-color: {{ $shayari->avatar_color }}">
                                    {{ $authorInitials }}
                                </div>
                                <div class="author-details">
                                    <span class="author-name">{{ $shayari->author }}</span>
                                </div>
                            </div>

                            <button type="button" class="btn-card-copy" data-quote="{{ $shayari->quote }}" data-author="{{ $shayari->author }}" title="Copy Couplet" aria-label="Copy couplet by {{ $shayari->author }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                <span class="copy-label">Copy</span>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="daily-verse" class="daily-feature-section scroll-section">
        <div class="page-intro-section" style="padding: 0 0 24px; width: 100%;">
            <div class="intro-badge" style="margin-bottom: 8px;">
                <span class="badge-dot" style="background-color: #DF7656;"></span>
                <span class="badge-text">Today's Reflection</span>
            </div>
            <h2 class="page-title" style="margin-bottom: 8px;">Daily <span class="highlight-wrapper">Verse<span class="highlight-stroke"></span></span></h2>
            <p class="page-subtitle" style="margin-bottom: 24px;">One couplet every morning to pause, reflect, and carry through your day.</p>
        </div>

        <div class="daily-hero-card">
            <div class="daily-card-header">
                <span class="daily-date-stamp">{{ $dailyVerse['date'] }}</span>
                <span class="tag-badge tag-umeed">{{ $dailyVerse['category'] }}</span>
            </div>

            <div class="daily-urdu-text" dir="rtl">
                {{ $dailyVerse['quote_urdu'] }}
            </div>

            <blockquote class="daily-roman-quote">
                &ldquo;{{ $dailyVerse['quote'] }}&rdquo;
            </blockquote>

            <div class="daily-translation-box">
                <span class="translation-label">Meaning in English:</span>
                <p class="translation-text">&ldquo;{{ $dailyVerse['english_translation'] }}&rdquo;</p>
            </div>

            @php
                $dWords = preg_split('/\s+/', trim($dailyVerse['author']));
                $dAuthorInitials = count($dWords) >= 2 
                    ? strtoupper(mb_substr($dWords[0], 0, 1) . mb_substr(end($dWords), 0, 1)) 
                    : strtoupper(mb_substr($dailyVerse['author'], 0, 2));
                $dAuthorColor = $dailyVerse['avatar_color'] ?? '#DF7656';
            @endphp
            <div class="daily-poet-section">
                <div class="author-circle" style="background-color: {{ $dAuthorColor }}; width: 44px; height: 44px; font-weight: 700; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px; border-radius: 50%;">
                    {{ $dAuthorInitials }}
                </div>
                <div class="daily-poet-details">
                    <h3 class="daily-poet-name">{{ $dailyVerse['author'] }}</h3>
                    <span class="daily-poet-era">{{ $dailyVerse['poet_era'] }}</span>
                </div>
            </div>

            <div class="daily-reflection-box">
                <h4 class="reflection-heading">Why this verse matters</h4>
                <p class="reflection-body">{{ $dailyVerse['reflection'] }}</p>
            </div>

            <div class="daily-actions-bar">
                <button type="button" class="btn-daily-action" data-copy-text="{{ $dailyVerse['quote'] }} — {{ $dailyVerse['author'] }}" onclick="navigator.clipboard.writeText(this.getAttribute('data-copy-text')); const s=this.querySelector('span'); if(s){s.innerText='Copied!'; setTimeout(()=>s.innerText='Copy Couplet', 2000)}" aria-label="Copy couplet to clipboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <span>Copy Couplet</span>
                </button>
            </div>
        </div>
    </section>
</div>
@endsection
