@extends('frontend.layouts.app')

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

        .login-page {
            display: flex;
            align-items: center;
            min-height: 100vh;
            padding: 35px 15px;
            background:
                radial-gradient(circle at top right, rgba(169, 130, 92, 0.14), transparent 32%),
                linear-gradient(135deg, #f7f2ea 0%, #fdfaf4 100%);
        }

        .login-shell {
            display: grid;
            grid-template-columns: minmax(320px, 0.9fr) minmax(400px, 1.1fr);
            width: min(100%, 1060px);
            margin: auto;
            overflow: hidden;
            background: #fffdfa;
            border-radius: 18px;
            box-shadow: 0 24px 70px rgba(43, 38, 33, 0.14);
        }

        .login-showcase {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 620px;
            padding: 55px 48px;
            color: #fffdfa;
            background:
                linear-gradient(180deg, rgba(43,38,33,.65) 0%, rgba(43,38,33,.88) 100%),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900') center/cover no-repeat;
            overflow: hidden;
        }

        .login-showcase::before,
        .login-showcase::after {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            content: "";
        }

        .login-showcase::before {
            width: 390px;
            height: 390px;
            top: -190px;
            right: -170px;
        }

        .login-showcase::after {
            width: 280px;
            height: 280px;
            bottom: -140px;
            left: -110px;
        }

        .hotel-brand,
        .showcase-content,
        .showcase-footer {
            position: relative;
            z-index: 1;
        }

        .hotel-brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        .hotel-brand-icon {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            color: var(--hotel-navy);
            background: #fffdfa;
            border-radius: 12px;
        }

        .showcase-content h1 {
            max-width: 330px;
            margin: 0 0 18px;
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 700;
            line-height: 1.2;
        }

        .showcase-content p {
            max-width: 340px;
            margin: 0;
            color: #e8dcc8;
            font-size: 16px;
            line-height: 1.7;
        }

        .showcase-footer {
            display: flex;
            gap: 10px;
            align-items: center;
            color: #d9c4a5;
            font-size: 13px;
            font-weight: 600;
        }

        .login-form-area {
            display: flex;
            align-items: center;
            padding: 55px 70px;
        }

        .login-form {
            width: 100%;
            max-width: 410px;
            margin: auto;
        }

        .form-eyebrow {
            margin-bottom: 12px;
            color: var(--hotel-gold);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .login-form h2 {
            margin: 0;
            color: var(--hotel-navy-dark);
            font-size: 30px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        .login-form .form-intro {
            margin: 11px 0 30px;
            color: var(--hotel-muted);
            font-size: 15px;
            line-height: 1.6;
        }

        .login-form label {
            margin-bottom: 8px;
            color: var(--hotel-text);
            font-size: 14px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            top: 50%;
            left: 16px;
            color: #a89b87;
            transform: translateY(-50%);
        }

        .login-form .form-control {
            height: 52px;
            padding-left: 45px;
            color: var(--hotel-text);
            border: 1px solid #e5dccb;
            border-radius: 9px;
            box-shadow: none;
        }

        .login-form .form-control:focus {
            border-color: var(--hotel-gold);
            box-shadow: 0 0 0 3px rgba(169, 130, 92, 0.15);
        }

        .login-form .custom-control-label {
            padding-top: 1px;
            color: var(--hotel-muted);
            cursor: pointer;
            font-size: 14px;
            font-weight: 400;
        }

        .login-form .custom-control-input:checked ~ .custom-control-label::before {
            border-color: var(--hotel-navy);
            background-color: var(--hotel-navy);
        }

        .login-button {
            width: 100%;
            height: 52px;
            margin-top: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            background: var(--hotel-gold);
            border: 0;
            border-radius: 9px;
            box-shadow: 0 9px 18px rgba(169, 130, 92, 0.25);
            transition: all 0.2s ease;
        }

        .login-button:hover,
        .login-button:focus {
            color: #fff;
            background: #8a6844;
            transform: translateY(-2px);
        }

        .login-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 27px 0 20px;
            color: var(--hotel-muted);
            font-size: 12px;
        }

        .login-divider::before,
        .login-divider::after {
            flex: 1;
            height: 1px;
            content: "";
            background: #eee2d0;
        }

        .login-links {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            font-size: 14px;
        }

        .login-links a {
            color: var(--hotel-gold);
            font-weight: 600;
            text-decoration: none;
        }

        .login-links a:hover {
            color: var(--hotel-navy-dark);
            text-decoration: underline;
        }

        @media (max-width: 820px) {
            .login-shell {
                grid-template-columns: 1fr;
                max-width: 540px;
            }

            .login-showcase {
                min-height: auto;
                padding: 34px;
            }

            .showcase-content {
                margin: 50px 0 15px;
            }

            .showcase-content h1 {
                font-size: 32px;
            }

            .login-form-area {
                padding: 42px 34px;
            }
        }

        @media (max-width: 420px) {
            .login-page {
                padding: 0;
            }

            .login-shell {
                min-height: 100vh;
                border-radius: 0;
            }

            .login-showcase {
                padding: 25px;
            }

            .login-form-area {
                padding: 35px 25px;
            }

            .login-links {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="login-page">
        <div class="login-shell">
            <aside class="login-showcase">
                <div class="hotel-brand">
                    <span class="hotel-brand-icon">
                        <i class="fa fa-building"></i>
                    </span>
                    <span>{{ appName() }}</span>
                </div>

                <div class="showcase-content">
                    <h1>Hospitality begins with great service.</h1>
                    <p>
                        Sign in to manage reservations, rooms, and guest experiences from one secure workspace.
                    </p>
                </div>

                <div class="showcase-footer">
                    <i class="fa fa-shield"></i>
                    Secure hotel management platform
                </div>
            </aside>

            <section class="login-form-area">
                <div class="login-form">
                    <div class="form-eyebrow">Welcome back</div>
                    <h2>Sign in to your account</h2>
                    <p class="form-intro">
                        Enter your details below to continue to your hotel dashboard.
                    </p>

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
                                    Remember me on this device
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="login-button">
                            Sign In <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </x-forms.post>

                    <div class="login-divider">Need help?</div>

                    <div class="login-links">
                        <a href="{{ route('frontend.auth.password.request') }}">Forgot password?</a>

                        @if (config('boilerplate.access.user.registration'))
                            <a href="{{ route('frontend.auth.register') }}">Create an account</a>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection