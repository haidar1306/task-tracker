<style>
    .about-hero {
        height: 80vh;
        background:
            linear-gradient(rgba(0, 0, 0, .55), rgba(0, 0, 0, .55)),
            url('{{ asset("frontend/images/about-banner.jpg") }}');
        background-size: cover;
        background-position: center;
    }

    .about-img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 15px;
    }

    .card {
        transition: .3s;
        border-radius: 15px;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, .18);
    }

    .amenity-card {
        transition: .3s;
        border-radius: 15px;
    }

    .amenity-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, .15);
    }

    .amenity-card i {
        font-size: 45px;
        color: #d4af37;
    }
    

.about-hero{
    height:80vh;

    background:
    linear-gradient(
        rgba(0,0,0,0.55),
        rgba(0,0,0,0.55)
    ),
    url('{{ asset("frontend/images/hotel.jfif") }}');

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
}

.about-hero h1{
    font-size:70px;
    letter-spacing:1px;
}

.about-hero h5{
    letter-spacing:5px;
}
.contact-inquiry{
    background:#eef5f4;
    padding:80px 0;
}


.contact-inquiry h2{
    font-size:40px;
    font-weight:700;
}


.contact-card{

    background:white;
    padding:50px 30px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,.08);
    transition:.3s;

}


.contact-card:hover{

    transform:translateY(-10px);

}



.contact-card i{

    font-size:45px;
    color:#d4af37;
    margin-bottom:25px;

}



.contact-card h4{

    font-size:28px;
    margin-bottom:20px;

}



.contact-card p{

    font-size:18px;
    color:#555;

}

</style>
@extends('frontend.layouts.app')

@section('title', 'About Us')

@section('content')


    <!-- Hero -->
   <section class="about-hero d-flex align-items-center">
    <div class="container text-center text-white">

        <h5 class="text-warning text-uppercase mb-3">
            Luxury Hotel
        </h5>

        <h1 class="display-3 fw-bold">
            About Hotel Luxura
        </h1>

        <p class="lead mt-3">
            Discover elegance, comfort and unforgettable hospitality.
        </p>

    </div>
