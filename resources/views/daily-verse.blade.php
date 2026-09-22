@extends('layouts.app')

@section('title', 'Daily Verse — ' . ($dailyVerse['poet'] ?? 'Timeless Poet') . ' | Alfaaz')
@section('meta_description', 'Today’s Sher: "' . \Illuminate\Support\Str::limit(str_replace(["\r", "\n"], ' ', strip_tags($dailyVerse['quote'] ?? '')), 120) . '" — Pause, reflect, and discover the meaning and archive on Alfaaz.')
@section('og_title', 'Daily Verse by ' . ($dailyVerse['poet'] ?? 'Alfaaz') . ' — Alfaaz')
@section('og_description', \Illuminate\Support\Str::limit(str_replace(["\r", "\n"], ' ', strip_tags($dailyVerse['quote'] ?? '')), 140))

@section('extra_schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Quotation",
    "text": "{{ addslashes(str_replace(["\r", "\n"], ' ', strip_tags($dailyVerse['quote'] ?? ''))) }}",
    "creator": {
        "@type": "Person",
        "name": "{{ addslashes($dailyVerse['poet'] ?? 'Unknown Poet') }}"
    },
    "inLanguage": "ur"
}
</script>
@endsection

@section('content')
<div class="landing-content page-daily-verse">
    <section class="page-intro-section">
        <div class="intro-badge">
            <span class="badge-dot" style="background-color: #DF7656;"></span>
            <span class="badge-text">Today's Reflection</span>
        </div>
        <h1 class="page-title">Daily <span class="highlight-wrapper">Verse<span class="highlight-stroke"></span></span></h1>
        <p class="page-subtitle">One couplet every morning to pause, reflect, and carry through your day.</p>
    </section>

    <section class="daily-feature-section">
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
                $words = preg_split('/\s+/', trim($dailyVerse['author']));
                $authorInitials = count($words) >= 2 
                    ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1)) 
                    : strtoupper(mb_substr($dailyVerse['author'], 0, 2));
                $authorColor = $dailyVerse['avatar_color'] ?? '#DF7656';
            @endphp
            <div class="daily-poet-section">
                <div class="author-circle" style="background-color: {{ $authorColor }}; width: 44px; height: 44px; font-weight: 700; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px; border-radius: 50%;">
                    {{ $authorInitials }}
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
                <button type="button" class="btn-daily-action" id="btnCopyDailyVerse" data-quote="{{ $dailyVerse['quote'] }}" data-author="{{ $dailyVerse['author'] }}" aria-label="Copy couplet to clipboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <span id="copyBtnText">Copy Couplet</span>
                </button>
            </div>
        </div>
    </section>

    @if(!empty($archive) && (is_array($archive) ? count($archive) > 0 : $archive->isNotEmpty()))
    <section class="daily-archive-section">
        <div class="intro-badge" style="margin-bottom: 12px;">
            <span class="badge-dot" style="background-color: #7052FF;"></span>
            <span class="badge-text">Anthology Archive</span>
        </div>
        <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 22px; font-weight: 700; color: #1C1917; margin-bottom: 18px;">
            Recent Daily Verses
        </h2>
        <div class="archive-list">
            @foreach($archive as $archivedVerse)
                <article class="archive-item">
                    <span class="archive-date">{{ $archivedVerse['date'] }}</span>
                    <blockquote class="archive-quote">&ldquo;{{ $archivedVerse['quote'] }}&rdquo;</blockquote>
                    <div class="archive-meta">
                        <span class="archive-author">— {{ $archivedVerse['author'] }}</span>
                        <span class="tag-badge tag-umeed" style="font-size: 11px; padding: 4px 12px;">{{ $archivedVerse['category'] }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.getElementById('btnCopyDailyVerse');
    const copyText = document.getElementById('copyBtnText');
    if (copyBtn && copyText) {
        copyBtn.addEventListener('click', function() {
            const textToCopy = (copyBtn.dataset.quote || '') + ' — ' + (copyBtn.dataset.author || '');
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    copyText.textContent = 'Copied!';
                    setTimeout(() => { copyText.textContent = 'Copy Couplet'; }, 2000);
                });
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = textToCopy;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    copyText.textContent = 'Copied!';
                    setTimeout(() => { copyText.textContent = 'Copy Couplet'; }, 2000);
                } catch (err) {}
                document.body.removeChild(textArea);
            }
        });
    }
});
</script>
@endsection

