<footer class="site-footer footer-minimal">
    <div class="footer-inner">
        <div class="footer-bar">
            <div class="footer-brand-side">
                <a href="{{ request()->routeIs('home') ? '#home' : route('home') }}" class="footer-brand">
                    <div class="brand-icon">
                        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="16" fill="url(#footerBrandGrad)"/>
                            <path d="M22 10L17.5 14.5L14 18L13 22L17 21L20.5 17.5L25 13L22 10Z" fill="#FFFFFF" fill-opacity="0.95"/>
                            <path d="M14 18L11 21M13 22L10 25" stroke="#FFFFFF" stroke-width="1.2" stroke-linecap="round"/>
                            <circle cx="17" cy="17" r="1" fill="#7052FF"/>
                            <defs>
                                <linearGradient id="footerBrandGrad" x1="4" y1="4" x2="28" y2="28" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7B6BF2"/>
                                    <stop offset="1" stop-color="#654CE6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="brand-name">Alfaaz</span>
                </a>
                <span class="footer-separator">•</span>
                <span class="footer-submotto">Words that feel into the heart.</span>
            </div>

            <nav class="footer-nav" aria-label="Footer Navigation">
                <a href="{{ request()->routeIs('home') ? '#explore' : route('home') . '#explore' }}" class="footer-nav-link">Explore</a>
                <span class="nav-dot">•</span>
                <a href="{{ request()->routeIs('home') ? '#daily-verse' : route('home') . '#daily-verse' }}" class="footer-nav-link">Daily Verse</a>
                <span class="nav-dot">•</span>
                <a href="{{ route('privacy') }}" class="footer-nav-link {{ request()->routeIs('privacy') ? 'active' : '' }}">Privacy</a>
            </nav>

            <div class="footer-right-side">
                <div class="footer-socials-inline">
                    <a href="javascript:void(0)" class="social-icon-btn" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></path>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon-btn" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                        </svg>
                    </a>
                </div>
                <span class="footer-copy">&copy; {{ date('Y') }} Alfaaz</span>
            </div>
        </div>
    </div>
</footer>