</section>


    <!-- About -->
    <section class="py-5">
        <div class="container">

            <div class="row align-items-center">


                <div class="col-lg-6">

                    <h4 class="text-info">
                        ABOUT HOTEL
                    </h4>

                    <h2 class="fw-bold mb-4">
                        Experience Luxury Like Never Before...
                    </h2>

                    <p class="text-dark">

                        Hotel Luxura provides premium accommodation with world-class facilities,
                        luxurious rooms, delicious dining, wellness experiences and exceptional
                        customer service.

                    </p>

                    <p class="text-dark">

                        Whether you're traveling for business or leisure, our goal is to make
                        every stay memorable.

                    </p>


                </div>
                <div class="col-lg-6">

                    <img src="{{ asset('frontend/images/hotel.jpg.jfif') }}" class="about-img shadow-lg">

                </div>


            </div>

        </div>

    </section>


    <!-- Why Choose -->
    <section class="bg-light py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h6 class="text-warning">
                    WHY CHOOSE US
                </h6>

                <h2 class="fw-bold">
                    OUR AMENITIES
                </h2>

            </div>

            <div class="row g-4">

                <div class="col-md-3">

                    <div class="card amenity-card text-center p-4 h-100">

                        <i class="fas fa-bed fa-3x text-warning mb-3"></i>

                        <h5>Luxury Rooms</h5>

                        <p class="text-muted">
                            Elegant rooms with premium comfort.
                        </p>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card amenity-card text-center p-4 h-100">

                        <i class="fas fa-wifi fa-3x text-warning mb-3"></i>

                        <h5>Free WiFi</h5>

                        <p class="text-muted">
                            Fast internet in every room.
                        </p>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card amenity-card text-center p-4 h-100">

                        <i class="fas fa-utensils fa-3x text-warning mb-3"></i>

                        <h5>Restaurant</h5>

                        <p class="text-muted">
                            Fine dining with international cuisine.
                        </p>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card amenity-card text-center p-4 h-100">

                        <i class="fas fa-spa fa-3x text-warning mb-3"></i>

                        <h5>Spa & Wellness</h5>

                        <p class="text-muted">
                            Relax and refresh yourself.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Statistics -->

    <section class="py-5" style="background:#111; color:#fff;">

        <div class="container">

            <div class="row text-center">

                <div class="col-md-3">

                    <h2 class="text-warning fw-bold">
                        500+
                    </h2>

                    <p>Luxury Rooms</p>

                </div>

                <div class="col-md-3">

                    <h2 class="text-warning fw-bold">
                        50K+
                    </h2>

                    <p>Happy Guests</p>

                </div>

                <div class="col-md-3">

                    <h2 class="text-warning fw-bold">
                        15+
                    </h2>

                    <p>Years Experience</p>

                </div>

                <div class="col-md-3">

                    <h2 class="text-warning fw-bold">
                        24/7
                    </h2>

                    <p>Customer Support</p>

                </div>

            </div>

        </div>

    </section>


    <!-- Team -->
    <!-- 
                        <section class="bg-light py-5">

                            <div class="container">

                                <div class="text-center mb-5">

                                    <h6 class="text-warning">
                                        OUR TEAM
                                    </h6>

                                    <h2 class="fw-bold">
                                        Meet Our Professionals
                                    </h2>

                                </div>

                                <div class="row g-4">

                                    @for($i = 1; $i <= 4; $i++)

                                        <div class="col-md-3">

                                            <div class="card border-0 shadow">

                                                <img src="https://picsum.photos/300/300?{{$i}}" class="card-img-top">

                                                <div class="card-body text-center">

                                                    <h5>Hotel Manager</h5>

                                                    <p class="text-muted">
                                                        Professional Hospitality
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    @endfor

                                </div>

                            </div>

                        </section> -->


    <!-- CTA -->

    <section class="py-5 text-center text-white" style="
        background:
        linear-gradient(rgba(0,0,0,.65),rgba(0,0,0,.65)),
        url('{{ asset('frontend/images/cta.jpg') }}');
        background-size:cover;
        background-position:center;">

        <div class="container text-center text-white">

            <h2 class="fw-bold mb-3">

                Experience Luxury Like Never Before

                Reserve your room today and enjoy
                premium hospitality.
            </h2>

            <p class="mb-4">

                Book your room today and enjoy unforgettable hospitality.

            </p>

            <a href="{{ route('frontend.room.index') }}" class="btn btn-warning btn-lg mt-3">
                Explore Rooms
            </a>
            <!-- </a> -->

        </div>

    </section>

    <section class="py-5" style="background:#111;">

        <div class="container text-center text-white">

            <h2 class="fw-bold mb-3">
                Stay With Us


            </h2>

            <p class="mb-4">

                contact with us?

            </p>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Enter your email">

                        <button class="btn btn-warning">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- Contact Inquiry Section -->

<section class="contact-inquiry">

    <div class="container">

        <div class="text-center mb-5">
            <h2>Need Any Help?</h2>
            <p>Contact us for booking and inquiries</p>
        </div>


        <div class="row g-4">


            <div class="col-md-4">

                <div class="contact-card">

                    <i class="fas fa-phone"></i>

                    <h4>Call Us</h4>

                    <p>
                        +91 9316449257
                    </p>

                </div>

            </div>



            <div class="col-md-4">

                <div class="contact-card">

                    <i class="fas fa-envelope"></i>

                    <h4>Email</h4>

                    <p>
                        admin@hotelmanagement.com
                    </p>

                </div>

            </div>



            <div class="col-md-4">

                <div class="contact-card">

                      <i class="fas fa-map-marker-alt"></i>

                    <h4>Address</h4>

                    <p>
                        Palanpur, Gujarat, India
                    </p>

                </div>

            </div>


        </div>

    </div>

</section>

@endsection