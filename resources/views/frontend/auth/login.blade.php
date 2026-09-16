@extends('frontend.layouts.minimal')

@section('title', __('Login'))

@push('after-styles')
    <style>
        :root {
            --hotel-navy: #4a4034;
            --hotel-navy-dark: #2b2621;
            --hotel-gold: #a9825c;
            --hotel-text: #3a352e;
            --hotel-muted: #8a7f6f;
        }

        body {
            background: #f7f2ea;
        }

        .minimal-auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at top right, rgba(169, 130, 92, 0.10), transparent 35%),
                radial-gradient(circle at bottom left, rgba(169, 130, 92, 0.08), transparent 35%),
                #f7f2ea;
        }

        .minimal-auth-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 26px 44px;
        }

        .minimal-auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--hotel-navy-dark);
            text-decoration: none;
        }

        .minimal-auth-brand i {
            color: var(--hotel-gold);
        }

        .minimal-auth-close {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #e5dccb;
            color: var(--hotel-text);
            font-size: 16px;
            text-decoration: none;
            transition: 0.2s;
        }

        .minimal-auth-close:hover {
            background: var(--hotel-navy-dark);
            border-color: var(--hotel-navy-dark);
            color: #fff;
        }

        .minimal-auth-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 24px 60px;
        }

        .minimal-auth-frame {
            width: 100%;
            max-width: 1080px;
            background: #fffdfa;
            border-radius: 22px;
            box-shadow: 0 30px 70px rgba(43, 38, 33, 0.12);
            overflow: hidden;
        }

        .minimal-auth-frame-header {
            text-align: center;
            padding: 40px 40px 0;
        }

        .minimal-auth-kicker {
            display: inline-block;
            padding: 6px 18px;
            border: 1px solid #e5dccb;
            border-radius: 30px;
            color: var(--hotel-gold);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .minimal-auth-frame-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--hotel-navy-dark);
            margin: 0 0 6px;
        }

        .minimal-auth-frame-header p {
            color: var(--hotel-muted);
            font-size: 14px;
            margin: 0;
        }

        .minimal-auth-columns {
            display: grid;
            grid-template-columns: 1fr 1px 1fr;
            gap: 0;
            padding: 36px 44px 44px;
        }

        .minimal-auth-col-left,
        .minimal-auth-col-right {
            padding: 10px 34px;
        }

        .minimal-auth-divider-vert {
            background: #eee2d0;
        }

        .minimal-auth-col-heading {
            text-align: center;
            font-size: 19px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: var(--hotel-navy-dark);
            margin-bottom: 6px;
        }

        .minimal-auth-col-sub {
            text-align: center;
            color: var(--hotel-muted);
            font-size: 13px;
            margin-bottom: 26px;
        }

        /* Left column: benefits grid */

        .benefit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 26px;
        }

        .benefit-grid figure {
            margin: 0;
            position: relative;
        }

        .benefit-grid img {
            width: 100%;
            height: 105px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
            margin-bottom: 9px;
            box-shadow: 0 8px 18px rgba(43, 38, 33, 0.10);
        }

        .benefit-grid figcaption {
            color: var(--hotel-text);
            font-size: 13px;
            line-height: 1.5;
            font-weight: 500;
        }

        .join-now-btn {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            padding: 14px;
            text-align: center;
            background: var(--hotel-navy-dark);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.2s;
        }

        .join-now-btn:hover {
            background: var(--hotel-gold);
            color: #fff;
            transform: translateY(-2px);
        }

        /* Right column: login form */

        .minimal-auth-card {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
        }

        .minimal-auth-card label {
            display: block;
            margin-bottom: 8px;
            color: var(--hotel-muted);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .minimal-auth-card .form-group {
            margin-bottom: 22px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            top: 50%;
            left: 2px;
            color: #b7ab98;
            transform: translateY(-50%);
            font-size: 14px;
        }

        .minimal-auth-card .form-control {
            width: 100%;
            padding: 8px 2px 12px 26px;
            color: var(--hotel-text);
            font-size: 15px;
            background: transparent;
            border: none;
            border-bottom: 1px solid #e5dccb;
            border-radius: 0;
            box-shadow: none;
        }

        .minimal-auth-card .form-control:focus {
            border-bottom-color: var(--hotel-gold);
            box-shadow: none;
            outline: none;
        }

        .minimal-auth-card .form-control::placeholder {
            color: #b7ab98;
        }

        .minimal-auth-card .custom-control-label {
            padding-top: 1px;
            color: var(--hotel-muted);
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
        }

        .minimal-auth-card .custom-control-input:checked ~ .custom-control-label::before {
            border-color: var(--hotel-navy);
            background-color: var(--hotel-navy);
        }

        .login-button {
            width: 100%;
            height: 50px;
            margin-top: 10px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--hotel-gold);
            border: 0;
            border-radius: 8px;
            box-shadow: 0 10px 22px rgba(169, 130, 92, 0.25);
            transition: all 0.2s ease;
        }

        .login-button:hover,
        .login-button:focus {
            color: #fff;
            background: #8a6844;
            transform: translateY(-2px);
        }

        .minimal-auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 26px 0 16px;
            color: var(--hotel-muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .minimal-auth-divider::before,
        .minimal-auth-divider::after {
            flex: 1;
            height: 1px;
            content: "";
            background: #eee2d0;
        }

        .minimal-auth-links {
            display: flex;
            justify-content: center;
            gap: 22px;
            font-size: 13px;
        }

        .minimal-auth-links a {
            color: var(--hotel-gold);
            font-weight: 600;
            text-decoration: none;
        }

        .minimal-auth-links a:hover {
            color: var(--hotel-navy-dark);
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .minimal-auth-columns {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 30px 26px 36px;
            }

            .minimal-auth-divider-vert {
                display: none;
            }

            .minimal-auth-col-left,
            .minimal-auth-col-right {
                padding: 0;
            }
        }

        @media (max-width: 575.98px) {
            .minimal-auth-topbar {
                padding: 18px 20px;
            }

            .minimal-auth-body {
                padding: 10px 12px 40px;
            }

            .minimal-auth-brand {
                font-size: 16px;
            }

            .minimal-auth-frame {
                border-radius: 16px;
            }

            .minimal-auth-frame-header {
                padding: 30px 20px 0;
            }

            .minimal-auth-frame-header h1 {
                font-size: 22px;
            }

            .benefit-grid img {
                height: 85px;
            }

            .minimal-auth-links {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="minimal-auth-page">

        <div class="minimal-auth-topbar">
            <a href="{{ route('frontend.index') }}" class="minimal-auth-brand">
                <i class="fa fa-hotel"></i> Hotel Luxura
            </a>
            <a href="{{ route('frontend.index') }}" class="minimal-auth-close" aria-label="Close">
                <i class="fa fa-times"></i>
            </a>
        </div>

        <div class="minimal-auth-body">
            <div class="minimal-auth-frame">

                <div class="minimal-auth-frame-header">
                    <span class="minimal-auth-kicker">Welcome to Hotel Luxura</span>
                    <h1>Your Stay, Your Way</h1>
                    <p>Sign in to manage bookings, or join us for exclusive member benefits.</p>
                </div>

                <div class="minimal-auth-columns">

                    <div class="minimal-auth-col-left">
                        <h3 class="minimal-auth-col-heading">New Here? Join Now</h3>
                        <p class="minimal-auth-col-sub">Create a free account in seconds</p>

                        <div class="benefit-grid">
                            <figure>
                                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400" alt="Luxury Rooms">
                                <figcaption>Exclusive rates on luxury rooms</figcaption>
                            </figure>

                            <figure>
                                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400" alt="Fine Dining">
                                <figcaption>Special offers on dining and stays</figcaption>
                            </figure>

                            <figure>
                                <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=400" alt="Swimming Pool">
                                <figcaption>Priority access to pool and spa</figcaption>
                            </figure>

                            <figure>
                                <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400" alt="Spa Wellness">
                                <figcaption>Earn rewards on every stay</figcaption>
                            </figure>
                        </div>

                        @if (config('boilerplate.access.user.registration'))
                            <a href="{{ route('frontend.auth.register') }}" class="join-now-btn">
                                Register Now
                            </a>
                        @endif
                    </div>

                    <div class="minimal-auth-divider-vert"></div>

                    <div class="minimal-auth-col-right">
                        <h3 class="minimal-auth-col-heading">Already a Guest? Login</h3>
                        <p class="minimal-auth-col-sub">Access your bookings and account</p>

                        <div class="minimal-auth-card">

                            <x-forms.post :action="route('frontend.auth.login')">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <div class="input-wrapper">
                                        <i class="fa fa-envelope"></i>
                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}"
                                            placeholder="you@example.com"
                                            autocomplete="email"
                                            required
                                            autofocus>
                                    </div>

                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-wrapper">
                                        <i class="fa fa-lock"></i>
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password"
                                            autocomplete="current-password"
                                            required>
                                    </div>

                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            name="remember"
                                            class="custom-control-input"
                                            id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="login-button">
                                    Sign In
                                </button>
                            </x-forms.post>

                            <div class="minimal-auth-divider">Need help?</div>

                            <div class="minimal-auth-links">
                                <a href="{{ route('frontend.auth.password.request') }}">Forgot password?</a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection