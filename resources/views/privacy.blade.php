@extends('layouts.app')

@section('title', 'Privacy Policy — Creative Trust & Data Protection | Alfaaz')
@section('meta_description', 'Our philosophy on honoring creative expression, protecting your personal data, and safeguarding author rights across Alfaaz.')
@section('og_title', 'Privacy Policy — Alfaaz')
@section('og_description', 'Learn how Alfaaz protects your creative writing and personal data.')

@section('content')
<div class="landing-content page-privacy">
    <div style="margin-bottom: 8px;">
        <a href="{{ route('home') }}" class="back-link">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Alfaaz</span>
        </a>
    </div>

    <section class="page-intro-section" style="padding-top: 12px;">
        <div class="intro-badge">
            <span class="badge-dot" style="background-color: var(--brand-purple);"></span>
            <span class="badge-text">Privacy & Creative Trust</span>
        </div>
        <h1 class="page-title">Privacy <span class="highlight-wrapper">Policy<span class="highlight-stroke"></span></span></h1>
        <p class="page-subtitle">We believe in honoring your creative expression and fiercely protecting your personal privacy. Here is a clear, transparent explanation of how we treat your data.</p>
    </section>

    <div class="privacy-container">
        <article class="privacy-card">
            <div class="privacy-meta-bar">
                <div class="privacy-meta-date">
                    <span>Effective Date: <strong>September 2026</strong></span>
                </div>
            </div>

            <section id="overview" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">1</span>
                    <h2 class="privacy-section-title">Overview & Philosophy</h2>
                </div>
                <p class="privacy-p">
                    At <strong>Alfaaz (Dewaan-e-Alfaaz)</strong>, we cultivate a sacred digital sanctuary for poets, writers, and literature enthusiasts. Words carry heart, vulnerability, and history. We consider the trust you place in our platform to be invaluable.
                </p>
                <p class="privacy-p">
                    Our commitment is simple: <strong>we do not sell, rent, or trade your personal information</strong> to third parties or advertising brokers. We do not engage in invasive behavioral surveillance, cross-site behavioral tracking, or data monetization.
                </p>
                <div class="privacy-callout-box">
                    <p>
                        <strong>Our Core Promise:</strong> Alfaaz exists solely to celebrate the art of poetry and give writers a peaceful desk to write, curate, and share their verses. Your words remain yours.
                    </p>
                </div>
            </section>

            <section id="info-collect" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">2</span>
                    <h2 class="privacy-section-title">Information We Collect</h2>
                </div>
                <p class="privacy-p">
                    We collect only the minimal amount of information required to deliver a seamless writing and reading experience:
                </p>
                <ul class="privacy-list">
                    <li>
                        <strong>Account Information:</strong> When you register directly, we collect your name, pen name (takhallus), email address, and a securely salted and hashed password. If you add bio details or a profile photo, we store those as part of your public poet profile.
                    </li>
                    <li>
                        <strong>Poetry & Couplets:</strong> Verses, titles, categories, tags, and languages that you compose. Verses saved to "My Desk" as drafts remain strictly private to you. Verses you publish become part of the curated public anthology.
                    </li>
                    <li>
                        <strong>Reader Interactions:</strong> Couplets you bookmark to your "Saved Couplets" collection, and verses you like on the Sunday Anthology feed.
                    </li>
                    <li>
                        <strong>Technical & Operational Logs:</strong> For security and brute-force prevention, our servers record standard HTTP request data including IP addresses, browser user agent strings, and timestamps.
                    </li>
                </ul>
            </section>

            <section id="how-we-use" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">3</span>
                    <h2 class="privacy-section-title">How We Use Your Information</h2>
                </div>
                <p class="privacy-p">
                    The data we gather is used strictly for legitimate platform purposes:
                </p>
                <ul class="privacy-list">
                    <li>To render your personal workspace, desk drafts, published verses, and saved anthology bookmarks.</li>
                    <li>To authenticate your session securely and verify that only you can edit or remove your written work.</li>
                    <li>To deliver requested transactional emails, such as password reset notifications and critical security notices.</li>
                    <li>To enforce platform safety, prevent automated spam attacks, and protect poets from harassment or intellectual property violations.</li>
                </ul>
            </section>

            <section id="google-auth" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">4</span>
                    <h2 class="privacy-section-title">Google OAuth & Third-Party Sign-In</h2>
                </div>
                <p class="privacy-p">
                    Alfaaz allows you to create an account or sign in conveniently using <strong>Google OAuth 2.0</strong>.
                </p>
                <p class="privacy-p">
                    When you authenticate through Google, we request access only to your basic public profile information: your name, verified email address, Google unique account identifier, and profile picture avatar.
                </p>
                <ul class="privacy-list">
                    <li><strong>No Additional Access:</strong> We never request, access, or store your Google Drive files, Gmail messages, contact lists, calendar events, or any other private Google data.</li>
                    <li><strong>Revoking Access:</strong> You can disconnect Alfaaz from your Google account at any time by visiting your <a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener noreferrer" style="color: var(--brand-purple); font-weight: 600;">Google Account Permissions</a>.</li>
                </ul>
            </section>

            <section id="cookies" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">5</span>
                    <h2 class="privacy-section-title">Cookies & Local Storage</h2>
                </div>
                <p class="privacy-p">
                    Alfaaz uses only essential, functional cookies to maintain your login session and protect against malicious cross-site attacks:
                </p>
                <ul class="privacy-list">
                    <li><strong><code>alfaaz_session</code>:</strong> An encrypted, HTTP-only session identifier that keeps you authenticated while navigating between pages.</li>
                    <li><strong><code>XSRF-TOKEN</code>:</strong> A cryptographic security cookie used to protect your forms and API requests against Cross-Site Request Forgery (CSRF) attacks.</li>
                </ul>
                <p class="privacy-p">
                    We <strong>do not</strong> use third-party advertising cookies, ad tracking networks, or commercial analytics scripts that follow you across the internet.
                </p>
            </section>

            <section id="content-ownership" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">6</span>
                    <h2 class="privacy-section-title">Copyright & Content Ownership</h2>
                </div>
                <p class="privacy-p">
                    <strong>You retain 100% intellectual property ownership and copyright</strong> over every couplet, poem, and literary piece you compose and submit on Alfaaz.
                </p>
                <p class="privacy-p">
                    By publishing a couplet on the public anthology feed, you grant Alfaaz a non-exclusive, royalty-free license to display your verse to fellow readers with proper attribution to your poet name or pen name. You have the right to edit, unpublish, or permanently delete your verses from your desk at any time.
                </p>
            </section>

            <section id="security" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">7</span>
                    <h2 class="privacy-section-title">Data Protection & Security</h2>
                </div>
                <p class="privacy-p">
                    We employ robust, modern security engineering practices to safeguard your profile and writings:
                </p>
                <ul class="privacy-list">
                    <li><strong>Bcrypt Password Hashing:</strong> Passwords are cryptographically salted and hashed using industry-standard Bcrypt. We cannot see or recover plaintext passwords.</li>
                    <li><strong>Transport Security:</strong> All data transmitted between your browser and our servers is encrypted using modern TLS (HTTPS) with Strict Transport Security (HSTS).</li>
                    <li><strong>Defense-in-Depth Headers:</strong> Comprehensive security headers including strict Content Security Policies (CSP), Frame Options protection against clickjacking, and Permissions Policies.</li>
                    <li><strong>Intelligent Rate Limiting:</strong> Automated defenses against brute-force password guessing and link flooding.</li>
                </ul>
            </section>

            <section id="your-rights" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">8</span>
                    <h2 class="privacy-section-title">Your Rights & Privacy Choices</h2>
                </div>
                <p class="privacy-p">
                    Regardless of where you reside, Alfaaz respects your digital autonomy and gives you complete control:
                </p>
                <ul class="privacy-list">
                    <li><strong>Access & Modification:</strong> You can review and edit your personal details, pen name, email, and profile avatar directly in your <a href="{{ route('profile') }}" style="color: var(--brand-purple); font-weight: 600;">Profile Settings</a>.</li>
                    <li><strong>Content Deletion:</strong> You can delete individual couplets directly from "My Desk" at any moment.</li>
                    <li><strong>Account Erasure:</strong> If you wish to permanently delete your Alfaaz account, all associated verses, and bookmarks, contact our privacy officer, and your data will be permanently wiped from our production databases.</li>
                </ul>
            </section>

            <section id="contact" class="privacy-section">
                <div class="privacy-section-header">
                    <span class="privacy-section-num">9</span>
                    <h2 class="privacy-section-title">Contact & Privacy Inquiries</h2>
                </div>
                <p class="privacy-p">
                    If you have questions, feedback, or concerns regarding our privacy practices, or if you would like to exercise your data rights, our team is always ready to help:
                </p>
                <div class="privacy-contact-card">
                    <div>
                        <strong style="color: var(--text-primary); display: block; font-size: 15px; margin-bottom: 4px;">Alfaaz Editorial & Privacy Team</strong>
                        <span style="color: var(--text-muted); font-size: 13.5px;">Dewaan-e-Alfaaz — Words that feel into the heart</span>
                    </div>
                    <a href="mailto:privacy@alfaaz.com" class="privacy-contact-email">
                        privacy@alfaaz.com
                    </a>
                </div>
            </section>
        </article>
    </div>
</div>
@endsection
