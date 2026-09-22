@extends('layouts.app')

@section('content')
<div class="landing-content page-poets">
    <section class="page-intro-section">
        <div class="intro-badge">
            <span class="badge-dot"></span>
            <span class="badge-text">Asaatiza &bull; Masters & Voices</span>
        </div>
        <h1 class="page-title">The <span class="highlight-wrapper">Poets<span class="highlight-stroke"></span></span> & Voices</h1>
        <p class="page-subtitle">From the grand halls of classical ghazal to the quiet corners of modern thought, meet the writers whose words echo in our memories.</p>
    </section>

    <section class="poets-grid-section">
        <div class="poet-cards-grid">
            @foreach($poets as $poet)
                <article class="poet-card">
                    <div class="poet-card-top">
                        <div class="poet-avatar" style="background-color: {{ $poet->avatar_color }}">
                            <span>{{ $poet->avatar_initials }}</span>
                        </div>
                        <div class="poet-identity">
                            <h3 class="poet-name">{{ $poet->name }}</h3>
                            <span class="poet-era">{{ $poet->era }}</span>
                        </div>
                        <span class="poet-verse-badge">{{ $poet->shayari_count }} couplets</span>
                    </div>

                    <p class="poet-bio">{{ $poet->bio }}</p>

                    <div class="poet-signature-sher">
                        <div class="signature-tag">Signature Verse</div>
                        <blockquote class="signature-quote">&ldquo;{{ $poet->signature_sher }}&rdquo;</blockquote>
                    </div>

                    <div class="poet-card-footer">
                        <a href="{{ route('explore', ['q' => $poet->name]) }}" class="btn-poet-verses">
                            <span>Read {{ explode(' ', $poet->name)[0] }}'s verses</span>
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 10h12M11 5l5 5-5 5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>
@endsection
