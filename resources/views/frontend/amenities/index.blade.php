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

    <div class="row">

        @php

        $amenities = [

        ['wifi','Free WiFi','High-speed complimentary WiFi throughout the hotel.','Complimentary'],

        ['swimming-pool','Swimming Pool','Relax and refresh yourself in our outdoor swimming pool.','Premium'],

        ['dumbbell','Fitness Gym','Modern gym equipment for your daily workout.','24/7'],

        ['utensils','Restaurant','Multi-cuisine dining prepared by expert chefs.','Fine Dining'],

        ['spa','Luxury Spa','Professional spa treatments for complete relaxation.','Wellness'],

        ['parking','Free Parking','Secure parking facility available for every guest.','Free'],

        ['concierge-bell','Room Service','24×7 professional room service whenever needed.','24/7'],

        ['cocktail','Bar Lounge','Enjoy handcrafted drinks in a premium lounge.','Premium']

        ];

        @endphp

        @foreach($amenities as $item)

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="amenity-card">

                <div class="icon-box">

                    <i class="fas fa-{{ $item[0] }}"></i>

                </div>

                <span class="badge badge-warning px-3 py-2 mb-3">
                    {{ $item[3] }}
                </span>

                <h4>
                    {{ $item[1] }}
                </h4>

                <p>
                    {{ $item[2] }}
                </p>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection