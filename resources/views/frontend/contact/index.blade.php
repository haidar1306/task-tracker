@extends('frontend.layouts.app')

@section('title', 'Contact')

@section('content')
<style>
    .contact-hero {
        position: relative;
        width: 100%;
        min-height: 46vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.78) 100%),
            url('{{ asset("frontend/images/contact1.jfif") }}') center/cover no-repeat;
        text-align: center;
    }

    .contact-hero span.kicker {
        display: inline-block;
        padding: 8px 24px;
        border: 1px solid #d9c4a5;
        color: #f0e6d4;
        border-radius: 30px;
        letter-spacing: 3px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .contact-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.4rem, 5vw, 4.2rem);
        font-weight: 700;
        color: #fffdfa;
        margin-bottom: 16px;
    }

    .contact-hero p {
        max-width: 640px;
        margin: 0 auto;
        color: #e8dcc8;
        font-size: 1.05rem;
        line-height: 1.8;
    }

    .contact-section {
        padding: 90px 0;
        background: #f7f2ea;
    }

    .contact-card {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        padding: 32px 28px;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 36px rgba(43, 38, 33, .10);
    }

    .contact-card i {
        font-size: 2.2rem;
        color: #a9825c;
        margin-bottom: 18px;
    }

    .contact-card h4 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 10px;
        color: #2b2621;
    }

    .contact-card p,
    .contact-card a {
        margin: 0;
        color: #8a7f6f;
        line-height: 1.7;
        text-decoration: none;
    }

    .contact-card a:hover {
        color: #a9825c;
    }

    .contact-form-wrap {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        padding: 36px 30px;
        border-radius: 16px;
    }

    .contact-form-wrap h3 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 26px;
        color: #2b2621;
    }

    .contact-form-wrap .form-control {
        border-radius: 8px;
        padding: 14px 16px;
        border: 1px solid #e5dccb;
        background: #f7f2ea;
    }

    .contact-form-wrap .form-control:focus {
        border-color: #a9825c;
        box-shadow: 0 0 0 0.2rem rgba(169, 130, 92, 0.15);
    }

    .contact-form-wrap .btn-gold {
        background: #a9825c;
        color: #fff;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        font-size: 14px;
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        transition: 0.3s ease;
    }

    .contact-form-wrap .btn-gold:hover {
        background: #8a6844;
        color: #fff;
    }
</style>

<section class="contact-page-wrap">

    <section class="contact-hero page-hero">
        <div class="container">
            <span class="kicker">Get In Touch</span>
            <h1>Contact Us</h1>
            <p>
                We are here to help you plan your perfect stay. Reach out for reservations, special requests,
                or any questions about your experience at Hotel Luxura.
            </p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="contact-card text-center">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Our Location</h4>
                        <p>Hotel Luxura, City Center,
                            <br>Luxury Avenue, India</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card text-center">
                        <i class="fas fa-phone-alt"></i>
                        <h4>Call Us</h4>
                        <p><a href="tel:+919876543210">+91 98765 43210</a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card text-center">
                        <i class="fas fa-envelope"></i>
                        <h4>Email Us</h4>
                        <p><a href="mailto:hello@hotelluxura.com">hello@hotelluxura.com</a></p>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrap">
                <h3>Send us a message</h3>
                <form action="{{ route('frontend.frontend.inquiry.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Your Name"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Your Email"
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="text"
                               name="subject"
                               class="form-control"
                               placeholder="Subject"
                               required>
                    </div>

                    <div class="mb-3">
                        <textarea name="message"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Your Message"
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn btn-gold">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

</section>
@endsection