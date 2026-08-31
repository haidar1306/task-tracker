@extends('frontend.layouts.app')

@section('title', 'Contact')

@section('content')
<style>
    .contact-hero {
        padding: 120px 0 70px;
        background:
            linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.72)),
            url('{{ asset("frontend/images/contact1.jfif") }}') center/cover no-repeat;
    }

    .contact-hero h1 {
        font-size: clamp(2.4rem, 5vw, 5rem);
        font-weight: 800;
        color: #fff;
        margin-bottom: 18px;
    }

    .contact-hero p {
        max-width: 700px;
        margin: 0 auto;
        color: rgba(219, 219, 64, 0.8);
        font-size: 1.08rem;
        line-height: 1.8;
    }

    .contact-section {
        padding: 90px 0;
        background: #f5f7f8;
    }

    .contact-card {
        background: #fff;
        border-radius: 22px;
        padding: 32px 28px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 28px 55px rgba(15, 23, 42, 0.12);
    }

    .contact-card i {
        font-size: 2.5rem;
        color: #d4af37;
        margin-bottom: 18px;
    }

    .contact-card h4 {
        font-weight: 700;
        margin-bottom: 10px;
        color: #111827;
    }

    .contact-card p,
    .contact-card a {
        margin: 0;
        color: #4b5563;
        line-height: 1.7;
        text-decoration: none;
    }

    .contact-form-wrap {
        background: #fff;
        padding: 36px 30px;
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
    }

    .contact-form-wrap h3 {
        font-weight: 800;
        margin-bottom: 26px;
        color: #111827;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px 16px;
        border: 1px solid #dbe2ea;
        background: #f8fafc;
    }

    .form-control:focus {
        border-color: #d4af37;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15);
    }

    .btn-gold {
        background: #d4af37;
        color: #fff;
        font-weight: 700;
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        transition: 0.3s ease;
    }

    .btn-gold:hover {
        background: #b8921f;
        color: #fff;
    }
</style>

<section class="frontend-content">
    <section class="contact-hero text-center">
        <div class="container">
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
