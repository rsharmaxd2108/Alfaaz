<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alfaaz — The Sunday Anthology & Poet’s Desk</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#12111A">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #FAF7F2;
            color: #1C1917;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a, button, [role="button"] {
            cursor: pointer;
        }

        /* User Dropdown Menu from Rail */
        .rail-avatar-wrapper {
            position: relative;
        }

        .rail-dropdown-menu {
            position: absolute;
            bottom: 10px;
            left: 56px;
            background: #FFFFFF;
            border: 1px solid #EBE4DA;
            border-radius: 16px;
            width: 220px;
            padding: 8px;
            box-shadow: 0 16px 40px rgba(44, 38, 30, 0.12);
            opacity: 0;
            pointer-events: none;
            transform: scale(0.95) translateY(10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .rail-dropdown-menu.active {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1) translateY(0);
        }

        @media (max-width: 768px) {
            .rail-dropdown-menu {
                top: 52px;
                bottom: auto;
                left: auto;
                right: 0;
                transform: scale(0.95) translateY(-6px);
            }
            .rail-dropdown-menu.active {
                transform: scale(1) translateY(0);
            }
        }

        .rail-dropdown-header {
            padding: 10px 12px;
            border-bottom: 1px solid #F5EFE6;
            margin-bottom: 4px;
        }

        .rail-dropdown-user-name {
            font-weight: 700;
            font-size: 13px;
            color: #1A1714;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rail-dropdown-user-email {
            font-size: 11px;
            color: #8C847A;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rail-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            color: #4A4239;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.15s ease, color 0.15s ease;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .rail-dropdown-item:hover {
            background-color: #F8F5F0;
            color: #1A1714;
        }

        /* Toast notifications */
        .toast-notification {
            position: fixed;
            top: 24px;
            right: 24px;
            background: #1B1815;
            color: #FFFFFF;
            padding: 12px 22px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 2000;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.25s ease;
            pointer-events: none;
        }

        .toast-notification.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
    </style>
</head>
<body>

    @if(session('status'))
        <div id="statusToast" class="toast-notification show">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#68D391" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @else
        <div id="statusToast" class="toast-notification">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#68D391" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span id="toastMessage">Success</span>
        </div>
    @endif

    <div class="dashboard-viewport">

        <aside class="dashboard-icon-rail">
            <a href="{{ route('home') }}" class="rail-brand-logo" title="Alfaaz Home">
                <span class="rail-brand-icon">A</span>
                <span class="rail-brand-text">Alfaaz</span>
            </a>

            <nav class="rail-nav-group">
                <a href="{{ route('dashboard', ['tab' => 'writing']) }}" 
                   class="rail-nav-item {{ in_array($activeTab, ['writing', '']) ? 'active' : '' }}" 
                   title="Feed" 
                   data-tooltip="Feed">
                    <svg class="nav-3d-icon nav-3d-feed" viewBox="0 0 32 32" width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <filter id="rail_feedShadow" x="-20%" y="-20%" width="140%" height="150%">
                                <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="#DF7656" flood-opacity="0.32" />
                            </filter>
                            <linearGradient id="rail_feedBack" x1="6" y1="8" x2="22" y2="26" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#EEDFD0"/>
                                <stop offset="1" stop-color="#D5C2AF"/>
                            </linearGradient>
                            <linearGradient id="rail_feedFront" x1="4" y1="5" x2="26" y2="27" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#2D2520"/>
                                <stop offset="0.6" stop-color="#1E1916"/>
                                <stop offset="1" stop-color="#120F0D"/>
                            </linearGradient>
                            <linearGradient id="rail_feedSheen" x1="6" y1="6" x2="24" y2="6" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FFFFFF" stop-opacity="0.5"/>
                                <stop offset="0.5" stop-color="#FFD6C9" stop-opacity="0.8"/>
                                <stop offset="1" stop-color="#FFFFFF" stop-opacity="0.2"/>
                            </linearGradient>
                            <linearGradient id="rail_feedQuill" x1="16" y1="3" x2="28" y2="18" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FFA885"/>
                                <stop offset="0.5" stop-color="#DF7656"/>
                                <stop offset="1" stop-color="#B84928"/>
                            </linearGradient>
                        </defs>
                        <rect x="7.5" y="8" width="17" height="19" rx="3.5" transform="rotate(7 16 17.5)" fill="url(#rail_feedBack)" stroke="#C8B39E" stroke-width="0.75" />
                        <g filter="url(#rail_feedShadow)">
                            <rect x="5.5" y="6" width="18" height="21" rx="4" transform="rotate(-3 14.5 16.5)" fill="url(#rail_feedFront)" stroke="#4A3F37" stroke-width="0.8" />
                            <path d="M7 7.5 L21.5 6.7" stroke="url(#rail_feedSheen)" stroke-width="1.2" stroke-linecap="round" />
                            <line x1="8.5" y1="12" x2="18" y2="11.5" stroke="#DF7656" stroke-width="1.6" stroke-linecap="round" stroke-opacity="0.9" />
                            <line x1="8.5" y1="15.5" x2="20" y2="14.8" stroke="#E5DDD3" stroke-width="1.4" stroke-linecap="round" stroke-opacity="0.65" />
                            <line x1="8.5" y1="19" x2="15.5" y2="18.5" stroke="#E5DDD3" stroke-width="1.4" stroke-linecap="round" stroke-opacity="0.45" />
                        </g>
                        <g transform="translate(14, 2)">
                            <path d="M6 1 L11 7 L7.5 13 L5 9.5 L6 1Z" fill="url(#rail_feedQuill)" stroke="#FFE2D4" stroke-width="0.6"/>
                            <circle cx="7" cy="8" r="1" fill="#FFF2EC"/>
                            <line x1="7" y1="8" x2="11" y2="7" stroke="#681C08" stroke-width="0.5"/>
                            <circle cx="11.5" cy="6.5" r="1" fill="#FFD078"/>
                        </g>
                    </svg>
                </a>

                <button type="button" class="rail-compose-btn" onclick="openComposerModal()" title="Compose Couplet (+)" data-tooltip="Write (+)" aria-label="Compose new couplet">
                    +
                </button>

                <a href="{{ route('dashboard', ['tab' => 'desk']) }}" 
                   class="rail-nav-item {{ $activeTab === 'desk' ? 'active' : '' }}" 
                   title="My Poet's Desk"
                   data-tooltip="My Desk ({{ $publishedCount + $draftsCount }})">
                    <svg class="nav-3d-icon nav-3d-desk" viewBox="0 0 32 32" width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <filter id="rail_deskShadow" x="-20%" y="-20%" width="140%" height="150%">
                                <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="#7052FF" flood-opacity="0.32" />
                            </filter>
                            <linearGradient id="rail_deskCover" x1="4" y1="4" x2="28" y2="28" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#8E72FF"/>
                                <stop offset="0.4" stop-color="#7052FF"/>
                                <stop offset="1" stop-color="#4C2FE0"/>
                            </linearGradient>
                            <linearGradient id="rail_deskSpine" x1="4" y1="5" x2="9" y2="5" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#3A1FB8"/>
                                <stop offset="0.5" stop-color="#5539D9"/>
                                <stop offset="1" stop-color="#7052FF"/>
                            </linearGradient>
                            <linearGradient id="rail_deskPages" x1="22" y1="7" x2="27" y2="25" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FAF5EE"/>
                                <stop offset="0.5" stop-color="#EADBCA"/>
                                <stop offset="1" stop-color="#D1C0AA"/>
                            </linearGradient>
                            <linearGradient id="rail_deskRibbon" x1="14" y1="4" x2="18" y2="24" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FFA885"/>
                                <stop offset="0.7" stop-color="#DF7656"/>
                                <stop offset="1" stop-color="#C24E2B"/>
                            </linearGradient>
                        </defs>
                        <path d="M8 8 L24 6 C25 6 26 7 26 8 L26 23 C26 24 25 25 24 25 L8 26 Z" fill="url(#rail_deskPages)" />
                        <line x1="24.5" y1="8" x2="24.5" y2="23.5" stroke="#C4B29C" stroke-width="0.75" />
                        <line x1="23" y1="8.5" x2="23" y2="24" stroke="#D8C8B4" stroke-width="0.75" />
                        <g filter="url(#rail_deskShadow)">
                            <rect x="5" y="5" width="18.5" height="22" rx="3.5" fill="url(#rail_deskCover)" stroke="rgba(255,255,255,0.25)" stroke-width="0.8" />
                            <path d="M5 8.5 C5 6.5 6 5 8 5 L9.5 5 L9.5 27 L8 27 C6 27 5 25.5 5 23.5 Z" fill="url(#rail_deskSpine)" />
                            <line x1="9.5" y1="5" x2="9.5" y2="27" stroke="rgba(255,255,255,0.25)" stroke-width="0.75" />
                            <circle cx="15.5" cy="14" r="3.2" stroke="#FFD8B5" stroke-width="0.9" fill="rgba(0,0,0,0.15)"/>
                            <path d="M15.5 12 L17 14 L15.5 15.5 L14.5 14 Z" fill="#FFD8B5" />
                        </g>
                        <path d="M14 4 L17 4 L17 19 L15.5 17.5 L14 19 Z" fill="url(#rail_deskRibbon)" stroke="rgba(255,255,255,0.4)" stroke-width="0.5" />
                    </svg>
                </a>
            </nav>

            <div class="rail-bottom">
                @php
                    $uName = $user->name ?? 'Poet';
                    $parts = preg_split('/\s+/', trim($uName));
                    $initials = count($parts) >= 2 
                        ? strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1))
                        : strtoupper(mb_substr($uName, 0, 2));
                    $avatarColor = $user->avatar_color ?? '#7052FF';
                @endphp

                <div class="rail-avatar-wrapper" id="railAvatarWrapper">
                    <button type="button" class="rail-avatar-btn" id="railAvatarBtn" style="background-color: {{ $avatarColor }}; overflow: hidden; padding: 0;" aria-haspopup="true" aria-expanded="false" title="{{ $uName }}">
                        @if(!empty($user->avatar_url))
                            <img src="{{ $user->avatar_url }}" alt="{{ $uName }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            {{ $initials }}
                        @endif
                    </button>

                    <div class="rail-dropdown-menu" id="railDropdownMenu" role="menu">
                        <div class="rail-dropdown-header">
                            <div class="rail-dropdown-user-name">
                                {{ $uName }}
                                @if($user->isAdmin())
                                    <span style="display: inline-block; background: #DF7656; color: #FFFFFF; font-size: 9px; font-weight: 800; padding: 1px 6px; border-radius: 4px; vertical-align: middle; margin-left: 4px; letter-spacing: 0.06em;">ADMIN</span>
                                @endif
                            </div>
                            <div class="rail-dropdown-user-email">{{ $user->email }}</div>
                        </div>

                        <a href="{{ route('profile') }}" class="rail-dropdown-item" role="menuitem">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Poet’s Profile</span>
                        </a>

                        <a href="{{ route('dashboard', ['tab' => 'bookmarks']) }}" class="rail-dropdown-item {{ $activeTab === 'bookmarks' ? 'active' : '' }}" role="menuitem">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="{{ $activeTab === 'bookmarks' ? '#DF7656' : 'none' }}" stroke="{{ $activeTab === 'bookmarks' ? '#DF7656' : 'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Saved Couplets</span>
                            @if(!empty($bookmarksCount) && $bookmarksCount > 0)
                                <span style="margin-left: auto; font-size: 10.5px; font-weight: 700; background: #FAF0E8; color: #DF7656; padding: 1px 7px; border-radius: 9999px;">{{ $bookmarksCount }}</span>
                            @endif
                        </a>

                        @if($user->isAdmin())
                            <a href="{{ route('dashboard', ['tab' => 'desk', 'scope' => 'all']) }}" class="rail-dropdown-item" role="menuitem" style="color: #DF7656;">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Moderation Desk</span>
                            </a>
                        @endif

                        <div style="border-top: 1px solid #F5EFE6; margin: 4px 0;"></div>

                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="rail-dropdown-item" style="color: #C53030;" role="menuitem">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>Log out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <main class="dashboard-main-stage">

            <div class="dashboard-feed-column">

                <header class="anthology-masthead">
                    @if($activeTab === 'desk' && $scope === 'all')
                        <div class="edition-label" style="color: #DF7656;">
                            <span class="edition-dot" style="background: #DF7656;"></span>
                            <span>ADMIN CONSOLE</span>
                            <span class="edition-sep">•</span>
                            <span class="edition-sub">MODERATION DESK</span>
                        </div>
                        <div class="masthead-row">
                            <div>
                                <h1 class="anthology-title">Moderation Desk.</h1>
                                <p class="anthology-subtitle">
                                    Review, manage, and moderate couplets submitted across the platform.
                                </p>
                            </div>
                    @elseif($activeTab === 'desk')
                        <div class="edition-label desk-edition-label">
                            <span class="edition-dot desk-dot"></span>
                            <span>POET’S STUDIO & WORKSPACE</span>
                            <span class="edition-sep">•</span>
                            <span class="edition-sub">MY DESK</span>
                        </div>
                        <div class="masthead-row">
                            <div>
                                <h1 class="anthology-title">{{ $user->pen_name ?: $user->name }}’s Desk.</h1>
                                <p class="anthology-subtitle">
                                    Your personal sanctuary of drafts, published couplets, and reflections.
                                </p>
                            </div>
                    @elseif($activeTab === 'bookmarks')
                        <div class="edition-label" style="color: #7052FF;">
                            <span class="edition-dot" style="background: #7052FF;"></span>
                            <span>PERSONAL ANTHOLOGY</span>
                            <span class="edition-sep">•</span>
                            <span class="edition-sub">SAVED COUPLETS</span>
                        </div>
                        <div class="masthead-row">
                            <div>
                                <h1 class="anthology-title">Saved Couplets.</h1>
                                <p class="anthology-subtitle">
                                    Verses and reflections you have treasured from the Feed.
                                </p>
                            </div>
                    @else
                        <div class="edition-label">
                            <span class="edition-dot"></span>
                            <span>COMMUNITY DIWAN</span>
                            <span class="edition-sep">•</span>
                            <span class="edition-sub">LATEST VERSES</span>
                        </div>
                        <div class="masthead-row">
                            <div>
                                <h1 class="anthology-title">Diwan-e-Alfaaz.</h1>
                                <p class="anthology-subtitle">
                                    Where quiet hearts speak in timeless rhyme.
                                </p>
                            </div>
                    @endif

                        <div class="masthead-actions">
                            <form action="{{ route('dashboard') }}" method="GET" class="inline-search-form">
                                <input type="hidden" name="tab" value="{{ $activeTab }}">
                                <svg class="inline-search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Search shayari" class="inline-search-input">
                            </form>
                        </div>
                    </div>
                </header>

                @if($activeTab === 'desk')
                    @if($scope === 'all')
                        <div style="margin-bottom: 14px;">
                            <a href="{{ route('dashboard', ['tab' => 'desk']) }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #70685E; text-decoration: none; padding: 6px 12px; background: #EFEBE4; border-radius: 8px; transition: all 0.15s ease;">
                                ← Back to My Desk
                            </a>
                        </div>
                    @endif

                    <div class="my-desk-header-stats">
                        <div class="stat-metric-card">
                            <div class="metric-label">{{ $scope === 'all' ? 'Total Works' : 'Published Couplets' }}</div>
                            <div class="metric-value">{{ $scope === 'all' ? $allPlatformCount : $publishedCount }}</div>
                        </div>
                        <div class="stat-metric-card">
                            <div class="metric-label">{{ $scope === 'all' ? 'My Drafts' : 'Drafts in Studio' }}</div>
                            <div class="metric-value">{{ $draftsCount }}</div>
                        </div>
                        <div class="stat-metric-card">
                            <div class="metric-label">Appreciations Received</div>
                            <div class="metric-value">{{ $totalLikes }}</div>
                        </div>
                    </div>

                    @if($userShayaris->isEmpty())
                        <div class="editorial-featured-card" style="text-align: center; padding: 48px 32px;">
                            <div style="font-size: 38px; margin-bottom: 16px;">✍️</div>
                            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 22px; margin-bottom: 8px;">
                                {{ $scope === 'all' ? 'No couplets on the platform yet' : 'Your desk is waiting for its first couplet' }}
                            </h3>
                            <p style="color: #786F64; font-size: 14px; max-width: 420px; margin: 0 auto 24px;">
                                {{ $scope === 'all' ? 'No poets have posted yet. As admin, you can pen the inaugural couplet or invite poets.' : 'Pen your reflections in Hindi, Urdu, or English. You can save as private drafts or publish to the community feed.' }}
                            </p>
                            <button type="button" class="btn-modal-publish" onclick="openComposerModal()">Pen New Couplet</button>
                        </div>
                    @else
                        @foreach($userShayaris as $myShayari)
                            <div class="desk-couplet-card">
                                <div class="desk-card-header">
                                    <div class="desk-header-meta">
                                        <span class="desk-card-status {{ $myShayari->status === 'published' ? 'status-published' : 'status-draft' }}">
                                            ● {{ ucfirst($myShayari->status) }}
                                        </span>
                                        <span class="desk-card-date">{{ $myShayari->created_at ? $myShayari->created_at->format('M d, Y') : 'Recently' }}</span>
                                    </div>

                                    <div class="desk-actions">
                                        <form method="POST" action="{{ route('couplets.toggle-status', $myShayari->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-desk-action">
                                                <span class="action-text-full">{{ $myShayari->status === 'published' ? 'Move to Drafts' : 'Publish' }}</span>
                                                <span class="action-text-short">{{ $myShayari->status === 'published' ? 'Draft' : 'Publish' }}</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('couplets.destroy', $myShayari->id) }}" onsubmit="return confirm('Are you sure you want to delete this couplet?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-desk-action btn-desk-delete" title="Delete couplet">
                                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($user->isAdmin() && $scope === 'all')
                                    <div class="desk-moderation-author">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>Poet: <strong class="desk-author-name">{{ $myShayari->author_name ?: ($myShayari->user->name ?? 'Poet') }}</strong></span>
                                        <span class="desk-author-email">({{ $myShayari->user->email ?? 'No email' }})</span>
                                    </div>
                                @endif

                                @if(!empty($myShayari->title))
                                    <h4 class="desk-couplet-title">{{ $myShayari->title }}</h4>
                                @endif

                                <div class="editorial-quote-text desk-quote-text" style="margin: {{ !empty($myShayari->title) ? '6px 0 16px' : '12px 0 16px' }};">
                                    “{{ $myShayari->quote }}”
                                </div>

                                @if($myShayari->quote_urdu)
                                    <div class="editorial-urdu-text" style="font-size: 18px; margin-bottom: 12px;">
                                        {{ $myShayari->quote_urdu }}
                                    </div>
                                @endif

                                @if($myShayari->english_translation)
                                    <div style="font-size: 13px; color: #70685E; font-style: normal; margin-bottom: 16px;">
                                        <em>Translation:</em> {{ $myShayari->english_translation }}
                                    </div>
                                @endif

                                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #F5EFE6; padding-top: 14px; font-size: 12px; color: #8C847A;">
                                    <span>{{ $myShayari->language ?? 'Roman Hindi' }}</span>
                                    <div style="display: flex; gap: 14px; align-items: center;">
                                        <span>♡ {{ $myShayari->likes_count }} likes</span>
                                        <span>💬 {{ $myShayari->comments_count }} reflections</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                @elseif($activeTab === 'bookmarks')
                    @if($bookmarkedShayaris->isEmpty())
                        <div class="editorial-featured-card" style="text-align: center; padding: 48px 32px; border-radius: 24px;">
                            <div style="font-size: 38px; margin-bottom: 16px;">🔖</div>
                            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 22px; margin-bottom: 8px;">
                                No saved couplets yet
                            </h3>
                            <p style="color: #786F64; font-size: 14px; max-width: 420px; margin: 0 auto 24px;">
                                Browse the community Feed and tap the bookmark icon on any couplet you wish to save in your collection.
                            </p>
                            <a href="{{ route('dashboard', ['tab' => 'writing']) }}" class="btn-modal-publish" style="display: inline-block; text-decoration: none; padding: 12px 28px;">Explore Feed</a>
                        </div>
                    @else
                        @foreach($bookmarkedShayaris as $savedSher)
                            @php
                                $bAuthorName = $savedSher->author_name 
                                    ?: ($savedSher->user->pen_name ?? ($savedSher->user->name ?? ($savedSher->poet->name ?? 'Alfaaz Poet')));
                                $bAuthorInitial = strtoupper(mb_substr($bAuthorName, 0, 1));
                                $bAuthorColor = $savedSher->user->avatar_color ?? '#7052FF';
                                $bTimeAgo = $savedSher->created_at ? $savedSher->created_at->diffForHumans() : 'Recently';
                                $bCategoryLabel = $savedSher->categoryModel->name ?? ($savedSher->language ?? 'Couplet');
                            @endphp

                            <article class="editorial-featured-card secondary-card">
                                <header class="card-header-creator">
                                    <div class="creator-identity">
                                        <div class="creator-avatar-badge" style="background-color: {{ $bAuthorColor }}; color: #FFFFFF;">
                                            {{ $bAuthorInitial }}
                                        </div>
                                        <div class="creator-info">
                                            <span class="creator-name">{{ $bAuthorName }}</span>
                                            <span class="creator-badge" style="color: #8C847A;">{{ $bCategoryLabel }} • {{ $bTimeAgo }}</span>
                                        </div>
                                    </div>

                                    <div class="card-header-actions">
                                        <button type="button" class="card-icon-btn share-couplet-btn" data-share-quote="{{ $savedSher->quote }}" data-share-author="{{ $bAuthorName }}" onclick="shareCoupletBtn(this)" title="Share couplet" aria-label="Share couplet">
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="18" cy="5" r="3"></circle>
                                                <circle cx="6" cy="12" r="3"></circle>
                                                <circle cx="18" cy="19" r="3"></circle>
                                                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                            </svg>
                                        </button>

                                        <button type="button" class="card-icon-btn bookmark-btn active" onclick="toggleBookmark(this, {{ $savedSher->id }})" title="Remove from saved" aria-label="Remove from saved">
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="#DF7656" stroke="#DF7656" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </header>

                                @if(!empty($savedSher->title))
                                    <div class="couplet-title-text" style="font-family: 'Playfair Display', Georgia, serif; font-size: 17px; font-weight: 700; color: #1B1815; margin-top: 10px;">
                                        {{ $savedSher->title }}
                                    </div>
                                @endif

                                <div class="editorial-quote-text regular-quote-text" style="{{ !empty($savedSher->title) ? 'margin-top: 12px;' : 'margin-top: 8px;' }}">
                                    “{{ $savedSher->quote }}”
                                </div>

                                @if(!empty($savedSher->quote_urdu))
                                    <div class="urdu-calligraphy-text" dir="rtl" style="font-family: 'Noto Nastaliq Urdu', serif; font-size: 20px; line-height: 2.2; margin-top: 14px; text-align: right; color: #2D2722;">
                                        {{ $savedSher->quote_urdu }}
                                    </div>
                                @endif

                                @if(!empty($savedSher->english_translation))
                                    <div class="english-translation-box" style="margin-top: 14px; padding: 12px 16px; background: #FAF6F0; border-radius: 12px; border-left: 3px solid #DF7656; font-size: 13.5px; color: #5D544A;">
                                        <span style="display: block; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #8F8477; margin-bottom: 4px;">Meaning in English:</span>
                                        <p style="margin: 0; font-style: normal;">“{{ $savedSher->english_translation }}”</p>
                                    </div>
                                @endif

                                <footer class="card-footer-meta">
                                    <div class="card-tags">
                                        <span class="card-tag">{{ strtoupper($bCategoryLabel) }}</span>
                                    </div>

                                    <div class="card-stats">
                                        <button type="button" class="stat-item {{ isset($likedShayariIds[$savedSher->id]) ? 'active-liked' : '' }}" onclick="toggleLike(this, {{ $savedSher->id }})">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="{{ isset($likedShayariIds[$savedSher->id]) ? '#DF7656' : 'none' }}" stroke="{{ isset($likedShayariIds[$savedSher->id]) ? '#DF7656' : 'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                            </svg>
                                            <span class="like-count">{{ $savedSher->likes_count }}</span>
                                        </button>

                                        <button type="button" class="stat-item comment-btn" id="commentBtn_{{ $savedSher->id }}" onclick="toggleCommentsDrawer({{ $savedSher->id }})" title="Reflections & Comments" aria-label="Reflections">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                            </svg>
                                            <span class="comment-count" id="commentCount_{{ $savedSher->id }}">{{ $savedSher->comments_count ?? 0 }}</span>
                                        </button>
                                    </div>
                                </footer>
                                <div class="couplet-comments-drawer" id="commentsDrawer_{{ $savedSher->id }}" style="display: none;">
                                    <div class="comments-drawer-inner">
                                        <div class="comments-drawer-header">
                                            <span class="comments-drawer-title">Reflections & Notes</span>
                                            <span class="comments-drawer-badge" id="commentsDrawerBadge_{{ $savedSher->id }}">{{ $savedSher->comments_count ?? 0 }} reflections</span>
                                        </div>

                                        <div class="comments-list-container" id="commentsList_{{ $savedSher->id }}">
                                            <div class="comments-loading-state">
                                                <span>Loading reflections...</span>
                                            </div>
                                        </div>

                                        @auth
                                            <form class="comment-composer-form" onsubmit="submitComment(event, {{ $savedSher->id }})">
                                                <div class="comment-composer-wrapper">
                                                    <textarea 
                                                        name="body" 
                                                        id="commentInput_{{ $savedSher->id }}" 
                                                        class="comment-textarea" 
                                                        rows="2" 
                                                        placeholder="Pen your reflection on this couplet (2–1000 characters)..." 
                                                        required 
                                                        minlength="2" 
                                                        maxlength="1000"
                                                        oninput="updateCommentCharCount({{ $savedSher->id }})"></textarea>
                                                    <div class="comment-composer-actions">
                                                        <span class="comment-char-counter" id="charCounter_{{ $savedSher->id }}">0 / 1000</span>
                                                        <button type="submit" class="btn-post-comment" id="commentSubmitBtn_{{ $savedSher->id }}">
                                                            Post Reflection
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <div class="comment-auth-prompt">
                                                <a href="{{ route('login') }}" class="comment-login-link">Sign in</a> to share your reflection on this verse.
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endif

                @else
                    @forelse($feedShayaris as $feedSher)
                        @php
                            $authorName = $feedSher->author_name 
                                ?: ($feedSher->user->pen_name ?? ($feedSher->user->name ?? ($feedSher->poet->name ?? 'Alfaaz Poet')));
                            $authorInitial = strtoupper(mb_substr($authorName, 0, 1));
                            $authorColor = $feedSher->user->avatar_color ?? '#7052FF';
                            $timeAgo = $feedSher->created_at ? $feedSher->created_at->diffForHumans() : 'Recently';
                            $categoryLabel = $feedSher->categoryModel->name ?? ($feedSher->language ?? 'Couplet');
                            $isFirst = $loop->first;
                        @endphp

                        <article class="editorial-featured-card {{ !$isFirst ? 'secondary-card' : 'primary-card' }}">
                            <header class="card-header-creator">
                                <div class="creator-identity">
                                    <div class="creator-avatar-badge" style="background-color: {{ $authorColor }}; color: #FFFFFF;">
                                        {{ $authorInitial }}
                                    </div>
                                    <div class="creator-info">
                                        <span class="creator-name">{{ $authorName }}</span>
                                        <span class="creator-badge" style="color: #8C847A;">{{ $categoryLabel }} • {{ $timeAgo }}</span>
                                    </div>
                                </div>

                                <div class="card-header-actions">
                                    <button type="button" class="card-icon-btn share-couplet-btn" data-share-quote="{{ $feedSher->quote }}" data-share-author="{{ $authorName }}" onclick="shareCoupletBtn(this)" title="Share couplet" aria-label="Share couplet">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="18" cy="5" r="3"></circle>
                                            <circle cx="6" cy="12" r="3"></circle>
                                            <circle cx="18" cy="19" r="3"></circle>
                                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                        </svg>
                                    </button>

                                    <button type="button" class="card-icon-btn bookmark-btn {{ isset($bookmarkedShayariIds[$feedSher->id]) ? 'active' : '' }}" onclick="toggleBookmark(this, {{ $feedSher->id }})" title="Bookmark couplet" aria-label="Bookmark couplet">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="{{ isset($bookmarkedShayariIds[$feedSher->id]) ? '#DF7656' : 'none' }}" stroke="{{ isset($bookmarkedShayariIds[$feedSher->id]) ? '#DF7656' : 'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                    </button>

                                    @if(Auth::user()->isAdmin())
                                        <form method="POST" action="{{ route('couplets.destroy', $feedSher->id) }}" onsubmit="return confirm('Admin Moderation: Are you sure you want to permanently delete this couplet from the feed?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="card-icon-btn" title="Moderate: Delete Couplet (Admin)" aria-label="Delete couplet as admin" style="color: #E53E3E;">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </header>

                            @if(!empty($feedSher->title))
                                <h3 class="editorial-couplet-title {{ $isFirst ? 'hero-title' : 'regular-title' }}">
                                    {{ $feedSher->title }}
                                </h3>
                            @endif

                            <div class="editorial-quote-text {{ $isFirst ? 'hero-quote-text' : 'regular-quote-text' }}" @if($isFirst) id="mainHeroQuote" @endif style="{{ !empty($feedSher->title) ? 'margin-top: 12px;' : '' }}">
                                “{{ $feedSher->quote }}”
                            </div>

                            @if(!empty($feedSher->quote_urdu))
                                <div class="editorial-urdu-text {{ $isFirst ? 'hero-urdu-text' : 'regular-urdu-text' }}">
                                    {{ $feedSher->quote_urdu }}
                                </div>
                            @endif

                            @if(!empty($feedSher->english_translation))
                                <div style="font-size: 14.5px; color: #70685E; font-style: normal; margin-bottom: 22px; line-height: 1.55;">
                                    <em style="color: #9C9286;">Translation:</em> {{ $feedSher->english_translation }}
                                </div>
                            @endif

                            <footer class="editorial-card-footer">
                                <div class="card-tags">
                                    <span class="card-tag">{{ strtoupper($categoryLabel) }}</span>
                                    @if(!empty($feedSher->language) && $feedSher->language !== 'Roman Hindi')
                                        <span class="card-tag">{{ strtoupper($feedSher->language) }}</span>
                                    @endif
                                </div>

                                <div class="card-stats">
                                    <button type="button" class="stat-item {{ isset($likedShayariIds[$feedSher->id]) ? 'active-liked' : '' }}" onclick="toggleLike(this, {{ $feedSher->id }})">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="{{ isset($likedShayariIds[$feedSher->id]) ? '#DF7656' : 'none' }}" stroke="{{ isset($likedShayariIds[$feedSher->id]) ? '#DF7656' : 'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                        </svg>
                                        <span class="like-count">{{ $feedSher->likes_count > 999 ? number_format($feedSher->likes_count / 1000, 1) . 'k' : $feedSher->likes_count }}</span>
                                    </button>

                                    <button type="button" class="stat-item comment-btn" id="commentBtn_{{ $feedSher->id }}" onclick="toggleCommentsDrawer({{ $feedSher->id }})" title="Reflections & Comments" aria-label="Reflections">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                        </svg>
                                        <span class="comment-count" id="commentCount_{{ $feedSher->id }}">{{ $feedSher->comments_count ?? 0 }}</span>
                                    </button>
                                </div>
                            </footer>
                            <div class="couplet-comments-drawer" id="commentsDrawer_{{ $feedSher->id }}" style="display: none;">
                                <div class="comments-drawer-inner">
                                    <div class="comments-drawer-header">
                                        <span class="comments-drawer-title">Reflections & Notes</span>
                                        <span class="comments-drawer-badge" id="commentsDrawerBadge_{{ $feedSher->id }}">{{ $feedSher->comments_count ?? 0 }} reflections</span>
                                    </div>

                                    <div class="comments-list-container" id="commentsList_{{ $feedSher->id }}">
                                        <div class="comments-loading-state">
                                            <span>Loading reflections...</span>
                                        </div>
                                    </div>

                                    @auth
                                        <form class="comment-composer-form" onsubmit="submitComment(event, {{ $feedSher->id }})">
                                            <div class="comment-composer-wrapper">
                                                <textarea 
                                                    name="body" 
                                                    id="commentInput_{{ $feedSher->id }}" 
                                                    class="comment-textarea" 
                                                    rows="2" 
                                                    placeholder="Pen your reflection on this couplet (2–1000 characters)..." 
                                                    required 
                                                    minlength="2" 
                                                    maxlength="1000"
                                                    oninput="updateCommentCharCount({{ $feedSher->id }})"></textarea>
                                                <div class="comment-composer-actions">
                                                    <span class="comment-char-counter" id="charCounter_{{ $feedSher->id }}">0 / 1000</span>
                                                    <button type="submit" class="btn-post-comment" id="commentSubmitBtn_{{ $feedSher->id }}">
                                                        Post Reflection
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="comment-auth-prompt">
                                            <a href="{{ route('login') }}" class="comment-login-link">Sign in</a> to share your reflection on this verse.
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="editorial-featured-card" style="text-align: center; padding: 64px 36px; border-radius: 24px;">
                            <div style="font-size: 42px; margin-bottom: 16px;">✒️</div>
                            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: 700; color: #1C1917; margin-bottom: 10px;">The Feed awaits its first verse</h3>
                            <p style="font-size: 15px; color: #786F64; max-width: 440px; margin: 0 auto 28px; line-height: 1.6;">
                                Be the voice that inaugurates this edition. Pen a couplet or reflection to share with the community.
                            </p>
                            <button type="button" class="btn-modal-publish" onclick="openComposerModal()" style="padding: 13px 32px; font-size: 14.5px;">
                                Pen First Couplet
                            </button>
                        </div>
                    @endforelse
                @endif
            </div>

        </main>

        <div class="composer-modal-overlay" id="composerModal" onclick="handleModalBackdropClick(event)">
            <div class="composer-modal-card" role="dialog" aria-modal="true" aria-labelledby="modalHeading">
                <div class="modal-header-row">
                    <div>
                        <span style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; color: #DF7656; text-transform: uppercase;">Alfaaz Studio</span>
                        <h2 class="modal-title" id="modalHeading">Pen a New Couplet</h2>
                    </div>
                    <button type="button" class="modal-close-btn" onclick="closeComposerModal()" aria-label="Close composer">
                        &times;
                    </button>
                </div>

                <form method="POST" action="{{ route('couplets.store') }}" id="coupletComposerForm">
                    @csrf
                    <input type="hidden" name="status" id="composerStatusInput" value="published">

                    <div style="margin-bottom: 18px;">
                        <label for="coupletTitle" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                            COUPLET TITLE / UNWAAN (OPTIONAL)
                        </label>
                        <input type="text" 
                               id="coupletTitle" 
                               name="title" 
                               class="composer-input" 
                               placeholder="e.g. Shaakh-e-Waqt, Dhoop Ka Safar, Raaste..." 
                               maxlength="150">
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label for="coupletQuote" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                            COUPLET VERSES (HINDI / ROMAN URDU) *
                        </label>
                        <textarea id="coupletQuote" 
                                  name="quote" 
                                  class="composer-textarea" 
                                  placeholder="Type your sher or couplet here..." 
                                  required></textarea>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label for="coupletUrdu" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                            URDU CALLIGRAPHY (OPTIONAL)
                        </label>
                        <textarea id="coupletUrdu" 
                                  name="quote_urdu" 
                                  class="composer-textarea" 
                                  style="direction: rtl; font-family: 'Noto Nastaliq Urdu', serif; font-style: normal; min-height: 80px; font-size: 18px;" 
                                  placeholder="اردو رسم الخط (اگر دستیاب ہو)..."></textarea>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label for="coupletTranslation" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                            ENGLISH MEANING / ESSENCE (OPTIONAL)
                        </label>
                        <textarea id="coupletTranslation" 
                                  name="english_translation" 
                                  class="composer-textarea" 
                                  style="min-height: 65px;"
                                  placeholder="Poetic English translation or essence..."></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div>
                            <label for="coupletCategory" style="display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 6px;">
                                THEME / MOOD
                            </label>
                            <select id="coupletCategory" name="category_id" class="composer-input" style="background-color: #FFFFFF;">
                                <option value="">Select Emotion...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="coupletLanguage" style="display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 6px;">
                                SCRIPT LANGUAGE
                            </label>
                            <select id="coupletLanguage" name="language" class="composer-input" style="background-color: #FFFFFF;">
                                <option value="Roman Hindi">Roman Hindi / Urdu</option>
                                <option value="Hindi">Devanagari Hindi</option>
                                <option value="Urdu">Urdu Nastaliq</option>
                                <option value="English">English Poetry</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer-actions">
                        <button type="button" class="btn-modal-cancel" onclick="closeComposerModal()">
                            Discard
                        </button>
                        <button type="button" class="btn-modal-draft" onclick="submitCoupletAs('draft')">
                            Save as Draft
                        </button>
                        <button type="button" class="btn-modal-publish" onclick="submitCoupletAs('published')">
                            Publish to Feed
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <nav class="mobile-bottom-nav" aria-label="Mobile Navigation">
            <a href="{{ route('dashboard', ['tab' => 'writing']) }}" 
               class="mobile-nav-item {{ in_array($activeTab, ['writing', '']) ? 'active' : '' }}">
                <svg class="nav-3d-icon nav-3d-feed" viewBox="0 0 32 32" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <filter id="mob_feedShadow" x="-20%" y="-20%" width="140%" height="150%">
                            <feDropShadow dx="0" dy="2" stdDeviation="1.8" flood-color="#DF7656" flood-opacity="0.35" />
                        </filter>
                        <linearGradient id="mob_feedBack" x1="6" y1="8" x2="22" y2="26" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#EEDFD0"/>
                            <stop offset="1" stop-color="#D5C2AF"/>
                        </linearGradient>
                        <linearGradient id="mob_feedFront" x1="4" y1="5" x2="26" y2="27" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#2D2520"/>
                            <stop offset="0.6" stop-color="#1E1916"/>
                            <stop offset="1" stop-color="#120F0D"/>
                        </linearGradient>
                        <linearGradient id="mob_feedSheen" x1="6" y1="6" x2="24" y2="6" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FFFFFF" stop-opacity="0.5"/>
                            <stop offset="0.5" stop-color="#FFD6C9" stop-opacity="0.8"/>
                            <stop offset="1" stop-color="#FFFFFF" stop-opacity="0.2"/>
                        </linearGradient>
                        <linearGradient id="mob_feedQuill" x1="16" y1="3" x2="28" y2="18" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FFA885"/>
                            <stop offset="0.5" stop-color="#DF7656"/>
                            <stop offset="1" stop-color="#B84928"/>
                        </linearGradient>
                    </defs>
                    <rect x="7.5" y="8" width="17" height="19" rx="3.5" transform="rotate(7 16 17.5)" fill="url(#mob_feedBack)" stroke="#C8B39E" stroke-width="0.75" />
                    <g filter="url(#mob_feedShadow)">
                        <rect x="5.5" y="6" width="18" height="21" rx="4" transform="rotate(-3 14.5 16.5)" fill="url(#mob_feedFront)" stroke="#4A3F37" stroke-width="0.8" />
                        <path d="M7 7.5 L21.5 6.7" stroke="url(#mob_feedSheen)" stroke-width="1.2" stroke-linecap="round" />
                        <line x1="8.5" y1="12" x2="18" y2="11.5" stroke="#DF7656" stroke-width="1.6" stroke-linecap="round" stroke-opacity="0.9" />
                        <line x1="8.5" y1="15.5" x2="20" y2="14.8" stroke="#E5DDD3" stroke-width="1.4" stroke-linecap="round" stroke-opacity="0.65" />
                        <line x1="8.5" y1="19" x2="15.5" y2="18.5" stroke="#E5DDD3" stroke-width="1.4" stroke-linecap="round" stroke-opacity="0.45" />
                    </g>
                    <g transform="translate(14, 2)">
                        <path d="M6 1 L11 7 L7.5 13 L5 9.5 L6 1Z" fill="url(#mob_feedQuill)" stroke="#FFE2D4" stroke-width="0.6"/>
                        <circle cx="7" cy="8" r="1" fill="#FFF2EC"/>
                        <line x1="7" y1="8" x2="11" y2="7" stroke="#681C08" stroke-width="0.5"/>
                        <circle cx="11.5" cy="6.5" r="1" fill="#FFD078"/>
                    </g>
                </svg>
                <span>Feed</span>
            </a>

            <button type="button" class="mobile-nav-compose-btn" onclick="openComposerModal()" aria-label="Compose new couplet">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>

            <a href="{{ route('dashboard', ['tab' => 'desk']) }}" 
               class="mobile-nav-item {{ $activeTab === 'desk' ? 'active' : '' }}">
                <svg class="nav-3d-icon nav-3d-desk" viewBox="0 0 32 32" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <filter id="mob_deskShadow" x="-20%" y="-20%" width="140%" height="150%">
                            <feDropShadow dx="0" dy="2" stdDeviation="1.8" flood-color="#7052FF" flood-opacity="0.35" />
                        </filter>
                        <linearGradient id="mob_deskCover" x1="4" y1="4" x2="28" y2="28" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#8E72FF"/>
                            <stop offset="0.4" stop-color="#7052FF"/>
                            <stop offset="1" stop-color="#4C2FE0"/>
                        </linearGradient>
                        <linearGradient id="mob_deskSpine" x1="4" y1="5" x2="9" y2="5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#3A1FB8"/>
                            <stop offset="0.5" stop-color="#5539D9"/>
                            <stop offset="1" stop-color="#7052FF"/>
                        </linearGradient>
                        <linearGradient id="mob_deskPages" x1="22" y1="7" x2="27" y2="25" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FAF5EE"/>
                            <stop offset="0.5" stop-color="#EADBCA"/>
                            <stop offset="1" stop-color="#D1C0AA"/>
                        </linearGradient>
                        <linearGradient id="mob_deskRibbon" x1="14" y1="4" x2="18" y2="24" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FFA885"/>
                            <stop offset="0.7" stop-color="#DF7656"/>
                            <stop offset="1" stop-color="#C24E2B"/>
                        </linearGradient>
                    </defs>
                    <path d="M8 8 L24 6 C25 6 26 7 26 8 L26 23 C26 24 25 25 24 25 L8 26 Z" fill="url(#mob_deskPages)" />
                    <line x1="24.5" y1="8" x2="24.5" y2="23.5" stroke="#C4B29C" stroke-width="0.75" />
                    <line x1="23" y1="8.5" x2="23" y2="24" stroke="#D8C8B4" stroke-width="0.75" />
                    <g filter="url(#mob_deskShadow)">
                        <rect x="5" y="5" width="18.5" height="22" rx="3.5" fill="url(#mob_deskCover)" stroke="rgba(255,255,255,0.25)" stroke-width="0.8" />
                        <path d="M5 8.5 C5 6.5 6 5 8 5 L9.5 5 L9.5 27 L8 27 C6 27 5 25.5 5 23.5 Z" fill="url(#mob_deskSpine)" />
                        <line x1="9.5" y1="5" x2="9.5" y2="27" stroke="rgba(255,255,255,0.25)" stroke-width="0.75" />
                        <circle cx="15.5" cy="14" r="3.2" stroke="#FFD8B5" stroke-width="0.9" fill="rgba(0,0,0,0.15)"/>
                        <path d="M15.5 12 L17 14 L15.5 15.5 L14.5 14 Z" fill="#FFD8B5" />
                    </g>
                    <path d="M14 4 L17 4 L17 19 L15.5 17.5 L14 19 Z" fill="url(#mob_deskRibbon)" stroke="rgba(255,255,255,0.4)" stroke-width="0.5" />
                </svg>
                <span>My Desk</span>
            </a>
        </nav>

    </div>

    <script>
        // 1. User Avatar Dropdown on Rail
        const avatarBtn = document.getElementById('railAvatarBtn');
        const dropdownMenu = document.getElementById('railDropdownMenu');

        if (avatarBtn && dropdownMenu) {
            avatarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = dropdownMenu.classList.contains('active');
                dropdownMenu.classList.toggle('active', !isOpen);
                avatarBtn.setAttribute('aria-expanded', !isOpen);
            });

            document.addEventListener('click', (e) => {
                if (!dropdownMenu.contains(e.target) && e.target !== avatarBtn) {
                    dropdownMenu.classList.remove('active');
                    avatarBtn.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    dropdownMenu.classList.remove('active');
                    closeComposerModal();
                }
            });
        }

        // 2. Toast Notifications
        let toastTimeout = null;
        function showToast(message) {
            const toast = document.getElementById('statusToast');
            const msgSpan = document.getElementById('toastMessage') || toast.querySelector('span');
            if (msgSpan) msgSpan.textContent = message;

            toast.classList.add('show');
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Auto-dismiss session toast after 3.5s
        const initialToast = document.querySelector('.toast-notification.show');
        if (initialToast) {
            setTimeout(() => {
                initialToast.classList.remove('show');
            }, 3500);
        }

        // 3. Couplet Composer Modal
        function openComposerModal() {
            document.getElementById('composerModal').classList.add('open');
            setTimeout(() => {
                document.getElementById('coupletQuote').focus();
            }, 100);
        }

        function openComposerWithPrompt(promptText) {
            openComposerModal();
            const quoteArea = document.getElementById('coupletQuote');
            quoteArea.placeholder = `Inspired by: "${promptText}"\n\nPen your verses here...`;
            showToast('Prompt tagged in your studio composer.');
        }

        function closeComposerModal() {
            document.getElementById('composerModal').classList.remove('open');
        }

        function handleModalBackdropClick(e) {
            if (e.target.id === 'composerModal') {
                closeComposerModal();
            }
        }

        function submitCoupletAs(status) {
            const quoteField = document.getElementById('coupletQuote');
            if (!quoteField.value.trim()) {
                quoteField.focus();
                showToast('Please write your couplet verses before saving.');
                return;
            }

            document.getElementById('composerStatusInput').value = status;
            document.getElementById('coupletComposerForm').submit();
        }

        // 4. Persistent Like & Bookmark AJAX Handlers
        async function toggleLike(btn, shayariId) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const heartSvg = btn.querySelector('svg');
            const countSpan = btn.querySelector('.like-count');

            const wasLiked = btn.classList.contains('active-liked');
            btn.classList.toggle('active-liked', !wasLiked);
            heartSvg.setAttribute('fill', !wasLiked ? '#DF7656' : 'none');
            heartSvg.setAttribute('stroke', !wasLiked ? '#DF7656' : 'currentColor');
            heartSvg.style.color = !wasLiked ? '#DF7656' : 'currentColor';
            if (countSpan) {
                let currentNum = parseInt(countSpan.textContent.replace(/\D/g, '')) || 0;
                countSpan.textContent = !wasLiked ? (currentNum + 1) : Math.max(0, currentNum - 1);
            }

            try {
                const res = await fetch(`/shayaris/${shayariId}/toggle-like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    }
                });
                const data = await res.json();
                if (data.success) {
                    btn.classList.toggle('active-liked', data.liked);
                    heartSvg.setAttribute('fill', data.liked ? '#DF7656' : 'none');
                    heartSvg.setAttribute('stroke', data.liked ? '#DF7656' : 'currentColor');
                    heartSvg.style.color = data.liked ? '#DF7656' : 'currentColor';
                    if (countSpan) {
                        countSpan.textContent = data.likes_count;
                    }
                    showToast(data.message);
                } else {
                    btn.classList.toggle('active-liked', wasLiked);
                    heartSvg.setAttribute('fill', wasLiked ? '#DF7656' : 'none');
                    heartSvg.setAttribute('stroke', wasLiked ? '#DF7656' : 'currentColor');
                    heartSvg.style.color = wasLiked ? '#DF7656' : 'currentColor';
                }
            } catch (err) {
                btn.classList.toggle('active-liked', wasLiked);
                heartSvg.setAttribute('fill', wasLiked ? '#DF7656' : 'none');
                heartSvg.setAttribute('stroke', wasLiked ? '#DF7656' : 'currentColor');
                heartSvg.style.color = wasLiked ? '#DF7656' : 'currentColor';
                showToast('Unable to update appreciation.');
            }
        }

        async function toggleBookmark(btn, shayariId) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const svg = btn.querySelector('svg');

            const wasBookmarked = btn.classList.contains('active');
            btn.classList.toggle('active', !wasBookmarked);
            svg.setAttribute('fill', !wasBookmarked ? '#DF7656' : 'none');
            svg.setAttribute('stroke', !wasBookmarked ? '#DF7656' : 'currentColor');
            svg.style.color = !wasBookmarked ? '#DF7656' : 'currentColor';

            try {
                const res = await fetch(`/shayaris/${shayariId}/toggle-bookmark`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    }
                });

                if (res.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                const data = await res.json();
                if (data.success) {
                    btn.classList.toggle('active', data.bookmarked);
                    svg.setAttribute('fill', data.bookmarked ? '#DF7656' : 'none');
                    svg.setAttribute('stroke', data.bookmarked ? '#DF7656' : 'currentColor');
                    svg.style.color = data.bookmarked ? '#DF7656' : 'currentColor';
                    showToast(data.message);
                } else {
                    btn.classList.toggle('active', wasBookmarked);
                    svg.setAttribute('fill', wasBookmarked ? '#DF7656' : 'none');
                    svg.setAttribute('stroke', wasBookmarked ? '#DF7656' : 'currentColor');
                    svg.style.color = wasBookmarked ? '#DF7656' : 'currentColor';
                }
            } catch (err) {
                btn.classList.toggle('active', wasBookmarked);
                svg.setAttribute('fill', wasBookmarked ? '#DF7656' : 'none');
                svg.setAttribute('stroke', wasBookmarked ? '#DF7656' : 'currentColor');
                svg.style.color = wasBookmarked ? '#DF7656' : 'currentColor';
                showToast('Unable to update bookmark.');
            }
        }

        function toggleFollow(btn, poetName) {
            const isFollowing = btn.classList.toggle('following');
            if (isFollowing) {
                btn.textContent = 'FOLLOWING';
                showToast(`Now following ${poetName}.`);
            } else {
                btn.textContent = 'FOLLOW';
                showToast(`Unfollowed ${poetName}.`);
            }
        }

        // 6. Dock quick tools: Font size scale & Focus mode
        let currentScaleIndex = 0;
        const fontSizes = ['26px', '32px', '22px'];
        function toggleFontSize() {
            currentScaleIndex = (currentScaleIndex + 1) % fontSizes.length;
            const heroQuote = document.getElementById('mainHeroQuote');
            if (heroQuote) {
                heroQuote.style.fontSize = fontSizes[currentScaleIndex];
                showToast(`Typography scale: ${fontSizes[currentScaleIndex]}`);
            }
        }

        function toggleReadingFocus() {
            const feedCol = document.querySelector('.dashboard-feed-column');
            if (feedCol) {
                const isWide = feedCol.style.maxWidth === '1000px';
                feedCol.style.maxWidth = isWide ? '820px' : '1000px';
                showToast(isWide ? 'Default reading width' : 'Expanded reading canvas');
            }
        }

        function copyFeedLink() {
            navigator.clipboard.writeText(window.location.href);
            showToast('Feed link copied to clipboard.');
        }
        const copyAnthologyLink = copyFeedLink;

        function shareCoupletBtn(el) {
            const quote = el ? (el.getAttribute('data-share-quote') || '') : '';
            const author = el ? (el.getAttribute('data-share-author') || '') : '';
            shareCouplet(quote, author);
        }

        function shareCouplet(quote, author) {
            const text = `“${quote}” — ${author}\nRead more on Alfaaz: ${window.location.href}`;
            if (navigator.share) {
                navigator.share({ title: 'Alfaaz Couplet', text: text });
            } else {
                navigator.clipboard.writeText(text);
                showToast('Couplet copied for sharing.');
            }
        }

        // 7. Couplet Reflections & Comments System
        async function toggleCommentsDrawer(shayariId) {
            const drawer = document.getElementById(`commentsDrawer_${shayariId}`);
            const btn = document.getElementById(`commentBtn_${shayariId}`);
            if (!drawer) return;

            const isHidden = drawer.style.display === 'none' || !drawer.style.display;
            if (isHidden) {
                drawer.style.display = 'block';
                if (btn) btn.classList.add('active');
                await loadComments(shayariId);
            } else {
                drawer.style.display = 'none';
                if (btn) btn.classList.remove('active');
            }
        }

        async function loadComments(shayariId) {
            const container = document.getElementById(`commentsList_${shayariId}`);
            if (!container) return;

            container.innerHTML = `
                <div class="comments-loading-state">
                    <span>Loading reflections...</span>
                </div>
            `;

            try {
                const res = await fetch(`/shayaris/${shayariId}/comments`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();

                if (data.success) {
                    updateCommentCountDisplay(shayariId, data.comments_count);
                    renderCommentsList(shayariId, data.comments);
                } else {
                    container.innerHTML = `
                        <div class="comments-empty-state">
                            <span>Unable to load reflections at this time.</span>
                        </div>
                    `;
                }
            } catch (err) {
                container.innerHTML = `
                    <div class="comments-empty-state">
                        <span>Unable to load reflections at this time.</span>
                    </div>
                `;
            }
        }

        function renderCommentsList(shayariId, comments) {
            const container = document.getElementById(`commentsList_${shayariId}`);
            if (!container) return;

            if (!comments || comments.length === 0) {
                container.innerHTML = `
                    <div class="comments-empty-state">
                        <span>No reflections yet. Be the first to share your thoughts on this verse.</span>
                    </div>
                `;
                return;
            }

            container.innerHTML = comments.map(c => `
                <div class="comment-item" id="commentItem_${c.id}">
                    <div class="comment-avatar" style="background-color: ${c.avatar_color || '#7052FF'};">
                        ${escapeHtml(c.author_initial || 'R')}
                    </div>
                    <div class="comment-content">
                        <div class="comment-meta">
                            <div class="comment-author-wrap">
                                <span class="comment-author">${escapeHtml(c.author_name)}</span>
                                ${c.is_admin ? '<span class="comment-admin-badge">Admin</span>' : ''}
                            </div>
                            <span class="comment-time">${escapeHtml(c.created_at)}</span>
                        </div>
                        <p class="comment-body">${escapeHtml(c.body)}</p>
                        ${c.can_delete ? `
                            <div class="comment-actions">
                                <button type="button" class="btn-delete-comment" onclick="deleteComment(${c.id}, ${shayariId})" title="Delete reflection">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `).join('');
        }

        async function submitComment(event, shayariId) {
            event.preventDefault();
            const input = document.getElementById(`commentInput_${shayariId}`);
            const submitBtn = document.getElementById(`commentSubmitBtn_${shayariId}`);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!input) return;
            const body = input.value.trim();

            if (body.length < 2) {
                showToast('Reflection must be at least 2 characters.');
                input.focus();
                return;
            }

            if (body.length > 1000) {
                showToast('Reflection cannot exceed 1000 characters.');
                input.focus();
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Posting...';
            }

            try {
                const res = await fetch(`/shayaris/${shayariId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ body: body })
                });

                const data = await res.json();

                if (res.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                if (data.success) {
                    input.value = '';
                    updateCommentCharCount(shayariId);
                    updateCommentCountDisplay(shayariId, data.comments_count);
                    showToast(data.message || 'Your reflection has been shared.');
                    await loadComments(shayariId);
                } else {
                    let errMsg = data.message || 'Unable to post reflection.';
                    if (data.errors && data.errors.body) {
                        errMsg = data.errors.body[0];
                    }
                    showToast(errMsg);
                }
            } catch (err) {
                showToast('An error occurred while posting your reflection.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Post Reflection';
                }
            }
        }

        async function deleteComment(commentId, shayariId) {
            if (!confirm('Are you sure you wish to delete this reflection?')) {
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            try {
                const res = await fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    }
                });

                const data = await res.json();
                if (data.success) {
                    const item = document.getElementById(`commentItem_${commentId}`);
                    if (item) {
                        item.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.96)';
                        setTimeout(() => {
                            item.remove();
                            updateCommentCountDisplay(shayariId, data.comments_count);
                            const container = document.getElementById(`commentsList_${shayariId}`);
                            if (container && container.querySelectorAll('.comment-item').length === 0) {
                                container.innerHTML = `
                                    <div class="comments-empty-state">
                                        <span>No reflections yet. Be the first to share your thoughts on this verse.</span>
                                    </div>
                                `;
                            }
                        }, 200);
                    }
                    showToast(data.message || 'Reflection removed.');
                } else {
                    showToast(data.message || 'Unable to delete reflection.');
                }
            } catch (err) {
                showToast('Error deleting reflection.');
            }
        }

        function updateCommentCountDisplay(shayariId, count) {
            const countSpans = document.querySelectorAll(`[id="commentCount_${shayariId}"]`);
            countSpans.forEach(el => el.textContent = count);

            const badge = document.getElementById(`commentsDrawerBadge_${shayariId}`);
            if (badge) {
                badge.textContent = `${count} ${count === 1 ? 'reflection' : 'reflections'}`;
            }
        }

        function updateCommentCharCount(shayariId) {
            const input = document.getElementById(`commentInput_${shayariId}`);
            const counter = document.getElementById(`charCounter_${shayariId}`);
            if (!input || !counter) return;

            const len = input.value.length;
            counter.textContent = `${len} / 1000`;
            if (len > 1000 || (len > 0 && len < 2)) {
                counter.style.color = '#B34040';
            } else {
                counter.style.color = '#8F8477';
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
    </script>
</body>
</html>
