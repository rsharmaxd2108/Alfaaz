<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Alfaaz — A Sanctuary For Your Words</title>
    <meta name="description" content="Create an account on Alfaaz to compose your poetry, save beloved couplets, and share verses that touch the soul.">
    <meta name="robots" content="noindex, follow">
    <meta name="theme-color" content="#F5F4F0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #F5F4F0;
            color: #1E1A17;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Global Interactive Element Cursor */
        a, button, [role="button"], input[type="button"], input[type="submit"], input[type="reset"], select, label[for] {
            cursor: pointer;
        }

        /* Subtle Ambient Glows */
        .ambient-glow {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(100px);
            z-index: 0;
        }

        .glow-left {
            top: 10%;
            left: 5%;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(239, 162, 130, 0.12) 0%, transparent 70%);
        }

        .glow-right {
            bottom: 10%;
            right: 5%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(112, 82, 255, 0.09) 0%, transparent 70%);
        }

        /* Top Auth Bar */
        .auth-top-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 36px;
            z-index: 30;
            width: 100%;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #171412;
            transition: opacity 0.15s ease;
        }

        .auth-brand:hover {
            opacity: 0.85;
        }

        .auth-brand-text {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.22em;
            color: #1A1613;
        }

        .auth-switch {
            font-size: 13.5px;
            color: #6C6258;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .auth-switch a {
            color: #7052FF;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.15s ease;
        }

        .auth-switch a:hover {
            color: #5535F0;
            text-decoration: underline;
        }

        /* Central Stage */
        .signup-stage {
            position: relative;
            width: 100%;
            max-width: 450px;
            z-index: 10;
            margin: auto;
        }

        /* Layered Card Container */
        .layered-card-wrap {
            position: relative;
            width: 100%;
        }

        /* Background Stacked Card Layer (Notebook Depth Effect) */
        .card-layer-back {
            position: absolute;
            top: -12px;
            right: -14px;
            bottom: 8px;
            left: 12px;
            background: #FAF3E8;
            border: 1px solid #E6DDD0;
            border-radius: 46px;
            z-index: 1;
            transform: rotate(1.8deg);
            box-shadow: 0 14px 36px -8px rgba(45, 35, 25, 0.05);
        }

        /* Main Front Card */
        .card-layer-front {
            position: relative;
            z-index: 2;
            background: #FFFFFF;
            border: 1px solid rgba(230, 222, 212, 0.95);
            border-radius: 44px;
            padding: 44px 38px 36px;
            box-shadow: 0 24px 64px -12px rgba(45, 35, 25, 0.08), 0 4px 16px rgba(0, 0, 0, 0.02);
        }

        /* Floating Poetry Notes */
        .floating-note {
            position: absolute;
            z-index: 15;
            background: #FFFFFF;
            border-radius: 16px;
            padding: 14px 18px;
            box-shadow: 0 16px 36px -6px rgba(35, 25, 15, 0.09), 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #ECE4DA;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            cursor: default;
        }

        .floating-note:hover {
            animation-play-state: paused;
            box-shadow: 0 22px 46px -6px rgba(112, 82, 255, 0.18);
        }

        .note-quote {
            font-family: 'Playfair Display', Georgia, serif;
            font-style: italic;
            font-size: 13px;
            line-height: 1.45;
            color: #1A1715;
            margin: 0 0 6px;
        }

        .note-author {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #7052FF;
            letter-spacing: 0.01em;
        }

        .note-top-left {
            top: 42px;
            left: -86px;
            max-width: 195px;
            transform: rotate(-6deg);
            animation: floatNoteTop 5s ease-in-out infinite alternate;
            will-change: transform, box-shadow;
        }

        .note-bottom-right {
            bottom: 58px;
            right: -86px;
            max-width: 205px;
            transform: rotate(4.5deg);
            animation: floatNoteBottom 5.8s ease-in-out infinite alternate;
            will-change: transform, box-shadow;
        }

        @keyframes floatNoteTop {
            0% {
                transform: translateY(0px) rotate(-6deg);
                box-shadow: 0 16px 36px -6px rgba(35, 25, 15, 0.09), 0 2px 8px rgba(0, 0, 0, 0.04);
            }
            100% {
                transform: translateY(-10px) rotate(-6deg);
                box-shadow: 0 24px 44px -6px rgba(35, 25, 15, 0.14), 0 6px 14px rgba(0, 0, 0, 0.05);
            }
        }

        @keyframes floatNoteBottom {
            0% {
                transform: translateY(0px) rotate(4.5deg);
                box-shadow: 0 16px 36px -6px rgba(35, 25, 15, 0.09), 0 2px 8px rgba(0, 0, 0, 0.04);
            }
            100% {
                transform: translateY(10px) rotate(4.5deg);
                box-shadow: 0 24px 44px -6px rgba(35, 25, 15, 0.14), 0 6px 14px rgba(0, 0, 0, 0.05);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .note-top-left,
            .note-bottom-right {
                animation: none;
            }
        }

        /* Header in Card */
        .signup-header {
            text-align: center;
        }

        .brand-title-serif {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 34px;
            font-weight: 700;
            letter-spacing: 0.35em;
            text-indent: 0.35em;
            color: #171412;
            margin: 0 0 10px;
            line-height: 1.1;
        }

        .brand-accent-line {
            width: 36px;
            height: 2px;
            background: #DF7656;
            margin: 0 auto 12px;
            border-radius: 2px;
        }

        .brand-subtitle-serif {
            font-family: 'Playfair Display', Georgia, serif;
            font-style: italic;
            font-size: 14.5px;
            color: #625950;
            margin: 0 0 26px;
        }

        /* Google Auth Button */
        .btn-google-auth {
            width: 100%;
            border-radius: 13px;
            border: 1px solid #E5E0D8;
            background: #FFFFFF;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            color: #2C2622;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-google-auth:hover {
            background: #FAF8F5;
            border-color: #D8D0C5;
            box-shadow: 0 4px 12px rgba(40, 30, 20, 0.04);
            transform: translateY(-1px);
        }

        /* Divider */
        .signup-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 22px 0 20px;
        }

        .signup-divider::before,
        .signup-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ECE6DE;
        }

        .divider-text {
            font-size: 11.5px;
            color: #8C847B;
            padding: 0 14px;
            letter-spacing: 0.02em;
        }

        /* Form Styles */
        .signup-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.09em;
            color: #4E443B;
            margin-bottom: 7px;
        }

        .input-container {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #F8F6F3;
            border: 1.5px solid transparent;
            border-radius: 14px;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }

        .input-container:focus-within {
            background: #FFFFFF;
            border-color: rgba(104, 85, 242, 0.5);
            box-shadow: 0 0 0 3.5px rgba(104, 85, 242, 0.1);
        }

        .input-icon {
            width: 18px;
            height: 18px;
            stroke: #7B7269;
            flex-shrink: 0;
        }

        .form-input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 14px;
            color: #1E1A17;
            font-family: inherit;
        }

        .form-input::placeholder {
            color: #988E83;
        }

        .btn-toggle-password {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #7B7269;
            display: flex;
            align-items: center;
            transition: color 0.15s ease;
        }

        .btn-toggle-password:hover {
            color: #1E1A17;
        }

        /* Terms Row & Custom Circular Checkbox */
        .terms-row {
            margin: 6px 0 22px;
            text-align: left;
        }

        .custom-checkbox-wrap {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .custom-checkbox-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .custom-checkbox-circle {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1.8px solid #7052FF;
            flex-shrink: 0;
            transition: all 0.2s ease;
            box-sizing: border-box;
            background: transparent;
        }

        .custom-checkbox-input:checked + .custom-checkbox-circle {
            background-color: #7052FF;
            box-shadow: inset 0 0 0 3px #FFFFFF;
        }

        .terms-label {
            font-size: 13px;
            color: #4A4139;
        }

        /* Submit CTA */
        .btn-signup-submit {
            width: 100%;
            border: none;
            border-radius: 14px;
            background: #6855F2;
            background: linear-gradient(180deg, #715DF7 0%, #634EF0 100%);
            color: #FFFFFF;
            padding: 15px 24px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            cursor: pointer;
            box-shadow: 0 10px 24px -4px rgba(104, 85, 242, 0.45);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-signup-submit:hover {
            background: linear-gradient(180deg, #6753F5 0%, #5842EE 100%);
            box-shadow: 0 12px 28px -4px rgba(104, 85, 242, 0.55);
            transform: translateY(-1px);
        }

        .btn-signup-submit:active {
            transform: translateY(0);
        }

        /* Card Auth Switch */
        .auth-card-switch {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
            color: #6C6258;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .auth-card-switch a {
            color: #6855F2;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .auth-card-switch a:hover {
            color: #5535F0;
            text-decoration: underline;
        }

        /* Footer Guarantee */
        .signup-guarantee {
            font-size: 11.5px;
            line-height: 1.55;
            color: #7A7066;
            text-align: center;
            margin: 16px auto 0;
            max-width: 320px;
        }

        /* Mobile Adjustments */
        @media (max-width: 680px) {
            .back-nav {
                top: 16px;
                left: 16px;
            }

            .card-layer-front {
                padding: 38px 24px 30px;
                border-radius: 34px;
            }

            .card-layer-back {
                border-radius: 36px;
                top: -6px;
                right: -6px;
                bottom: 6px;
                left: 6px;
            }

            .auth-top-bar,
            .auth-brand {
                display: none !important;
            }

            body {
                padding: 32px 16px 40px;
            }

            .floating-note,
            .note-top-left,
            .note-bottom-right {
                display: none !important;
            }

            .brand-title-serif {
                font-size: 28px;
            }
        }

        @media (max-width: 820px) {
            .auth-top-bar,
            .auth-brand {
                display: none !important;
            }

            body {
                padding: 32px 16px 40px;
            }

            .floating-note,
            .note-top-left,
            .note-bottom-right {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="ambient-glow glow-left" aria-hidden="true"></div>
    <div class="ambient-glow glow-right" aria-hidden="true"></div>

    <header class="auth-top-bar">
        <a href="{{ route('home') }}" class="auth-brand" aria-label="Alfaaz Home">
            <div class="auth-brand-icon">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
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
            <span class="auth-brand-text">ALFAAZ</span>
        </a>
    </header>

    <div class="signup-stage">
        <div class="floating-note note-top-left" aria-hidden="true">
            <p class="note-quote">&ldquo;Khamoshi bhi ek<br>jawab hoti hai.&rdquo;</p>
            <span class="note-author">&mdash; Alfaaz</span>
        </div>

        <div class="floating-note note-bottom-right" aria-hidden="true">
            <p class="note-quote">&ldquo;Lafz dil tak raasta bana<br>lete hain.&rdquo;</p>
            <span class="note-author">&mdash; Alfaaz</span>
        </div>

        <div class="layered-card-wrap">
            <div class="card-layer-back" aria-hidden="true"></div>

            <div class="card-layer-front">
                <div class="signup-header">
                    <h1 class="brand-title-serif">A L F A A Z</h1>
                    <div class="brand-accent-line"></div>
                    <p class="brand-subtitle-serif">Begin a home for your words</p>
                </div>

                <a href="{{ route('auth.google') }}" class="btn-google-auth" style="text-decoration: none; box-sizing: border-box;">
                    <svg class="google-icon" viewBox="0 0 24 24" width="18" height="18">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.26v3.15C3.29 21.37 7.37 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.26C.46 8.16 0 9.94 0 12s.46 3.84 1.26 5.42l4.02-3.15z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.37 0 3.29 2.63 1.26 6.58l4.02 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <div class="signup-divider">
                    <span class="divider-text">or continue with email</span>
                </div>

                @if ($errors->any())
                    <div class="auth-error-banner" style="background: #FDF2F0; border: 1px solid #F5C6CB; color: #C44D34; padding: 10px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 16px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="signup-form" method="POST" action="{{ route('signup.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nameInput" class="form-label">YOUR NAME</label>
                        <div class="input-container">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" id="nameInput" name="name" class="form-input" placeholder="What should we call you?" value="{{ old('name') }}" required autocomplete="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="emailInput" class="form-label">EMAIL ADDRESS</label>
                        <div class="input-container">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input type="email" id="emailInput" name="email" class="form-input" placeholder="poet@alfaaz.com" value="{{ old('email') }}" required autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="passwordInput" class="form-label">PASSWORD</label>
                        <div class="input-container">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" id="passwordInput" name="password" class="form-input" placeholder="At least 8 characters" minlength="8" maxlength="128" required autocomplete="new-password">
                            <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                                <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="terms-row">
                        <label class="custom-checkbox-wrap">
                            <input type="checkbox" id="termsCheck" name="terms" value="1" required class="custom-checkbox-input" {{ old('terms') ? 'checked' : '' }}>
                            <span class="custom-checkbox-circle"></span>
                            <span class="terms-label">I agree to the Terms and Privacy Policy</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-signup-submit">
                        <span>BEGIN YOUR JOURNEY</span>
                    </button>
                </form>

                <div class="auth-card-switch">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}">Log in</a>
                </div>

                <p class="signup-guarantee">
                    Your drafts stay yours. We never publish without your permission.
                </p>
            </div>
        </div>
    </div>

    <script>
    function togglePasswordVisibility() {
        const input = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    }
    </script>
</body>
</html>
