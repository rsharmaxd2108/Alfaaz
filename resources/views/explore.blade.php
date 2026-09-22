@extends('layouts.app')

@section('title', 'Explore Shayari — Curated Urdu & Hindi Couplets | Alfaaz')
@section('meta_description', 'Explore handcrafted stanzas and couplets of Ishq (Love), Dosti (Companionship), and Umeed (Hope) by classical masters and contemporary poets in an exquisite masonry feed.')
@section('og_title', 'Explore Curated Shayari — Alfaaz')
@section('og_description', 'Discover verses of love, companionship, solitude, and heartbreak in an elegant masonry anthology on Alfaaz.')

@section('content')
<div class="landing-content page-explore">
    <section class="page-intro-section">
        <div class="intro-badge">
            <span class="badge-dot"></span>
            <span class="badge-text">Curated Anthology</span>
        </div>
        <h1 class="page-title">Explore <span class="highlight-wrapper">Shayari<span class="highlight-stroke"></span></span></h1>
        <p class="page-subtitle" style="margin-bottom: 32px;">Immerse yourself in verses of love, companionship, solitude, and hope from timeless masters and modern voices.</p>
    </section>

    <section class="explore-results-section">

        @if($shayaris->isEmpty())
            <div class="empty-state-box">
                <div class="empty-icon">🍂</div>
                <h3 class="empty-title">No verses found</h3>
                <p class="empty-desc">We couldn't find any couplets matching your current filters. Try changing your search query or selecting "All Categories".</p>
                <a href="{{ route('explore') }}" class="btn btn-primary btn-reset">View All Verses</a>
            </div>
        @else
            <div class="cards-grid">
                @foreach($shayaris as $shayari)
                    @php
                        $isLarge = ($shayari->card_size ?? null) === 'large' || in_array($loop->index, [0, 3]);
                        $words = preg_split('/\s+/', trim($shayari->author));
                        $authorInitials = count($words) >= 2 
                            ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1)) 
                            : strtoupper(mb_substr($shayari->author, 0, 2));
                    @endphp
                    <article class="shayari-card {{ $isLarge ? 'card-large' : 'card-small' }}">
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
        @endif
    </section>
</div>
@endsection
