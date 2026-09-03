<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $setting->website_name ?? appName() }}</title>

    <meta name="description" content="@yield('meta_description', 'A modern hotel management platform')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @if($setting && $setting->favicon)
        <link rel="icon" href="{{ asset('storage/' . $setting->favicon) }}">
    @endif
    @yield('meta')

    @stack('before-styles')

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">

    <style>
        :root {
            --navy: #102a43;
            --navy-dark: #071d32;
            --gold: #d69e2e;
            --gold-light: #f6e6b8;
            --text: #334e68;
            --muted: #627d98;
            --surface: #ffffff;
            --background: #f5f8fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            background: var(--background);
        }

        .page-wrapper {
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .page-wrapper::before,
        .page-wrapper::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .page-wrapper::before {
            width: 560px;
            height: 560px;
            top: -280px;
            right: -150px;
            background: rgba(214, 158, 46, 0.13);
        }

        .page-wrapper::after {
            width: 420px;
            height: 420px;
            bottom: -210px;
            left: -140px;
            background: rgba(16, 42, 67, 0.08);
        }

        .container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            background: rgba(6, 21, 50, .97);
            border-radius: 0 0 14px 14px;
            box-shadow: 0 10px 24px rgba(6, 21, 50, .24);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            font-weight: 700;
        }

        .brand img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .brand-mark {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            color: #fff;
            font-size: 19px;
            background: var(--navy);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(16, 42, 67, 0.20);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link,
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 0 28px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .nav-link {
            color: #f8fafc;
        }

        .nav-link:hover {
            color: var(--gold);
        }

        .button-primary {
            color: #fff;
            background: var(--navy);
            box-shadow: 0 8px 18px rgba(16, 42, 67, 0.18);
        }

        .button-primary:hover {
            color: #fff;
            background: var(--navy-dark);
            transform: translateY(-2px);
        }

        .button-outline {
            color: var(--navy);
            border: 1px solid #cbd5e1;
            background: #fff;
        }

        .button-outline:hover {
            color: var(--navy);
            border-color: var(--navy);
            background: #f8fafc;
        }

        .hero {
            position: relative;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 70px;
            min-height: 680px;
            padding: 50px 30px 40px;
            overflow: hidden;
        }

        .eyebrow {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 28px;
            padding-left: 15px;
        }

        .eyebrow::before {
            width: 30px;
            height: 2px;
            content: "";
            background: var(--hero-text-color);
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(48px, 5vw, 72px);
            font-weight: 700;
            line-height: 1.05;
            letter-spacing: -1.5px;
            max-width: 620px;
            color: var(--hero-text-color);
            padding-left: 15px;

        }

        .hero h1 span {
            color: var(--gold);
        }

        .hero-text {
            font-size: 20px;
            line-height: 1.8;
            max-width: 560px;
            color: var(--hero-text-color);
            opacity: .9;
            padding-left: 15px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            padding-left: 15px;
        }

        .feature-list {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            margin-top: 25px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--surface, #291111);
            font-size: 16px;
            font-weight: 500;
            opacity: .9;
        }

        .feature-item i {
            color: var(--gold);
        }

        .dashboard-card {
            position: relative;
            padding: 34px;
            color: #fff;
            background: linear-gradient(145deg, var(--navy), #174a75);
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(16, 42, 67, 0.27);
        }

        .dashboard-card::after {
            position: absolute;
            width: 190px;
            height: 190px;
            right: -70px;
            bottom: -85px;
            content: "";
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .card-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .card-heading h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 600;
        }

        .status {
            padding: 7px 10px;
            color: #c6f6d5;
            font-size: 12px;
            font-weight: 700;
            background: rgba(72, 187, 120, 0.18);
            border-radius: 20px;
        }

        .service-card {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 17px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
        }

        .service-icon {
            display: grid;
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            place-items: center;
            color: var(--gold-light);
            background: rgba(255, 255, 255, 0.10);
            border-radius: 10px;
        }

        .service-card h3 {
            margin: 0 0 4px;
            font-size: 15px;
            font-weight: 600;
        }

        .service-card p {
            margin: 0;
            color: #cbd8e6;
            font-size: 13px;
            line-height: 1.5;
        }

        .footer-note {
            position: relative;
            z-index: 1;
            padding: 0 0 28px;
            color: var(--muted);
            font-size: 13px;
            text-align: center;
        }

        .dashboard-card {
            max-width: 580px;
        }

        /* ===========================
   HERO SECTION
=========================== */

        .hero {
            position: relative;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 70px;

            min-height: calc(100vh - 100px);
            padding: 50px 30px 40px;

            overflow: hidden;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Dynamic Overlay */

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;

            background: #000;

            opacity: var(--overlay-opacity, .40);

            z-index: 1;
        }

        /* Content */

        .hero section,
        .hero aside {
            position: relative;
            z-index: 2;
            padding-right: 20px;
        }

        /* Text */

        /* .hero h1 {
            color: #fff;
        }

        .hero-text {
            color: #f3f3f3;
        }

        .eyebrow {
            color: #FFD54F;
        }

        .feature-item {
            color: #fff;
        }

        .feature-item i {
            color: #FFD54F;
        } */

        /* Right Image */

        .hero aside img {
            width: 100%;
            border-radius: 20px;
            display: block;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .35);
        }

        @media (max-width:850px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 40px;
                min-height: auto;
            }
        }



        @media (max-width: 540px) {
            .container {
                width: min(100% - 28px, 1180px);
            }

            .navbar {
                padding: 14px 12px;
                border-radius: 0 0 12px 12px;
            }

            .brand {
                font-size: 16px;
            }


            .brand-mark {
                width: 36px;
                height: 36px;
            }

            .nav-link {
                display: none;
            }

            .hero h1,
            .hero-text,
            .feature-item,
            .eyebrow {
                color: var(--hero-text-color);
            }

            .eyebrow::before {
                background: var(--hero-text-color);
            }

            .hero h1 {
                color: var(--hero-text-color) !important;
            }

            .hero-text {
                color: var(--hero-text-color) !important;
            }

            .feature-item {
                color: var(--hero-text-color) !important;
            }

            .eyebrow {
                color: var(--hero-text-color) !important;
            }

            .hero h1 {
                color: var(--hero-text-color, #fff);
            }


            /* .hero {
                padding: 40px 0 55px;
            }

            .hero-text {
                font-size: 16px;
            }

            .dashboard-card {
                padding: 25px;
            }

            .hero {
                position: relative;
            }

            .hero::before {
                content: '';
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .45);
            }

            .hero section,
            .hero aside {
                position: relative;
                z-index: 2;
            }

            .hero {
                position: relative;
                overflow: hidden;
            }

            .hero-overlay {
                position: absolute;
                inset: 0;
                background: #000;
                z-index: 1;
            }

            .hero section,
            .hero aside {
                position: relative;
                z-index: 2;
            }

            .hero {
                position: relative;
                overflow: hidden;
            }

            .hero::before {
                content: '';
                position: absolute;
                inset: 0;
                background: #000;
                opacity: var(--overlay-opacity, .4);
                z-index: 1;
            }

            .hero section,
            .hero aside {
                position: relative;
                z-index: 2;
            } */

        }
    </style>

    @stack('after-styles')
</head>

<body>
    @include('includes.partials.read-only')
    @include('includes.partials.logged-in-as')

    <div id="app" class="page-wrapper">
        <div class="container">
            <nav class="navbar">
                <a class="brand" href="{{ url('/') }}">

                    @if($setting && $setting->website_logo)
                        <img src="{{ asset('storage/' . $setting->website_logo) }}" alt="Logo"
                            style="height:50px; width:auto; margin-right:12px;">
                    @else
                        <span class="brand-mark">
                            <i class="fa fa-building"></i>
                        </span>
                    @endif

                    <span>
                        {{ $setting->website_name ?? appName() }}
                    </span>

                </a>

                <div class="nav-actions">
                    @auth
                        @if ($logged_in_user->isUser())
                            <a class="nav-link" href="{{ url('hotel/dashboard') }}">Dashboard</a>

                            <a class="button button-primary" href="{{ route('frontend.user.account') }}">
                                My Account
                            </a>
                        @endif
                    @else
                        <a class="nav-link" href="{{ route('frontend.auth.login') }}">Login</a>

                        @if (config('boilerplate.access.user.registration'))
                            <a class="button button-primary" href="{{ route('frontend.auth.register') }}">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>

            <!-- {{ $hero->text_color }} -->

            <main class="hero" style="
@if($hero && $hero->background_image)
    background-image:url('{{ asset('storage/' . $hero->background_image) }}');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
@else
    background-color: {{ $hero->background_color ?? '#f5f8fb' }};
@endif

--overlay-opacity: {{ ($hero->overlay_opacity ?? 40) / 100 }};
--hero-text-color: {{ $hero->text_color ?? '#ffffff' }};
">
                <!-- <div class="hero-overlay" style="opacity:{{ ($hero->overlay_opacity ?? 40) / 100 }};">
                </div> -->


                <section>

                    @include('includes.partials.messages')
                    <div class="eyebrow" style="color: {{ $hero->text_color ?? '#FFD54F' }};">
                        {{ $hero->badge ?? 'Hotel Management, Simplified' }}
                    </div>
                    <h1 style="color: {{ $hero->text_color }} !important;">
                        {!! $hero->heading !!}
                    </h1>

                    <p class="hero-text" style="color: {{ $hero->text_color }} !important;">
                        {{ $hero->description ?? '' }}
                    </p>

                    <div class="hero-actions">
                        @auth
                            @if ($logged_in_user->isUser())
                                <a class="button button-primary" href="{{ route('frontend.hotel.dashboard') }}">
                                    Open Dashboard <i class="fa fa-arrow-right ml-2"></i>
                                </a>
                            @endif
                        @else
                            <a class="button button-primary"
                                href="{{ $hero->primary_button_link ?? route('frontend.auth.login') }}">

                                {{ $hero->primary_button_text ?? 'Sign In' }}

                                <i class="fa fa-arrow-right ml-2"></i>
                            </a>

                            @if (config('boilerplate.access.user.registration'))
                                <a class="button button-outline"
                                    href="{{ $hero->secondary_button_link ?? route('frontend.auth.register') }}">

                                    {{ $hero->secondary_button_text ?? 'Create Account' }}

                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="feature-list">
                        <div class="feature-item"><i class="fa fa-check-circle"></i> Easy reservations</div>
                        <div class="feature-item"><i class="fa fa-check-circle"></i> Guest-first service</div>
                        <div class="feature-item"><i class="fa fa-check-circle"></i> One secure workspace</div>
                    </div>
                </section>

                <aside>

                    @if($hero && $hero->hero_image)

                        <img src="{{ asset('storage/' . $hero->hero_image) }}" alt="Hero Image"
                            style="width:100%; border-radius:20px;">

                    @endif

                </aside>
            </main>
        </div>

        <div class="footer-note">
            © {{ $setting->copyright ?? appName() }}. Built for better hospitality.
        </div>
    </div>

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
    @stack('after-scripts')
</body>

</html>
<!-- {{ $hero->text_color }} -->