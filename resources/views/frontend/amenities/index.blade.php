@extends('frontend.layouts.app')

@section('title', 'Hotel Amenities')

@section('content')
<style>
    
.amenities-hero{

    height:420px;
    height: 80vh;
    width: 100%;
    background:
            linear-gradient(rgba(0, 0, 0, .55), rgba(0, 0, 0, .55)),
            url('{{ asset("frontend/images/amenities.jpg") }}');

    background-size:cover;

    background-position:center;

    display:flex;
    /* border-radius: 15px; */


    align-items:center;

    justify-content:center;

}


.amenities-hero h1{

    font-size:55px;

    font-weight:800;

}


.amenities-hero p{

    font-size:20px;

}


.hero-badge{

    background:#c8a96a;

    padding:10px 25px;

    border-radius:30px;

    letter-spacing:2px;

}



/* Section */

.section-title{

    color:#c8a96a;

    letter-spacing:3px;

    font-weight:700;

}



/* Cards */

.amenity-card{

    background:white;

    border-radius:20px;

    padding:35px 25px;

    text-align:center;

    height:100%;

    box-shadow:0 10px 35px rgba(0,0,0,.12);

    transition:.3s;

}


.amenity-card:hover{

    transform:translateY(-10px);

}



.icon-box{

    width:90px;

    height:90px;

    margin:0 auto 20px;

    border-radius:50%;

    background:#f8f1e5;

    display:flex;

    align-items:center;

    justify-content:center;

}


.icon-box i{

    font-size:40px;

    color:#c8a96a;

}


.amenity-card h4{

    font-weight:700;

    color:#1f2937;

}


.amenity-card p{

    color:#777;

    line-height:26px;

}



.badge-warning{

    background:#c8a96a !important;

    color:white;

}

/* Refined amenity cards */
.amenities-hero {
    min-height: 420px;
    height: auto;
    margin-top: -24px;
}

.amenities-hero h1 {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    line-height: 1.1;
    margin-bottom: 18px;
}

.amenities-hero p {
    max-width: 620px;
    margin: 0 auto;
    line-height: 1.7;
}

.amenity-card {
    padding: 0;
    overflow: hidden;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(31, 41, 55, .10);
    transition: transform .25s ease, box-shadow .25s ease;
}

.amenity-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 38px rgba(31, 41, 55, .16);
}

.amenity-image {
    position: relative;
    height: 190px;
    overflow: hidden;
    background: #e9eef0;
}

.amenity-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}

.amenity-card:hover .amenity-image img {
    transform: scale(1.05);
}

.amenity-icon {
    position: absolute;
    left: 20px;
    bottom: 18px;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    color: #c8a96a;
    font-size: 20px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, .16);
}

.amenity-card-body {
    min-height: 190px;
    padding: 22px 22px 24px;
}

.amenity-card h4 {
    font-size: 21px;
    margin: 0 0 10px;
}

.amenity-card p {
    line-height: 1.65;
    margin: 0;
}

@media (max-width: 767.98px) {
    .amenities-hero {
        min-height: 360px;
        margin-top: -16px;
    }

    .amenities-hero p {
        font-size: 16px;
    }

    .amenity-image {
        height: 170px;
    }
}
    </style>

<!-- Hero --><section class="amenities-hero">

    <div class="container text-center text-white">

        <span class="hero-badge">
            ★★★★★ Luxury Experience
        </span>

        <h1 class="mt-4">
            Hotel Amenities
        </h1>

        <p>
            Everything you need for a luxurious, comfortable,
            and memorable stay.
        </p>

    </div>

</section>  


<div class="container py-5">

    <div class="text-center mb-5">

        <span class="section-title">
            PREMIUM FACILITIES
        </span>

        <h2 class="font-weight-bold mt-3">
            Designed For Your Comfort
        </h2>

        <p class="text-muted">
            Every service is thoughtfully designed to give you a world-class hotel experience.
        </p>

    </div>

    <div class="row justify-content-center">

        @php

        $amenities = [

        ['wifi','Free WiFi','High-speed complimentary WiFi throughout the hotel.','Complimentary','amenities.jpg'],

        ['swimming-pool','Swimming Pool','Relax and refresh yourself in our outdoor swimming pool.','Premium','hotel.jfif'],

        ['dumbbell','Fitness Gym','Modern gym equipment for your daily workout.','24/7','gallery.jfif'],

        ['utensils','Restaurant','Multi-cuisine dining prepared by expert chefs.','Fine Dining','contact.jfif'],

        ['spa','Luxury Spa','Professional spa treatments for complete relaxation.','Wellness','gallery1.jfif'],

        ['parking','Free Parking','Secure parking facility available for every guest.','Free','hotel_bg.jfif'],

        ['concierge-bell','Room Service','24/7 professional room service whenever needed.','24/7','contact1.jfif'],

        ['cocktail','Bar Lounge','Enjoy handcrafted drinks in a premium lounge.','Premium','luxura4.jfif']

        ];

        @endphp

        @foreach($amenities as $item)

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4 d-flex">

            <article class="amenity-card w-100">

                <div class="amenity-image">
                    <img src="{{ asset('frontend/images/' . $item[4]) }}" alt="{{ $item[1] }}" loading="lazy">

                    <span class="amenity-icon" aria-hidden="true">
                        <i class="fas fa-{{ $item[0] }}"></i>
                    </span>

                </div>

                <div class="amenity-card-body">
                    <span class="badge badge-warning px-3 py-2 mb-3">
                        {{ $item[3] }}
                    </span>

                    <h4>{{ $item[1] }}</h4>

                    <p>{{ $item[2] }}</p>
                </div>

            </article>

        </div>

        @endforeach

    </div>

</div>

@endsection