<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Alfaaz — Words that feel into the heart')</title>
    <meta name="description" content="@yield('meta_description', 'Alfaaz is a sanctuary for Urdu and Hindi poetry, couplets, and timeless verses that feel into the heart. Discover, write, and share exquisite shayari.')">
    <meta name="keywords" content="Alfaaz, Shayari, Urdu Poetry, Hindi Poetry, Ghazal, Couplets, Sher, Rekhta, Dewaan">
    <meta name="author" content="Alfaaz">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#FCFAF6">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Alfaaz">

    <!-- Search Engine Indexing Directives -->
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Alfaaz">
    <meta property="og:title" content="@yield('og_title', 'Alfaaz — Words that feel into the heart')">
    <meta property="og:description" content="@yield('og_description', 'Alfaaz is a sanctuary for Urdu and Hindi poetry, couplets, and timeless verses that feel into the heart.')">
    <meta property="og:image" content="@yield('og_image', asset('images/hero-poet.jpg'))">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', 'Alfaaz — Words that feel into the heart')">
    <meta name="twitter:description" content="@yield('og_description', 'Alfaaz is a sanctuary for Urdu and Hindi poetry, couplets, and timeless verses that feel into the heart.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/hero-poet.jpg'))">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/sheaar.css') }}">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "WebSite",
                "@id": "{{ url('/') }}/#website",
                "url": "{{ url('/') }}",
                "name": "Alfaaz",
                "description": "Words that feel into the heart — A sanctuary for Urdu and Hindi poetry, couplets, and timeless verses.",
                "publisher": {
                    "@id": "{{ url('/') }}/#organization"
                },
                "inLanguage": ["en", "ur", "hi"]
            },
            {
                "@type": "Organization",
                "@id": "{{ url('/') }}/#organization",
                "name": "Alfaaz",
                "url": "{{ url('/') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('images/hero-poet.jpg') }}"
                },
                "slogan": "Words that feel into the heart"
            }
        ]
    }
    </script>
    @yield('extra_schema')
