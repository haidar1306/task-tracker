@extends('frontend.layouts.app')

{{-- Hero image ke upar navbar transparent rahega (overlay mode, default). Navbar code touch nahi hua. --}}

@section('title', 'Hotel Amenities')

@push('after-styles')
    <style>
        /* =========================================================
           AMENITIES PAGE  (sab classes `am-` prefix, koi clash nahi)
           ========================================================= */

        .am-page {
            --am-ink: #2b2621;
            --am-text: #4a4237;
            --am-muted: #8a7f6f;
            --am-line: #e9e0d0;
            --am-bg: #faf7f1;
            --am-card: #ffffff;
            --am-gold: #b08d4a;
            --am-gold-dark: #94742f;
            --am-gold-soft: rgba(176, 141, 74, .12);

            background: var(--am-bg);
            color: var(--am-text);
            font-family: 'Jost', 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        .am-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .am-page h1,
        .am-page h2,
        .am-page h3 {
            font-family: 'Playfair Display', Georgia, serif;
            color: var(--am-ink);
        }

        @media (prefers-reduced-motion: no-preference) {
            html:has(.am-page) {
                scroll-behavior: smooth;
            }
        }

        /* ---------------------------------------------------------
           BUTTONS
        --------------------------------------------------------- */
        .am-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            padding: 0 28px;
            border: 1px solid var(--am-gold);
            border-radius: 10px;
            background: var(--am-gold);
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s ease, border-color .2s ease, color .2s ease;
        }

        .am-btn:hover,
        .am-btn:focus {
            background: var(--am-gold-dark);
            border-color: var(--am-gold-dark);
            color: #fff;
            text-decoration: none;
        }

        .am-btn-light {
            background: transparent;
            border-color: rgba(243, 234, 217, .55);
            color: #f3ead9;
        }

        .am-btn-light:hover,
        .am-btn-light:focus {
            background: #f3ead9;
            border-color: #f3ead9;
            color: var(--am-ink);
        }

        /* ---------------------------------------------------------
           HERO  (navbar ke peeche tak failta hai)
        --------------------------------------------------------- */
        .am-hero {
            position: relative;
            isolation: isolate;
            display: flex;
            align-items: flex-end;
            min-height: 72vh;
            /* top padding = fixed navbar pill ke neeche jagah */
            padding: 160px 0 110px;
            background: #2b2621;
            color: #f3ead9;
        }

        .am-hero-bg {
            position: absolute;
            inset: 0;
            z-index: -2;
            background: url('{{ asset("frontend/images/images (7).jfif") }}') center / cover no-repeat;
        }

        /* upar dark taaki transparent navbar ka text saaf dikhe */
        .am-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(180deg, rgba(25, 21, 18, .72) 0%, rgba(25, 21, 18, .35) 35%, rgba(25, 21, 18, .82) 100%),
                linear-gradient(90deg, rgba(25, 21, 18, .55) 0%, transparent 65%);
        }

        .am-hero-inner {
            max-width: 640px;
        }

        .am-hero-kicker {
            display: inline-block;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(217, 189, 121, .6);
            color: #d9bd79;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .am-hero h1 {
            margin: 0 0 18px;
            color: #fffdf8;
            font-size: clamp(2.8rem, 6vw, 5rem);
            font-weight: 600;
            line-height: 1.05;
            letter-spacing: -.5px;
        }

        .am-hero p {
            max-width: 520px;
            margin: 0 0 28px;
            color: #e6dccb;
            font-size: 17px;
            line-height: 1.8;
        }

        .am-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        /* ---------------------------------------------------------
           QUICK NAV  (hero ke neeche overlap, anchor links)
        --------------------------------------------------------- */
        .am-quick {
            position: relative;
            z-index: 3;
            margin-top: -52px;
        }

        .am-quick-bar {
            display: flex;
            gap: 6px;
            padding: 12px;
            overflow-x: auto;
            background: var(--am-card);
            border: 1px solid var(--am-line);
            border-radius: 18px;
            box-shadow: 0 22px 50px rgba(43, 38, 33, .16);
            scrollbar-width: none;
        }

        .am-quick-bar::-webkit-scrollbar {
            display: none;
        }

        .am-chip {
            flex: 1 0 104px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 14px 8px;
            border-radius: 12px;
            color: var(--am-text);
            font-size: 13.5px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            transition: background .2s ease, color .2s ease;
        }

        .am-chip i {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--am-gold-soft);
            color: var(--am-gold-dark);
            font-size: 16px;
            transition: background .2s ease, color .2s ease;
        }

        .am-chip:hover,
        .am-chip:focus {
            background: var(--am-bg);
            color: var(--am-ink);
            text-decoration: none;
        }

        .am-chip:hover i,
        .am-chip:focus i {
            background: var(--am-gold);
            color: #fff;
        }

        /* ---------------------------------------------------------
           INTRO
        --------------------------------------------------------- */
        .am-intro {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 48px;
            align-items: end;
            padding: 96px 0 72px;
        }

        .am-intro h2 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3.1rem);
            font-weight: 600;
            line-height: 1.15;
        }

        .am-intro p {
            margin: 0;
            max-width: 460px;
            color: var(--am-muted);
            font-size: 16px;
            line-height: 1.9;
        }

        /* ---------------------------------------------------------
           AMENITY ROWS  (image + overlapping card, alternate)
        --------------------------------------------------------- */
        .am-list {
            padding-bottom: 40px;
        }

        .am-row {
            position: relative;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            align-items: center;
            margin-bottom: 104px;
            scroll-margin-top: 120px;
        }

        .am-media {
            grid-column: 1 / span 7;
            grid-row: 1;
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 11;
            border-radius: 18px;
            background: #eadfca;
        }

        .am-media img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .8s ease;
        }

        .am-row:hover .am-media img {
            transform: scale(1.04);
        }

        .am-card {
            grid-column: 7 / span 6;
            grid-row: 1;
            position: relative;
            z-index: 2;
            padding: 44px 44px 40px;
            background: var(--am-card);
            border: 1px solid var(--am-line);
            border-radius: 16px;
            box-shadow: 0 26px 60px rgba(43, 38, 33, .12);
        }

        .am-row.is-flip .am-media {
            grid-column: 6 / span 7;
        }

        .am-row.is-flip .am-card {
            grid-column: 1 / span 6;
        }

        .am-num {
            position: absolute;
            top: 14px;
            right: 26px;
            color: rgba(176, 141, 74, .2);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 84px;
            font-weight: 700;
            line-height: 1;
            pointer-events: none;
        }

        .am-icon {
            display: grid;
            place-items: center;
            width: 56px;
            height: 56px;
            margin-bottom: 20px;
            border-radius: 50%;
            background: var(--am-gold-soft);
            color: var(--am-gold-dark);
            font-size: 20px;
        }

        .am-tag {
            display: inline-block;
            margin-bottom: 12px;
            padding: 5px 12px;
            border: 1px solid #dccfb6;
            border-radius: 999px;
            color: #6b5427;
            font-size: 12.5px;
            font-weight: 500;
        }

        .am-card h3 {
            margin: 0 0 14px;
            font-size: 32px;
            font-weight: 600;
            line-height: 1.15;
        }

        .am-card p {
            margin: 0;
            max-width: 440px;
            color: var(--am-muted);
            font-size: 15.5px;
            line-height: 1.85;
        }

        /* ---------------------------------------------------------
           CTA
        --------------------------------------------------------- */
        /* ---------------------------------------------------------
       CTA
    --------------------------------------------------------- */
        .am-cta {
            padding: 10px 0 110px;
        }

        .am-cta-card {
            position: relative;
            max-width: 940px;
            margin: 0 auto;
            padding: 72px 40px 64px;
            background: linear-gradient(180deg, #ffffff 0%, #f7f0e2 100%);
            border: 1px solid var(--am-line);
            border-radius: 24px;
            box-shadow: 0 26px 60px rgba(43, 38, 33, .08);
            text-align: center;
        }

        /* upar chhoti gold line */
        .am-cta-card::before {
            content: "";
            display: block;
            width: 48px;
            height: 2px;
            margin: 0 auto 28px;
            background: var(--am-gold);
        }

        .am-cta-card p {
            max-width: 640px;
            margin: 0 auto 34px;
            color: var(--am-ink);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.35rem, 2.4vw, 1.9rem);
            font-weight: 500;
            line-height: 1.6;
        }

        .am-cta-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        .am-btn-outline {
            background: transparent;
            border-color: #d5c7ad;
            color: var(--am-ink);
        }

        .am-btn-outline:hover,
        .am-btn-outline:focus {
            background: var(--am-ink);
            border-color: var(--am-ink);
            color: #fff;
        }

        /* ---------------------------------------------------------
           RESPONSIVE
        --------------------------------------------------------- */
        @media (max-width: 991.98px) {
            .am-hero {
                min-height: 64vh;
                padding: 140px 0 100px;
            }

            .am-intro {
                grid-template-columns: 1fr;
                gap: 18px;
                padding: 80px 0 56px;
            }

            .am-row {
                display: block;
                margin-bottom: 72px;
            }

            .am-media {
                aspect-ratio: 16 / 10;
            }

            .am-card,
            .am-row.is-flip .am-card {
                margin: -56px 18px 0;
                padding: 32px 26px 30px;
            }

            .am-num {
                font-size: 64px;
            }
        }

        @media (max-width: 575.98px) {
            .am-container {
                padding: 0 16px;
            }

            .am-hero {
                min-height: 60vh;
                padding: 120px 0 90px;
            }

            .am-hero p {
                font-size: 15px;
            }

            .am-card,
            .am-row.is-flip .am-card {
                margin: -44px 10px 0;
                padding: 28px 22px 26px;
            }

            .am-card h3 {
                font-size: 26px;
            }

            .am-card p {
                font-size: 14.5px;
            }

            .am-cta {
                padding: 0 0 80px;
            }

            .am-cta-card {
                padding: 48px 22px 44px;
                border-radius: 20px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .am-media img {
                transition: none;
            }

            .am-row:hover .am-media img {
                transform: none;
            }
        }
    </style>
@endpush

@section('content')

    <div class="am-page">

        {{-- ================= HERO ================= --}}
        <section class="am-hero">
            <div class="am-hero-bg"></div>

            <div class="am-container">
                <div class="am-hero-inner">
                    <span class="am-hero-kicker">Luxury experience</span>

                    <h1>Hotel Amenities</h1>

                    <p>
                        Thoughtfully designed facilities and services, created to make every
                        moment of your stay comfortable, relaxing and memorable.
                    </p>

                    <div class="am-hero-actions">
                        <a href="{{ route('frontend.room.index') }}" class="am-btn">Explore rooms</a>
                       @if ($amenities->isNotEmpty())
    <a href="#am-{{ \Illuminate\Support\Str::slug($amenities->first()->name) }}"
        class="am-btn am-btn-light">
        See facilities
    </a>
@endif
                    </div>
                </div>
            </div>
        </section>

      {{-- ================= QUICK NAV ================= --}}
<div class="am-quick">
    <div class="am-container">
        <nav class="am-quick-bar" aria-label="Jump to a facility">
            @foreach ($amenities as $item)
                <a class="am-chip"
                    href="#am-{{ \Illuminate\Support\Str::slug($item->name) }}">

                    <i class="fas fa-{{ $item->icon ?: 'concierge-bell' }}"
                        aria-hidden="true"></i>

                    {{ $item->name }}
                </a>
            @endforeach
        </nav>
    </div>
</div>

        <div class="am-container">

            {{-- ================= INTRO ================= --}}
            <section class="am-intro">
                <h2>Designed for your comfort</h2>
                <p>
                    From wellness and dining to effortless everyday conveniences,
                    discover everything Hotel Luxura has prepared for your stay.
                </p>
            </section>

            {{-- ================= AMENITIES ================= --}}
          {{-- ================= AMENITIES ================= --}}
<section class="am-list">
    @forelse ($amenities as $index => $item)
        <article
            class="am-row {{ $index % 2 === 1 ? 'is-flip' : '' }}"
            id="am-{{ \Illuminate\Support\Str::slug($item->name) }}">

            <div class="am-media">
                @if ($item->image)
                    <img src="{{ $item->image }}"
                        alt="{{ $item->name }}"
                        loading="lazy">
                @else
                    <div style="height: 100%; display: grid; place-items: center;">
                        <i class="fas fa-{{ $item->icon ?: 'concierge-bell' }}"
                            style="font-size: 48px; color: #94742f;"
                            aria-hidden="true"></i>
                    </div>
                @endif
            </div>

            <div class="am-card">
                <span class="am-num" aria-hidden="true">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </span>

                <div class="am-icon">
                    <i class="fas fa-{{ $item->icon ?: 'concierge-bell' }}"
                        aria-hidden="true"></i>
                </div>

                @if ($item->tag)
                    <span class="am-tag">{{ $item->tag }}</span>
                @endif

                <h3>{{ $item->name }}</h3>

                <p>{{ $item->description }}</p>
            </div>
        </article>
    @empty
        <div class="text-center py-5">
            <h3>No amenities available</h3>
            <p>Please check back later to explore our hotel facilities.</p>
        </div>
    @endforelse
</section>

        {{-- ================= CTA ================= --}}
        <section class="am-cta">
            <div class="am-container">
                <div class="am-cta-card">
                    <p>
                        Settle in, slow down and enjoy a stay designed around
                        comfort, convenience and memorable experiences.
                    </p>

                    <div class="am-cta-actions">
                        <a href="{{ route('frontend.room.index') }}" class="am-btn">Explore rooms</a>
                        <a href="{{ route('frontend.contact') }}" class="am-btn am-btn-outline">Contact us</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection