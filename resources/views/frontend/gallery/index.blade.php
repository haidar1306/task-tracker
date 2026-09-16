@extends('frontend.layouts.app')

@section('title', 'Gallery')

@push('after-styles')
    <style>
        /* ===========================
           FULL BACKGROUND PAGE
        =========================== */

        .gallery-bg-page {
            position: relative;
            min-height: 100vh;
            background:
                linear-gradient(180deg, rgba(43,38,33,.72) 0%, rgba(43,38,33,.88) 100%),
                url('https://images.unsplash.com/photo-1590073844006-33379778ae09?w=1920') center/cover fixed no-repeat;
            padding: 80px 0 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .gallery-bg-heading {
            text-align: center;
            margin-bottom: 60px;
            padding: 0 20px;
        }

        .gallery-tag {
            display: inline-block;
            padding: 8px 24px;
            border: 1px solid #d9c4a5;
            color: #f0e6d4;
            background: transparent;
            border-radius: 30px;
            letter-spacing: 3px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .gallery-bg-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            font-weight: 700;
            color: #fffdfa;
            margin: 0 0 14px;
        }

        .gallery-bg-heading p {
            max-width: 620px;
            margin: 0 auto;
            color: #e8dcc8;
            font-size: 16px;
            line-height: 1.8;
        }

        /* ===========================
           HORIZONTAL SCROLL ROW
        =========================== */

        .gallery-scroll-wrap {
            position: relative;
            padding: 0 40px;
        }

        .gallery-scroll-row {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 10px 0 30px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #a9825c transparent;
        }

        .gallery-scroll-row::-webkit-scrollbar {
            height: 6px;
        }

        .gallery-scroll-row::-webkit-scrollbar-thumb {
            background: #a9825c;
            border-radius: 10px;
        }

        .gallery-scroll-row::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .gallery-scroll-item {
            flex: 0 0 auto;
            width: min(80vw, 520px);
            scroll-snap-align: center;
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 25px 55px rgba(0, 0, 0, .35);
        }

        .gallery-scroll-item img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
            transition: transform .5s ease;
        }

        .gallery-scroll-item:hover img {
            transform: scale(1.05);
        }

        .gallery-scroll-caption {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 24px 22px;
            background: linear-gradient(180deg, transparent, rgba(0,0,0,.65));
            color: #fffdfa;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
        }

        .gallery-scroll-nav {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-top: 10px;
        }

        .gallery-scroll-nav button {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.4);
            background: transparent;
            color: #fffdfa;
            font-size: 15px;
            cursor: pointer;
            transition: 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-scroll-nav button:hover {
            background: #a9825c;
            border-color: #a9825c;
        }

        .gallery-bg-cta {
            text-align: center;
            margin-top: 60px;
        }

        .gallery-bg-cta .btn-gold {
            display: inline-block;
            padding: 14px 34px;
            background: #a9825c;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-size: 14px;
            transition: 0.3s;
        }

        .gallery-bg-cta .btn-gold:hover {
            background: #8a6844;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .gallery-bg-page {
                padding: 50px 0 60px;
                background-attachment: scroll;
            }

            .gallery-scroll-wrap {
                padding: 0 16px;
            }

            .gallery-scroll-item {
                width: 84vw;
            }

            .gallery-scroll-item img {
                height: 320px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="gallery-bg-page page-hero">

        <div class="gallery-bg-heading">
            <span class="gallery-tag">Hotel Luxura</span>

            <h1>Luxury Moments &amp; Beautiful Spaces</h1>

            <p>
                Explore the elegance of Hotel Luxura through our premium rooms,
                fine dining, spa, swimming pool and unforgettable guest experiences.
            </p>
        </div>

        <div class="gallery-scroll-wrap">

            <div class="gallery-scroll-row" id="galleryScrollRow">

                @php
                    $galleryImages = [
                        ['url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900', 'caption' => 'Luxury Suite'],
                        ['url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=900', 'caption' => 'Executive Room'],
                        ['url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=900', 'caption' => 'Business Suite'],
                        ['url' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=900', 'caption' => 'Royal Suite'],
                        ['url' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=900', 'caption' => 'Presidential Suite'],
                        ['url' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=900', 'caption' => 'Swimming Pool'],
                        ['url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900', 'caption' => 'Fine Dining'],
                        ['url' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=900', 'caption' => 'Spa & Wellness'],
                        ['url' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=900', 'caption' => 'Bar Lounge'],
                    ];
                @endphp

                @foreach($galleryImages as $img)

                    <div class="gallery-scroll-item">

                        <img src="{{ $img['url'] }}" alt="{{ $img['caption'] }}">

                        <div class="gallery-scroll-caption">
                            {{ $img['caption'] }}
                        </div>

                    </div>

                @endforeach

            </div>

            <div class="gallery-scroll-nav">
                <button type="button" onclick="document.getElementById('galleryScrollRow').scrollBy({left: -540, behavior: 'smooth'})">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button type="button" onclick="document.getElementById('galleryScrollRow').scrollBy({left: 540, behavior: 'smooth'})">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

        </div>

        <div class="gallery-bg-cta">
            <a href="{{ route('frontend.room.index') }}" class="btn-gold">
                Book Your Stay
            </a>
        </div>

    </div>

@endsection