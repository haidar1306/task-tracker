@extends('frontend.layouts.app')

@section('title', 'Gallery')

@section('content')
    <style>
        .gallery-hero {

    height: 320px;
    width: 100%;

    background:
    linear-gradient(
        rgba(0,0,0,0.45),
        rgba(0,0,0,0.45)
    ),
    url('{{ asset("frontend/images/hotel.jfif") }}');

    background-size: cover;
    background-position: center;

    display:flex;
    align-items:center;
    justify-content:center;

    margin-top:0;
}
        .gallery-tag {
            display: inline-block;
            padding: 10px 24px;
            background: #d4af37;
            color: #fff;
            border-radius: 40px;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .gallery-hero h1 {
            font-size: 55px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #e0e2e5;
        }

        .gallery-hero p {
            max-width: 700px;
            margin: auto;
            font-size: 22px;
            color: #d0e946;
        }

        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
        }

        .gallery-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: .5s;
        }

        .gallery-card:hover img {
            transform: scale(1.08);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: .4s;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay i {
            font-size: 35px;
            color: #fff;
        }

        .gallery-cta {
            padding: 80px 0;
            background: #101625;
            text-align: center;
            color: #fff;
        }

        .gallery-cta h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .gallery-cta p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #d1d5db;
        }
    </style>



    <section class="frontend-content">

    
        <section class="gallery-hero text-center">
            <div class="container">
                <span class="gallery-tag">
                    HOTEL LUXURA
                </span>

                <h1>
                    Luxury Moments &
                    Beautiful Spaces
                </h1>

                <p>
                    Explore the elegance of Hotel Luxura through our premium rooms,
                    fine dining, spa, swimming pool and unforgettable guest experiences.
                </p>
            </div>
        </section>



        <section class="gallery-section py-5">

            <div class="container">

                <div class="row">

                    @php

                        $images = [
                            'gallery1.jpg',
                            'gallery2.jpg',
                            'gallery3.jpg',
                            'gallery4.jpg',
                            'gallery5.jpg',
                            'gallery6.jpg',
                            'gallery7.jpg',
                            'gallery8.jpg',
                            'gallery9.jpg'
                        ];

                    @endphp

                    @foreach($images as $image)

                        <div class="col-lg-4 col-md-6 mb-4">

                            <a href="{{ asset('frontend/images/gallery/' . $image) }}" data-lightbox="hotel-gallery">

                                <div class="gallery-card">

                                    <img src="{{ asset('frontend/images/gallery/' . $image) }}" class="img-fluid">

                                    <div class="gallery-overlay">

                                        <i class="fas fa-search-plus"></i>

                                    </div>

                                </div>

                            </a>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>

    

        <section class="gallery-cta">

            <div class="container text-center">

                <h2>
                    Experience Luxury Like Never Before
                </h2>

                <p>
                    Reserve your stay and create unforgettable memories.
                </p>

                <a href="{{ route('frontend.room.index') }}" class="btn btn-gold">

                    Book Your Stay

                </a>

            </div>

        </section>

    </section>

@endsection 