</head>
<body>
    <a href="#main-content" class="skip-to-content">Skip to content</a>
    @if(session('status'))
        <div id="statusToast" class="toast-notification show" role="status" aria-live="polite">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#68D391" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="ambient-glows-layer" aria-hidden="true">
        <div class="ambient-glow glow-top-left"></div>
        <div class="ambient-glow glow-hero-center"></div>
        <div class="ambient-glow glow-top-right"></div>
    </div>

    <div class="page-wrapper">
        <header class="site-header">
            <div class="header-inner">
                <a href="{{ route('home') }}" class="brand-logo">
                    <div class="brand-icon">
                        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="16" fill="url(#brandGrad)"/>
                            <path d="M22 10L17.5 14.5L14 18L13 22L17 21L20.5 17.5L25 13L22 10Z" fill="#FFFFFF" fill-opacity="0.95"/>
                            <path d="M14 18L11 21M13 22L10 25" stroke="#FFFFFF" stroke-width="1.2" stroke-linecap="round"/>
                            <circle cx="17" cy="17" r="1" fill="#7052FF"/>
                            <defs>
                                <linearGradient id="brandGrad" x1="4" y1="4" x2="28" y2="28" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7B6BF2"/>
                                    <stop offset="1" stop-color="#654CE6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="brand-name">Alfaaz</span>
                </a>

                <nav class="header-nav" id="mainHeaderNav">
                    <a href="{{ request()->routeIs('home') ? '#home' : route('home') . '#home' }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" data-nav="home">Home</a>
                    <a href="{{ request()->routeIs('home') ? '#explore' : route('home') . '#explore' }}" class="nav-link {{ request()->routeIs('explore') ? 'active' : '' }}" data-nav="explore">Explore</a>
                    <a href="{{ request()->routeIs('home') ? '#daily-verse' : route('home') . '#daily-verse' }}" class="nav-link {{ request()->routeIs('daily-verse*') ? 'active' : '' }}" data-nav="daily-verse">Daily Verse</a>
                </nav>

                <div class="header-actions">
                    @auth
                        @php
                            $user = Auth::user();
                            $name = $user->name ?? 'Poet';
                            $parts = preg_split('/\s+/', trim($name));
                            $initials = count($parts) >= 2 
                                ? strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1))
                                : strtoupper(mb_substr($name, 0, 2));
                            $avatarColor = $user->avatar_color ?? '#7052FF';
                        @endphp

                        <div class="user-menu-wrapper" id="userMenuWrapper">
                            <button type="button" class="user-avatar-btn" id="userAvatarBtn" aria-expanded="false" aria-haspopup="true" aria-label="Open user menu" style="background-color: {{ $avatarColor }}; overflow: hidden; padding: 0;">
                                @if(!empty($user->avatar_url))
                                    <img src="{{ $user->avatar_url }}" alt="{{ $name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    <span>{{ $initials }}</span>
                                @endif
                            </button>
                            
                            <div class="user-dropdown-menu" id="userDropdownMenu" role="menu" aria-hidden="true">
                                <div class="dropdown-header">
                                    <div class="dropdown-user-avatar" style="background-color: {{ $avatarColor }}; overflow: hidden; padding: 0;">
                                        @if(!empty($user->avatar_url))
                                            <img src="{{ $user->avatar_url }}" alt="{{ $name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        @else
                                            <span>{{ $initials }}</span>
                                        @endif
                                    </div>
                                    <div class="dropdown-user-info">
                                        <span class="dropdown-user-name">{{ $name }}</span>
                                        <span class="dropdown-user-email">{{ $user->email ?? 'poet@alfaaz.com' }}</span>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <div class="dropdown-items">
                                    <a href="{{ route('profile') }}" class="dropdown-item" role="menuitem">
                                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>Profile</span>
                                    </a>

                                    <a href="{{ route('dashboard') }}" class="dropdown-item" role="menuitem">
                                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                        <span>Poet's Desk</span>
                                    </a>

                                    <a href="{{ route('dashboard', ['tab' => 'bookmarks']) }}" class="dropdown-item" role="menuitem">
                                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        <span>Saved Couplets</span>
                                    </a>

                                    @if(Auth::user() && Auth::user()->isAdmin())
                                        <a href="{{ route('dashboard', ['tab' => 'desk', 'scope' => 'all']) }}" class="dropdown-item" role="menuitem" style="color: #DF7656;">
                                            <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            </svg>
                                            <span>Moderation Desk</span>
                                        </a>
                                    @endif
                                </div>

                                <div class="dropdown-divider"></div>

                                <form method="POST" action="{{ route('logout') }}" class="dropdown-logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn" role="menuitem">
                                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span>Log out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('write') }}" class="btn-header-write">
                            <svg class="write-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            <span>Write</span>
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="main-content" id="main-content">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @if(request()->routeIs('home'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = Array.from(document.querySelectorAll('.scroll-section'));
        const navLinks = document.querySelectorAll('#mainHeaderNav .nav-link');
        const footer = document.querySelector('.site-footer');
        let isThrottled = false;

        function updateActiveNav(activeId) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-nav') === activeId) {
                    link.classList.add('active');
                }
            });
        }

        function getCurrentSectionIndex() {
            const scrollPos = window.scrollY + 120;
            let idx = 0;
            sections.forEach((sec, i) => {
                if (scrollPos >= sec.offsetTop) {
                    idx = i;
                }
            });
            return idx;
        }

        function scrollToSection(idx) {
            if (idx >= 0 && idx < sections.length) {
                isThrottled = true;
                sections[idx].scrollIntoView({ behavior: 'smooth' });
                updateActiveNav(sections[idx].getAttribute('id'));
                setTimeout(() => { isThrottled = false; }, 750);
            } else if (idx >= sections.length && footer) {
                isThrottled = true;
                footer.scrollIntoView({ behavior: 'smooth' });
                setTimeout(() => { isThrottled = false; }, 750);
            }
        }

        // Wheel listener for one-by-one slide scroll
        window.addEventListener('wheel', function(e) {
            if (window.innerWidth <= 960) return; // Allow natural touch on small mobile screens
            if (Math.abs(e.deltaY) < 25) return;
            if (isThrottled) {
                e.preventDefault();
                return;
            }

            const currentIdx = getCurrentSectionIndex();
            const currentSec = sections[currentIdx];

            if (currentSec && currentSec.offsetHeight > window.innerHeight + 40) {
                const secTop = currentSec.offsetTop;
                const secBottom = secTop + currentSec.offsetHeight;
                const viewBottom = window.scrollY + window.innerHeight;

                if (e.deltaY > 0 && viewBottom < secBottom - 50) {
                    return; // Allow natural scrolling inside section
                } else if (e.deltaY < 0 && window.scrollY > secTop + 50) {
                    return; // Allow natural scrolling inside section
                }
            }

            if (e.deltaY > 0) {
                // Scroll down
                if (currentIdx < sections.length) {
                    e.preventDefault();
                    scrollToSection(currentIdx + 1);
                }
            } else if (e.deltaY < 0) {
                // Scroll up
                if (window.scrollY > 50) {
                    e.preventDefault();
                    scrollToSection(Math.max(0, currentIdx - 1));
                }
            }
        }, { passive: false });

        // Keyboard navigation (Arrow keys / Page keys)
        window.addEventListener('keydown', function(e) {
            if (['ArrowDown', 'PageDown'].includes(e.key)) {
                if (isThrottled) { e.preventDefault(); return; }
                const currentIdx = getCurrentSectionIndex();
                if (currentIdx < sections.length) {
                    e.preventDefault();
                    scrollToSection(currentIdx + 1);
                }
            } else if (['ArrowUp', 'PageUp'].includes(e.key)) {
                if (isThrottled) { e.preventDefault(); return; }
                const currentIdx = getCurrentSectionIndex();
                if (currentIdx > 0 || window.scrollY > 50) {
                    e.preventDefault();
                    scrollToSection(Math.max(0, currentIdx - 1));
                }
            }
        });

        // Scroll spy on manual drag
        window.addEventListener('scroll', function() {
            if (!isThrottled) {
                const currentIdx = getCurrentSectionIndex();
                if (sections[currentIdx]) {
                    updateActiveNav(sections[currentIdx].getAttribute('id'));
                }
            }
        }, { passive: true });
    });
    </script>
    @endif

    <script>
    // User profile dropdown toggle
    (function() {
        const userBtn = document.getElementById('userAvatarBtn');
        const dropdown = document.getElementById('userDropdownMenu');
        const wrapper = document.getElementById('userMenuWrapper');

        if (userBtn && dropdown) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isShown = dropdown.classList.toggle('show');
                userBtn.classList.toggle('active', isShown);
                userBtn.setAttribute('aria-expanded', isShown ? 'true' : 'false');
                dropdown.setAttribute('aria-hidden', isShown ? 'false' : 'true');
            });

            document.addEventListener('click', function(e) {
                if (wrapper && !wrapper.contains(e.target)) {
                    dropdown.classList.remove('show');
                    userBtn.classList.remove('active');
                    userBtn.setAttribute('aria-expanded', 'false');
                    dropdown.setAttribute('aria-hidden', 'true');
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    userBtn.classList.remove('active');
                    userBtn.setAttribute('aria-expanded', 'false');
                    dropdown.setAttribute('aria-hidden', 'true');
                    userBtn.focus();
                }
            });
        }

        // Auto-dismiss session status toast
        const toast = document.getElementById('statusToast');
        if (toast) {
            setTimeout(function() {
                toast.classList.remove('show');
            }, 3500);
        }

        // Global delegate for .btn-card-copy buttons
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-card-copy');
            if (!btn) return;
            e.preventDefault();

            const quote = btn.getAttribute('data-quote') || '';
            const author = btn.getAttribute('data-author') || '';
            const textToCopy = `"${quote}"\n— ${author}\nvia Alfaaz`;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    const originalHtml = btn.innerHTML;
                    btn.classList.add('copied');
                    btn.innerHTML = `
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span class="copy-label">Copied</span>
                    `;

                    setTimeout(() => {
                        btn.classList.remove('copied');
                        btn.innerHTML = originalHtml;
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy couplet: ', err);
                });
            }
        });
    })();
    </script>
</body>
</html>
