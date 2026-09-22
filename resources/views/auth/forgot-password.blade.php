<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Alfaaz</title>
    <meta name="robots" content="noindex, nofollow">
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

        a, button, [role="button"], input[type="button"], input[type="submit"] {
            cursor: pointer;
        }

        /* Ambient Glows */
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

        /* Top Bar */
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
        .auth-stage {
            position: relative;
            width: 100%;
            max-width: 450px;
            z-index: 10;
            margin: auto;
        }

        .layered-card-wrap {
            position: relative;
            width: 100%;
        }

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

        .card-layer-front {
            position: relative;
            z-index: 2;
            background: #FFFFFF;
            border: 1px solid rgba(230, 222, 212, 0.95);
            border-radius: 44px;
            padding: 44px 38px 36px;
            box-shadow: 0 24px 64px -12px rgba(45, 35, 25, 0.08), 0 4px 16px rgba(0, 0, 0, 0.02);
        }

        /* Floating Notes */
        .floating-note {
            position: absolute;
            z-index: 15;
            background: #FFFFFF;
            border-radius: 16px;
            padding: 14px 18px;
            box-shadow: 0 16px 36px -6px rgba(35, 25, 15, 0.09), 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #ECE4DA;
            cursor: default;
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
        }

        .note-bottom-right {
            bottom: 58px;
            right: -86px;
            max-width: 205px;
            transform: rotate(4.5deg);
            animation: floatNoteBottom 5.8s ease-in-out infinite alternate;
        }

        @keyframes floatNoteTop {
            0% { transform: translateY(0px) rotate(-6deg); }
            100% { transform: translateY(-10px) rotate(-6deg); }
        }

        @keyframes floatNoteBottom {
            0% { transform: translateY(0px) rotate(4.5deg); }
            100% { transform: translateY(10px) rotate(4.5deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .note-top-left, .note-bottom-right { animation: none; }
        }

        /* Header */
        .auth-header {
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
            margin: 0 0 18px;
        }

        .auth-instruction {
            font-size: 13px;
            line-height: 1.55;
            color: #6C6258;
            margin-bottom: 24px;
            text-align: center;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
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
            padding: 13px 16px;
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

        /* Submit Button */
        .btn-submit {
            width: 100%;
            border: none;
            border-radius: 14px;
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
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: linear-gradient(180deg, #6753F5 0%, #5842EE 100%);
            box-shadow: 0 12px 28px -4px rgba(104, 85, 242, 0.55);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-card-switch {
            margin-top: 20px;
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

        /* Status & Error Banners */
        .status-banner {
            background: #EBF7EE;
            border: 1px solid #B8E4C2;
            color: #1D7336;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.45;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-banner {
            background: #FDF2F0;
            border: 1px solid #F5C6CB;
            color: #C44D34;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.45;
            margin-bottom: 20px;
            text-align: left;
        }

        /* Mobile */
        @media (max-width: 680px) {
            .auth-top-bar {
                padding: 18px 20px;
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

            .note-top-left, .note-bottom-right {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow glow-left"></div>
    <div class="ambient-glow glow-right"></div>

    <header class="auth-top-bar">
        <a href="{{ route('home') }}" class="auth-brand">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L3 9L12 16L21 9L12 2Z" stroke="#1A1613" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 14.5L12 21.5L21 14.5" stroke="#7052FF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="auth-brand-text">ALFAAZ</span>
        </a>
        <div class="auth-switch">
            <span>Remembered it?</span>
            <a href="{{ route('login') }}">Sign In</a>
        </div>
    </header>

    <main class="auth-stage">
        <div class="layered-card-wrap">
            <div class="card-layer-back"></div>

            <div class="floating-note note-top-left">
                <p class="note-quote">"Na thā kuchh to ḳhudā thā..."</p>
                <span class="note-author">— Mirza Ghalib</span>
            </div>
            <div class="floating-note note-bottom-right">
                <p class="note-quote">"Hazāroñ ḳhvāhisheñ aisī ki har ḳhvāhish pe dam nikle..."</p>
                <span class="note-author">— Ghalib</span>
            </div>

            <div class="card-layer-front">
                <div class="auth-header">
                    <h1 class="brand-title-serif">A L F A A Z</h1>
                    <div class="brand-accent-line"></div>
                    <p class="brand-subtitle-serif">Recover your sanctuary of words</p>
                </div>

                <p class="auth-instruction">
                    Enter the email address tied to your account, and we will send you a link to reset your password.
                </p>

                @if (session('status'))
                    <div class="status-banner">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-banner">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="auth-form" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">EMAIL ADDRESS</label>
                        <div class="input-container">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="poet@alfaaz.com" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        SEND RESET LINK
                    </button>
                </form>

                <div class="auth-card-switch">
                    <span>Back to</span>
                    <a href="{{ route('login') }}">Sign In</a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
