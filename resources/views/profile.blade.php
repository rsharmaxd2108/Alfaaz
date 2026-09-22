@extends('layouts.app')

@section('title', 'Poet Profile & Settings — Alfaaz')
@section('robots', 'noindex, nofollow')

@section('content')
<style>
    /* Profile Page Responsive Styles */
    .profile-page-container {
        min-height: calc(100vh - 120px);
        max-width: 880px;
        margin: 0 auto;
        padding: 48px 24px 96px;
        position: relative;
        box-sizing: border-box;
    }

    .profile-hero-card {
        background: #FFFFFF;
        border: 1px solid #ECE7E0;
        border-radius: 32px;
        padding: 44px 36px 36px;
        text-align: center;
        box-shadow: 0 18px 42px -10px rgba(45, 35, 25, 0.06);
        margin-bottom: 28px;
        position: relative;
    }

    .profile-hero-name {
        font-size: 28px;
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 700;
        color: #1A1613;
        margin: 4px 0 6px;
        line-height: 1.2;
    }

    .profile-bio-snippet {
        max-width: 520px;
        margin: 0 auto;
        background: #FAF7F2;
        border: 1px solid #EFE8DE;
        border-radius: 18px;
        padding: 14px 22px;
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        color: #4A4036;
        font-size: 15px;
        line-height: 1.6;
    }

    /* 4 Stats Grid - 4 Columns on Desktop, 2x2 Grid on Mobile */
    .profile-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 32px;
    }

    .profile-stat-card {
        background: #FFFFFF;
        border: 1px solid #ECE7E0;
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        box-shadow: 0 4px 16px rgba(45, 35, 25, 0.03);
        box-sizing: border-box;
    }

    .profile-stat-value {
        font-size: 26px;
        font-weight: 700;
        font-family: 'Playfair Display', Georgia, serif;
        margin-bottom: 4px;
        line-height: 1.15;
    }

    .profile-stat-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #786E63;
        line-height: 1.2;
    }

    /* Tabs */
    .profile-nav-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        background: #EFECE6;
        padding: 6px;
        border-radius: 9999px;
        max-width: 440px;
        margin-left: auto;
        margin-right: auto;
        box-sizing: border-box;
    }

    .profile-tab-btn {
        flex: 1;
        padding: 10px 18px;
        border-radius: 9999px;
        border: none;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    /* Forms */
    .profile-form-card {
        background: #FFFFFF;
        border: 1px solid #ECE7E0;
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 18px 42px -10px rgba(45, 35, 25, 0.06);
        box-sizing: border-box;
    }

    .profile-form-title {
        font-size: 20px;
        font-weight: 700;
        color: #1A1613;
        margin-top: 0;
        margin-bottom: 8px;
        font-family: 'Playfair Display', Georgia, serif;
    }

    .profile-form-desc {
        font-size: 13.5px;
        color: #786E63;
        margin-top: 0;
        margin-bottom: 28px;
    }

    .profile-avatar-upload-box {
        margin-bottom: 28px;
        padding: 20px;
        background: #FAF8F5;
        border: 1px solid #EFECE6;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        box-sizing: border-box;
    }

    .profile-form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 20px;
    }

    .profile-submit-wrapper {
        text-align: right;
    }

    .profile-submit-btn {
        padding: 13px 32px;
        border-radius: 9999px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .profile-quick-nav {
        margin-top: 36px;
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .profile-quick-nav-btn {
        padding: 11px 24px;
        border-radius: 9999px;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* Mobile Responsive Rules */
    @media (max-width: 768px) {
        .profile-page-container {
            padding: 20px 14px 80px !important;
            max-width: 100% !important;
        }

        .profile-hero-card {
            padding: 28px 18px 22px !important;
            border-radius: 22px !important;
            margin-bottom: 18px !important;
        }

        .profile-hero-name {
            font-size: 24px !important;
        }

        .profile-bio-snippet {
            padding: 12px 14px !important;
            font-size: 13.5px !important;
            border-radius: 14px !important;
            line-height: 1.5 !important;
        }

        /* 2x2 Grid on Mobile - Eliminates horizontal overflow completely */
        .profile-stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
            margin-bottom: 20px !important;
        }

        .profile-stat-card {
            padding: 16px 10px !important;
            border-radius: 16px !important;
        }

        .profile-stat-value {
            font-size: 22px !important;
            margin-bottom: 2px !important;
        }

        .profile-stat-label {
            font-size: 9.5px !important;
            letter-spacing: 0.04em !important;
        }

        .profile-nav-tabs {
            max-width: 100% !important;
            padding: 4px !important;
            border-radius: 14px !important;
            gap: 4px !important;
            margin-bottom: 18px !important;
        }

        .profile-tab-btn {
            padding: 9px 6px !important;
            font-size: 12px !important;
            border-radius: 10px !important;
            text-align: center !important;
        }

        .profile-form-card {
            padding: 22px 16px !important;
            border-radius: 20px !important;
        }

        .profile-form-title {
            font-size: 18px !important;
        }

        .profile-form-desc {
            font-size: 12.5px !important;
            margin-bottom: 20px !important;
        }

        .profile-avatar-upload-box {
            flex-direction: column !important;
            text-align: center !important;
            padding: 18px 14px !important;
            gap: 14px !important;
            border-radius: 16px !important;
        }

        .profile-avatar-upload-content {
            width: 100% !important;
            min-width: 100% !important;
        }

        .profile-avatar-actions {
            justify-content: center !important;
        }

        .profile-form-grid-2 {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
            margin-bottom: 16px !important;
        }

        .profile-submit-wrapper {
            text-align: center !important;
        }

        .profile-submit-btn {
            width: 100% !important;
            padding: 13px 20px !important;
            font-size: 14px !important;
            box-sizing: border-box !important;
        }

        .profile-quick-nav {
            margin-top: 24px !important;
            flex-direction: column !important;
            gap: 10px !important;
        }

        .profile-quick-nav-btn {
            width: 100% !important;
            padding: 12px !important;
            box-sizing: border-box !important;
        }
    }
</style>

<div class="landing-content page-profile profile-page-container">
    <div class="ambient-glow glow-hero-center" style="opacity: 0.45; top: 12%;"></div>

    @if(session('status'))
        <div class="alert alert-success" style="margin-bottom: 28px; padding: 15px 22px; background: #EEF8F2; border: 1px solid #C3E6D2; color: #1E6B42; border-radius: 18px; display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 14.5px; box-shadow: 0 4px 16px rgba(46, 157, 97, 0.08);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 28px; padding: 16px 22px; background: #FDEDED; border: 1px solid #F7C8C8; color: #9E2B2B; border-radius: 18px; font-size: 14px; box-shadow: 0 4px 16px rgba(196, 77, 52, 0.08);">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; margin-bottom: 6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>Please check the following details:</span>
            </div>
            <ul style="margin: 0; padding-left: 26px; line-height: 1.6;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-hero-card">
        @php
            $avatarColor = $user->avatar_color ?? '#7052FF';
            $hasAvatar = !empty($user->avatar_url);
        @endphp

        <div style="display: inline-block; position: relative; margin-bottom: 16px;">
            <div id="heroAvatarDisplay" style="width: 96px; height: 96px; border-radius: 50%; background-color: {{ $avatarColor }}; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; box-shadow: 0 8px 24px rgba(27, 24, 21, 0.12); overflow: hidden; border: 3px solid #FFFFFF;">
                @if($hasAvatar)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" id="heroAvatarImg" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <span id="heroAvatarInitials" style="display: none;">{{ $user->initials }}</span>
                @else
                    <img src="" alt="" id="heroAvatarImg" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                    <span id="heroAvatarInitials">{{ $user->initials }}</span>
                @endif
            </div>

            <button type="button" onclick="document.getElementById('avatarFileInput').click()" title="Upload new profile picture" style="position: absolute; bottom: 0; right: 0; width: 34px; height: 34px; border-radius: 50%; background: #1B1815; color: #FFFFFF; border: 2px solid #FFFFFF; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
            </button>
        </div>

        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap; margin-bottom: 10px;">
            @if($user->isAdmin())
                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: #1B1815; color: #F5EBE1; border-radius: 9999px; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #DF7656;"></span>
                    Admin Profile
                </span>
            @else
                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: #F0ECFF; color: #7052FF; border-radius: 9999px; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #7052FF;"></span>
                    Poet Profile
                </span>
            @endif

            @if(!empty($user->pen_name))
                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; background: #FCF1ED; color: #DF7656; border-radius: 9999px; font-size: 11.5px; font-weight: 600;">
                    ✍️ {{ $user->pen_name }}
                </span>
            @endif
        </div>

        <h1 class="profile-hero-name">
            {{ $user->name }}
        </h1>

        <p style="font-size: 14px; color: #786E63; margin: 0 0 20px;">
            {{ $user->email }}
        </p>

        <div class="profile-bio-snippet">
            &ldquo;{{ $user->bio ?: 'A quiet voice finding rhythm in words.' }}&rdquo;
        </div>
    </div>

    <div class="profile-stats-grid">
        <div class="profile-stat-card">
            <div class="profile-stat-value" style="color: #1B1815;">
                {{ $publishedCount }}
            </div>
            <div class="profile-stat-label">
                Published Verses
            </div>
        </div>

        <div class="profile-stat-card">
            <div class="profile-stat-value" style="color: #7052FF;">
                {{ $draftsCount }}
            </div>
            <div class="profile-stat-label">
                Drafts on Desk
            </div>
        </div>

        <div class="profile-stat-card">
            <div class="profile-stat-value" style="color: #DF7656;">
                {{ $totalLikes }}
            </div>
            <div class="profile-stat-label">
                Hearts Received
            </div>
        </div>

        <div class="profile-stat-card">
            <div class="profile-stat-value" style="color: #2E9D61; font-size: 17px; margin-top: 5px; margin-bottom: 6px;">
                {{ $memberSince }}
            </div>
            <div class="profile-stat-label">
                Member Since
            </div>
        </div>
    </div>

    <div class="profile-nav-tabs" style="display: flex; gap: 8px; margin-bottom: 24px; background: #EFECE6; padding: 6px; border-radius: 9999px; max-width: 440px; margin-left: auto; margin-right: auto;">
        <button type="button" id="tabBtnDetails" onclick="switchProfileTab('details')" class="profile-tab-btn" style="flex: 1; padding: 10px 18px; border-radius: 9999px; border: none; font-size: 13.5px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: #FFFFFF; color: #1B1815; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            ✍️ Edit Profile & Bio
        </button>
        <button type="button" id="tabBtnPassword" onclick="switchProfileTab('password')" class="profile-tab-btn" style="flex: 1; padding: 10px 18px; border-radius: 9999px; border: none; font-size: 13.5px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: transparent; color: #786E63;">
            🔒 Security & Password
        </button>
    </div>

    <div id="panelDetails" style="display: block;">
        <div class="profile-form-card" style="background: #FFFFFF; border: 1px solid #ECE7E0; border-radius: 32px; padding: 40px; box-shadow: 0 18px 42px -10px rgba(45, 35, 25, 0.06);">
            <h2 class="profile-form-title" style="font-size: 20px; font-weight: 700; color: #1A1613; margin-top: 0; margin-bottom: 8px; font-family: 'Playfair Display', Georgia, serif;">
                Poet Identity & Bio
            </h2>
            <p class="profile-form-desc" style="font-size: 13.5px; color: #786E63; margin-top: 0; margin-bottom: 28px;">
                Manage your public poet name, takhallus (pen name), avatar photo, and signature bio.
            </p>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">
                <input type="hidden" name="avatar_color" id="avatarColorInput" value="{{ $user->avatar_color ?? '#7052FF' }}">

                <div class="profile-avatar-upload-box" style="margin-bottom: 28px; padding: 20px; background: #FAF8F5; border: 1px solid #EFECE6; border-radius: 20px; display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
                    <div id="formAvatarPreview" style="width: 76px; height: 76px; border-radius: 50%; background-color: {{ $avatarColor }}; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 700; overflow: hidden; flex-shrink: 0; border: 2px solid #FFFFFF; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                        @if($hasAvatar)
                            <img src="{{ $user->avatar_url }}" alt="Preview" id="formAvatarImg" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span id="formAvatarInitials" style="display: none;">{{ $user->initials }}</span>
                        @else
                            <img src="" alt="Preview" id="formAvatarImg" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <span id="formAvatarInitials">{{ $user->initials }}</span>
                        @endif
                    </div>

                    <div class="profile-avatar-upload-content" style="flex: 1; min-width: 220px;">
                        <div style="font-size: 13.5px; font-weight: 700; color: #1B1815; margin-bottom: 4px;">
                            Profile Picture
                        </div>
                        <div style="font-size: 12px; color: #786E63; margin-bottom: 12px;">
                            Supports JPG, PNG, or WEBP (up to 2MB). A circular crop will be applied.
                        </div>

                        <div class="profile-avatar-actions" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <input type="file" name="avatar" id="avatarFileInput" accept="image/jpeg,image/png,image/webp" style="display: none;" onchange="previewAvatar(this)">
                            
                            <button type="button" onclick="document.getElementById('avatarFileInput').click()" style="padding: 8px 16px; border-radius: 9999px; background: #1B1815; color: #FFFFFF; border: none; font-size: 12.5px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                                Choose Photo
                            </button>

                            <button type="button" id="removePhotoBtn" onclick="removeAvatarPhoto()" style="padding: 8px 16px; border-radius: 9999px; background: #FFFFFF; color: #C44D34; border: 1px solid #E5D5D0; font-size: 12.5px; font-weight: 600; cursor: pointer; display: {{ $hasAvatar ? 'inline-block' : 'none' }};">
                                Remove Photo
                            </button>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                        SIGNATURE INK COLOR (FALLBACK BADGE)
                    </label>
                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                        @php
                            $inkColors = [
                                '#7052FF' => 'Lilac Glow',
                                '#DF7656' => 'Terracotta',
                                '#2E9D61' => 'Forest Sage',
                                '#1B1815' => 'Obsidian Ink',
                                '#E8AE68' => 'Amber Light',
                                '#C44D34' => 'Crimson Ochre',
                            ];
                        @endphp
                        @foreach($inkColors as $hex => $label)
                            <button type="button" 
                                    class="ink-color-btn"
                                    data-color="{{ $hex }}"
                                    title="{{ $label }}"
                                    onclick="selectInkColor('{{ $hex }}')"
                                    style="width: 34px; height: 34px; border-radius: 50%; background-color: {{ $hex }}; border: 3px solid {{ ($user->avatar_color ?? '#7052FF') === $hex ? '#1B1815' : 'transparent' }}; cursor: pointer; outline: none; transition: transform 0.15s;"
                                    onmouseover="this.style.transform='scale(1.15)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </button>
                        @endforeach
                        <span id="inkColorLabel" style="font-size: 12.5px; color: #786E63; margin-left: 6px;">
                            {{ $inkColors[$user->avatar_color ?? '#7052FF'] ?? 'Custom Ink' }}
                        </span>
                    </div>
                </div>

                <div class="profile-form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 20px;">
                    <div>
                        <label for="profileName" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                            FULL NAME *
                        </label>
                        <input type="text" id="profileName" name="name" value="{{ old('name', $user->name) }}" required maxlength="100" class="composer-input" style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; background: #FFFFFF;">
                    </div>

                    <div>
                        <label for="profilePenName" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                            PEN NAME / TAKHALLUS (OPTIONAL)
                        </label>
                        <input type="text" id="profilePenName" name="pen_name" value="{{ old('pen_name', $user->pen_name) }}" placeholder="e.g. Parwaz, Shaad, Rahul..." maxlength="100" class="composer-input" style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; background: #FFFFFF;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="profileEmail" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                        EMAIL ADDRESS *
                    </label>
                    <input type="email" id="profileEmail" name="email" value="{{ old('email', $user->email) }}" required maxlength="150" class="composer-input" style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; background: #FFFFFF;">
                </div>

                <div style="margin-bottom: 28px;">
                    <label for="profileBio" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                        POETIC STATEMENT / BIO
                    </label>
                    <textarea id="profileBio" name="bio" rows="3" maxlength="500" placeholder="A line or couplet that defines your soul and poetic philosophy..." class="composer-textarea" style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; font-family: 'Playfair Display', Georgia, serif; line-height: 1.6; resize: vertical; min-height: 85px;">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="profile-submit-wrapper" style="text-align: right;">
                    <button type="submit" class="profile-submit-btn" style="padding: 13px 32px; border-radius: 9999px; background: #1B1815; color: #FFFFFF; border: none; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(27, 24, 21, 0.2);" onmouseover="this.style.background='#7052FF'" onmouseout="this.style.background='#1B1815'">
                        Save Profile Details
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="panelPassword" style="display: none;">
        <div class="profile-form-card" style="background: #FFFFFF; border: 1px solid #ECE7E0; border-radius: 32px; padding: 40px; box-shadow: 0 18px 42px -10px rgba(45, 35, 25, 0.06);">
            <h2 class="profile-form-title" style="font-size: 20px; font-weight: 700; color: #1A1613; margin-top: 0; margin-bottom: 8px; font-family: 'Playfair Display', Georgia, serif;">
                Update Password
            </h2>
            <p class="profile-form-desc" style="font-size: 13.5px; color: #786E63; margin-top: 0; margin-bottom: 28px;">
                Keep your account secure with a strong password containing letters, numbers, and symbols.
            </p>

            <form action="{{ route('profile.password.update') }}" method="POST" id="passwordUpdateForm">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label for="currentPassword" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                        CURRENT PASSWORD *
                    </label>
                    <div style="position: relative;">
                        <input type="password" id="currentPassword" name="current_password" required maxlength="128" placeholder="Enter your current password" style="width: 100%; box-sizing: border-box; padding: 12px 42px 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; background: #FFFFFF;">
                        <button type="button" onclick="togglePassVisibility('currentPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #8F8477; font-size: 14px;">
                            👁️
                        </button>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="newPassword" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                        NEW PASSWORD *
                    </label>
                    <div style="position: relative;">
                        <input type="password" id="newPassword" name="password" required minlength="8" maxlength="128" placeholder="At least 8 characters with letters, numbers & symbols" style="width: 100%; box-sizing: border-box; padding: 12px 42px 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; background: #FFFFFF;">
                        <button type="button" onclick="togglePassVisibility('newPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #8F8477; font-size: 14px;">
                            👁️
                        </button>
                    </div>
                    <div style="font-size: 12px; color: #786E63; margin-top: 6px;">
                        Must include uppercase, lowercase, numbers, and special symbols (e.g. @, #, $, !).
                    </div>
                </div>

                <div style="margin-bottom: 28px;">
                    <label for="newPasswordConfirmation" style="display: block; font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #786F64; margin-bottom: 8px;">
                        CONFIRM NEW PASSWORD *
                    </label>
                    <div style="position: relative;">
                        <input type="password" id="newPasswordConfirmation" name="password_confirmation" required minlength="8" maxlength="128" placeholder="Confirm your new password" style="width: 100%; box-sizing: border-box; padding: 12px 42px 12px 16px; border: 1px solid #E2DBD0; border-radius: 12px; font-size: 14.5px; color: #1A1613; background: #FFFFFF;">
                        <button type="button" onclick="togglePassVisibility('newPasswordConfirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #8F8477; font-size: 14px;">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="profile-submit-wrapper" style="text-align: right;">
                    <button type="submit" class="profile-submit-btn" style="padding: 13px 32px; border-radius: 9999px; background: #DF7656; color: #FFFFFF; border: none; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(223, 118, 86, 0.25);" onmouseover="this.style.background='#C44D34'" onmouseout="this.style.background='#DF7656'">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="profile-quick-nav" style="margin-top: 36px; display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('dashboard', ['tab' => 'desk']) }}" class="profile-quick-nav-btn" style="padding: 11px 24px; border-radius: 9999px; background: #1B1815; color: #FFFFFF; text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.1);">
            <span>✍️</span>
            <span>Open Poet's Desk</span>
        </a>

        <a href="{{ route('dashboard') }}" class="profile-quick-nav-btn" style="padding: 11px 24px; border-radius: 9999px; background: #FFFFFF; border: 1px solid #DCD5C9; color: #2D2519; text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span>📖</span>
            <span>Community Feed</span>
        </a>

        <a href="{{ route('dashboard', ['tab' => 'bookmarks']) }}" class="profile-quick-nav-btn" style="padding: 11px 24px; border-radius: 9999px; background: #FFFFFF; border: 1px solid #DCD5C9; color: #2D2519; text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span>🔖</span>
            <span>Saved Couplets ({{ $bookmarksCount ?? 0 }})</span>
        </a>

        <a href="{{ route('home') }}" class="profile-quick-nav-btn" style="padding: 11px 24px; border-radius: 9999px; background: transparent; color: #786E63; text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <span>🏠</span>
            <span>Home</span>
        </a>
    </div>
</div>

<script>
    // Tab Switching
    function switchProfileTab(tab) {
        const detailsBtn = document.getElementById('tabBtnDetails');
        const passwordBtn = document.getElementById('tabBtnPassword');
        const detailsPanel = document.getElementById('panelDetails');
        const passwordPanel = document.getElementById('panelPassword');

        if (tab === 'details') {
            detailsBtn.style.background = '#FFFFFF';
            detailsBtn.style.color = '#1B1815';
            detailsBtn.style.boxShadow = '0 2px 8px rgba(0,0,0,0.06)';

            passwordBtn.style.background = 'transparent';
            passwordBtn.style.color = '#786E63';
            passwordBtn.style.boxShadow = 'none';

            detailsPanel.style.display = 'block';
            passwordPanel.style.display = 'none';
        } else {
            passwordBtn.style.background = '#FFFFFF';
            passwordBtn.style.color = '#1B1815';
            passwordBtn.style.boxShadow = '0 2px 8px rgba(0,0,0,0.06)';

            detailsBtn.style.background = 'transparent';
            detailsBtn.style.color = '#786E63';
            detailsBtn.style.boxShadow = 'none';

            passwordPanel.style.display = 'block';
            detailsPanel.style.display = 'none';
        }
    }

    // Avatar preview when file selected
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const dataUrl = e.target.result;

                // Update hero avatar
                const heroImg = document.getElementById('heroAvatarImg');
                const heroInitials = document.getElementById('heroAvatarInitials');
                heroImg.src = dataUrl;
                heroImg.style.display = 'block';
                heroInitials.style.display = 'none';

                // Update form avatar
                const formImg = document.getElementById('formAvatarImg');
                const formInitials = document.getElementById('formAvatarInitials');
                formImg.src = dataUrl;
                formImg.style.display = 'block';
                formInitials.style.display = 'none';

                // Show remove button and reset remove flag
                document.getElementById('removePhotoBtn').style.display = 'inline-block';
                document.getElementById('removeAvatarInput').value = '0';
            };

            reader.readAsDataURL(file);
        }
    }

    // Remove avatar photo
    function removeAvatarPhoto() {
        document.getElementById('avatarFileInput').value = '';
        document.getElementById('removeAvatarInput').value = '1';

        // Hide img and show initials
        const heroImg = document.getElementById('heroAvatarImg');
        const heroInitials = document.getElementById('heroAvatarInitials');
        heroImg.style.display = 'none';
        heroInitials.style.display = 'block';

        const formImg = document.getElementById('formAvatarImg');
        const formInitials = document.getElementById('formAvatarInitials');
        formImg.style.display = 'none';
        formInitials.style.display = 'block';

        document.getElementById('removePhotoBtn').style.display = 'none';
    }

    // Ink Color Selection
    const inkNames = {
        '#7052FF': 'Lilac Glow',
        '#DF7656': 'Terracotta',
        '#2E9D61': 'Forest Sage',
        '#1B1815': 'Obsidian Ink',
        '#E8AE68': 'Amber Light',
        '#C44D34': 'Crimson Ochre'
    };

    function selectInkColor(hex) {
        document.getElementById('avatarColorInput').value = hex;

        // Update preview avatar backgrounds
        document.getElementById('heroAvatarDisplay').style.backgroundColor = hex;
        document.getElementById('formAvatarPreview').style.backgroundColor = hex;

        // Update buttons border
        document.querySelectorAll('.ink-color-btn').forEach(btn => {
            if (btn.getAttribute('data-color') === hex) {
                btn.style.borderColor = '#1B1815';
            } else {
                btn.style.borderColor = 'transparent';
            }
        });

        document.getElementById('inkColorLabel').textContent = inkNames[hex] || 'Custom Ink';
    }

    // Password visibility toggle
    function togglePassVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🔒';
        } else {
            input.type = 'password';
            btn.textContent = '👁️';
        }
    }
</script>
@endsection
