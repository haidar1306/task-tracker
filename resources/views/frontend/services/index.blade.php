@extends('frontend.layouts.app')

@section('title', 'Hotel Services | Hotel Luxura')

@push('after-styles')
    <style>
        /* HOTEL LUXURA — SERVICES PAGE ONLY */
        .lx-services-page {
            --lx-gold: #c7a777;
            --lx-ink: #20221f;
            --lx-cream: #f7f5f0;
            background: var(--lx-cream);
            color: var(--lx-ink);
            font-family: "Jost", "Helvetica Neue", sans-serif;
        }

        /* Hero background */
        .lx-services-hero {
            min-height: 590px;
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            background:
                linear-gradient(90deg,
                    rgba(13, 19, 18, .83) 0%,
                    rgba(13, 19, 18, .55) 48%,
                    rgba(13, 19, 18, .12) 100%),
                url('{{ asset("frontend/images/bg.png") }}') center 52% / cover no-repeat;
        }

        .lx-services-hero::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 150px;
            background: linear-gradient(transparent, rgba(13, 19, 18, .28));
            pointer-events: none;
        }

        .lx-hero-content {
            width: 100%;
            max-width: 1440px;
            padding: 90px 7%;
            margin: auto;
            position: relative;
            z-index: 1;
            color: #fff;
        }

        .lx-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #e2c89f;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 23px;
        }

        .lx-eyebrow::before {
            content: "";
            width: 34px;
            height: 1px;
            background: var(--lx-gold);
        }

        .lx-hero-content h1 {
            max-width: 700px;
            margin: 0;
            color: #fffdf8;
            font-family: "Playfair Display", Georgia, serif;
            font-size: clamp(46px, 6.2vw, 82px);
            font-weight: 400;
            line-height: 1.06;
            letter-spacing: -1.8px;
        }

        .lx-hero-content h1 em {
            color: #dfc49b;
            font-weight: 400;
        }

        .lx-hero-content p {
            max-width: 510px;
            margin: 25px 0 0;
            color: rgba(255, 255, 255, .78);
            font-size: 15px;
            line-height: 1.9;
        }

        .lx-hero-link {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            margin-top: 32px;
            padding: 15px 22px;
            border: 1px solid rgba(226, 200, 159, .65);
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.8px;
            transition: .3s ease;
        }

        .lx-hero-link:hover {
            color: #1d211e;
            background: #dfc49b;
            border-color: #dfc49b;
            text-decoration: none;
        }

        .lx-hero-link i {
            color: var(--lx-gold);
            transition: transform .3s ease;
        }

        .lx-hero-link:hover i {
            color: #1d211e;
            transform: translateX(4px);
        }

        /* Services section */
        .lx-services-content {
            max-width: 1440px;
            padding: 95px 6% 110px;
            margin: auto;
        }

        .lx-section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 30px;
            margin-bottom: 42px;
        }

        .lx-section-heading .lx-eyebrow {
            color: #9a7950;
            margin-bottom: 15px;
        }

        .lx-section-heading h2 {
            margin: 0;
            color: #242620;
            font-family: "Playfair Display", Georgia, serif;
            font-size: clamp(34px, 4vw, 52px);
            font-weight: 400;
            line-height: 1.15;
        }

        .lx-section-heading p {
            max-width: 390px;
            margin: 0 0 4px;
            color: #77766e;
            font-size: 14px;
            line-height: 1.8;
        }

        /* Responsive image cards */
        .lx-services-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
        }

        .lx-service-card {
            min-width: 0;
            background: #fff;
            border: 1px solid rgba(36, 38, 32, .07);
            box-shadow: 0 8px 30px rgba(30, 32, 26, .045);
            transition: transform .35s ease, box-shadow .35s ease;
        }

        .lx-service-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 20px 45px rgba(30, 32, 26, .12);
        }

        .lx-service-image {
            position: relative;
            height: 265px;
            overflow: hidden;
            background: #dedbd3;
        }

        .lx-service-image img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s cubic-bezier(.2, .7, .2, 1);
        }

        .lx-service-card:hover .lx-service-image img {
            transform: scale(1.055);
        }

        .lx-service-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(0, 0, 0, .17), transparent 40%, rgba(0, 0, 0, .08));
            pointer-events: none;
        }

        .lx-service-number {
            position: absolute;
            top: 17px;
            left: 18px;
            z-index: 1;
            color: white;
            font-family: "Playfair Display", Georgia, serif;
            font-size: 17px;
        }

        .lx-service-icon {
            position: absolute;
            z-index: 1;
            right: 17px;
            top: 15px;
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 50%;
            background: rgba(20, 24, 21, .35);
            color: #fff4df;
            backdrop-filter: blur(8px);
        }

        .lx-service-body {
            padding: 25px 25px 26px;
        }

        .lx-service-body h3 {
            margin: 0 0 11px;
            color: #272923;
            font-family: "Playfair Display", Georgia, serif;
            font-size: 25px;
            font-weight: 400;
            line-height: 1.25;
        }

        .lx-service-body p {
            min-height: 48px;
            margin: 0 0 21px;
            color: #77776f;
            font-size: 13px;
            line-height: 1.8;
        }

        .lx-service-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #98764d;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 10px;
            font-weight: 700;
        }

        .lx-service-link i {
            transition: transform .25s ease;
        }

        .lx-service-link:hover {
            color: #6d5030;
            text-decoration: none;
        }

        .lx-service-link:hover i {
            transform: translateX(5px);
        }

        .lx-empty-services {
            grid-column: 1 / -1;
            padding: 45px 20px;
            text-align: center;
            background: #fff;
            color: #777;
        }

        /* Closing banner */
        .lx-service-note {
            position: relative;
            margin-top: 80px;
            padding: 48px 40px;
            overflow: hidden;
            background:
                linear-gradient(90deg, rgba(20, 28, 24, .93), rgba(20, 28, 24, .72)),
                url('{{ asset("frontend/images/bg.png") }}') center / cover no-repeat;
            color: #fff;
            text-align: center;
        }

        .lx-service-note .lx-eyebrow {
            justify-content: center;
            margin-bottom: 14px;
        }

        .lx-service-note h2 {
            margin: 0;
            color: #fffaf0;
            font-family: "Playfair Display", Georgia, serif;
            font-size: clamp(29px, 4vw, 43px);
            font-weight: 400;
        }

        .lx-service-note p {
            max-width: 590px;
            margin: 14px auto 0;
            color: rgba(255, 255, 255, .72);
            font-size: 13px;
            line-height: 1.8;
        }

        /* Only affects the services page */
        @media (max-width: 991px) {
            .lx-services-hero {
                min-height: 510px;
            }

            .lx-hero-content {
                padding: 75px 6%;
            }

            .lx-services-content {
                padding: 70px 5%;
            }

            .lx-services-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
            }

            .lx-service-image {
                height: 235px;
            }

            .lx-section-heading {
                align-items: start;
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 575px) {
            .lx-services-hero {
                min-height: 490px;
                background-position: 58% center;
            }

            .lx-hero-content {
                padding: 65px 24px;
            }

            .lx-hero-content h1 {
                font-size: 47px;
                letter-spacing: -1px;
            }

            .lx-hero-content p {
                font-size: 14px;
            }

            .lx-services-content {
                padding: 58px 18px 70px;
            }

            .lx-services-grid {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .lx-service-image {
                height: 250px;
            }

            .lx-service-body {
                padding: 23px 21px;
            }

            .lx-service-note {
                margin-top: 55px;
                padding: 40px 22px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .lx-service-card,
            .lx-service-image img,
            .lx-service-link i {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="lx-services-page">

        {{-- Hero: navbar and footer are inherited from the existing layout --}}
        <section class="lx-services-hero">
            <div class="lx-hero-content">
                <span class="lx-eyebrow">The Hotel Luxura Experience</span>

                <h1>
                    Comfort in<br>
                    Every <em>Detail.</em>
                </h1>

                <p>
                    Thoughtfully designed experiences, personalised hospitality
                    and considered comforts — making every moment of your stay
                    feel effortless.
                </p>

                <a href="#luxura-service-collection" class="lx-hero-link">
                    Discover Our Services
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>

        <main class="lx-services-content" id="luxura-service-collection">
            <div class="lx-section-heading">
                <div>
                    <span class="lx-eyebrow">Designed Around You</span>
                    <h2>Considered Comforts.<br>Memorable Moments.</h2>
                </div>

                <p>
                    From everyday essentials to special experiences, explore
                    the services available to make your stay more comfortable.
                </p>
            </div>

            <div class="lx-services-grid">
                @forelse($services as $index => $service)
                        <article class="lx-service-card">
                            <div class="lx-service-image">
                                <span class="lx-service-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                @if($service->icon)
                                    <span class="lx-service-icon">
                                        <i class="{{ $service->icon }}"></i>
                                    </span>
                                @endif

                                <img src="{{ $service->image
                    ? (str_starts_with($service->image, 'http')
                        ? $service->image
                        : asset('uploads/services/' . $service->image))
                    : asset('images/default-service.jpg') }}" alt="{{ $service->title }}"
                                    loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                                    onerror="this.onerror=null;this.src='{{ asset('frontend/images/bg.png') }}';">
                            </div>

                            <div class="lx-service-body">
                                <h3>{{ $service->title }}</h3>

                                <p>
                                    {{ $service->short_description
                    ?: \Illuminate\Support\Str::limit(strip_tags($service->description), 120) }}
                                </p>

                                <a href="{{ route('frontend.services.show', $service->id) }}" class="lx-service-link">
                                    Explore Service
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                @empty
                    <div class="lx-empty-services">
                        <h3>Our services are being prepared.</h3>
                        <p>Please check back soon for the latest guest experiences.</p>
                    </div>
                @endforelse
            </div>

            <section class="lx-service-note">
                <span class="lx-eyebrow">Your Stay, Your Way</span>
                <h2>A Little More Thought in Every Detail.</h2>
                <p>
                    Every great stay is built around how you feel.
                    Explore our services and plan a stay that feels right for you.
                </p>
            </section>
        </main>
    </div>
@endsection