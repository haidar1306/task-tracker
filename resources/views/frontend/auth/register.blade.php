@extends('frontend.layouts.app')

@section('title', __('Register'))

@push('after-styles')
    <style>
        :root {
            --hotel-navy: #102a43;
            --hotel-navy-dark: #071d32;
            --hotel-gold: #d69e2e;
            --hotel-text: #334e68;
            --hotel-muted: #627d98;
        }

        body {
            background: #f4f7fb;
        }

        .register-page {
            display: flex;
            align-items: center;
            min-height: 100vh;
            padding: 35px 15px;
            background:
                radial-gradient(circle at top left, rgba(214, 158, 46, 0.16), transparent 30%),
                linear-gradient(135deg, #eef4f9 0%, #f8fafc 100%);
        }

        .register-shell {
            display: grid;
            grid-template-columns: minmax(320px, 0.85fr) minmax(440px, 1.15fr);
            width: min(100%, 1120px);
            margin: auto;
            overflow: hidden;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 24px 70px rgba(16, 42, 67, 0.16);
        }

        .register-showcase {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 710px;
            padding: 55px 48px;
            color: #fff;
            background: linear-gradient(145deg, var(--hotel-navy), #1b527e);
            overflow: hidden;
        }

        .register-showcase::before,
        .register-showcase::after {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 50%;
            content: "";
        }

        .register-showcase::before {
            width: 390px;
            height: 390px;
            top: -185px;
            right: -185px;
        }

        .register-showcase::after {
            width: 300px;
            height: 300px;
            bottom: -155px;
            left: -135px;
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
        }

        .hotel-brand-icon {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            color: var(--hotel-navy);
            background: #fff;
            border-radius: 12px;
        }

        .showcase-content h1 {
            max-width: 340px;
            margin: 0 0 18px;
            font-family: Georgia, serif;
            font-size: 41px;
            font-weight: 700;
            line-height: 1.15;
        }

        .showcase-content > p {
            max-width: 340px;
            margin: 0 0 28px;
            color: #d5e4f1;
            font-size: 16px;
            line-height: 1.7;
        }

        .benefit-list {
            display: grid;
            gap: 14px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #e5eef7;
            font-size: 14px;
        }

        .benefit-item i {
            display: grid;
            width: 24px;
            height: 24px;
            place-items: center;
            color: #f6e6b8;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
        }

        .showcase-footer {
            display: flex;
            gap: 10px;
            align-items: center;
            color: #f6e6b8;
            font-size: 13px;
            font-weight: 600;
        }

        .register-form-area {
            display: flex;
            align-items: center;
            padding: 50px 70px;
        }

        .register-form {
            width: 100%;
            max-width: 440px;
            margin: auto;
        }

        .form-eyebrow {
            margin-bottom: 12px;
            color: #a26f09;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .register-form h2 {
            margin: 0;
            color: var(--hotel-navy);
            font-size: 29px;
            font-weight: 700;
        }

        .form-intro {
            margin: 10px 0 27px;
            color: var(--hotel-muted);
            font-size: 15px;
            line-height: 1.6;
        }

        .register-form label {
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
            color: #829ab1;
            transform: translateY(-50%);
        }

        .register-form .form-control {
            height: 50px;
            padding-left: 45px;
            color: var(--hotel-text);
            border: 1px solid #d9e2ec;
            border-radius: 9px;
            box-shadow: none;
        }

        .register-form .form-control:focus {
            border-color: var(--hotel-gold);
            box-shadow: 0 0 0 3px rgba(214, 158, 46, 0.15);
        }

        .register-form .form-check {
            padding-left: 1.45rem;
        }

        .register-form .form-check-input {
            margin-top: 0.3rem;
        }

        .register-form .form-check-label {
            margin: 0;
            color: var(--hotel-muted);
            font-size: 13px;
            font-weight: 400;
            line-height: 1.5;
        }

        .register-form .form-check-label a {
            color: #a26f09;
            font-weight: 600;
            text-decoration: none;
        }

        .register-form .form-check-label a:hover {
            text-decoration: underline;
        }

        .register-button {
            width: 100%;
            height: 52px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            background: var(--hotel-navy);
            border: 0;
            border-radius: 9px;
            box-shadow: 0 9px 18px rgba(16, 42, 67, 0.17);
            transition: all 0.2s ease;
        }

        .register-button:hover,
        .register-button:focus {
            color: #fff;
            background: var(--hotel-navy-dark);
            transform: translateY(-2px);
        }

        .form-footer {
            margin-top: 25px;
            color: var(--hotel-muted);
            font-size: 14px;
            text-align: center;
        }

        .form-footer a {
            color: #a26f09;
            font-weight: 700;
            text-decoration: none;
        }

        .form-footer a:hover {
            color: var(--hotel-navy);
            text-decoration: underline;
        }

        @media (max-width: 820px) {
            .register-shell {
                grid-template-columns: 1fr;
                max-width: 540px;
            }

            .register-showcase {
                min-height: auto;
                padding: 34px;
            }

            .showcase-content {
                margin: 50px 0 15px;
            }

            .showcase-content h1 {
                font-size: 32px;
            }

            .register-form-area {
                padding: 42px 34px;
            }
        }

        @media (max-width: 420px) {
            .register-page {
                padding: 0;
            }

            .register-shell {
                border-radius: 0;
            }

            .register-showcase {
                padding: 25px;
            }

            .register-form-area {
                padding: 35px 25px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="register-page">
        <div class="register-shell">
            <aside class="register-showcase">
                <div class="hotel-brand">
                    <span class="hotel-brand-icon">
                        <i class="fa fa-building"></i>
                    </span>
                    <span>{{ appName() }}</span>
                </div>

                <div class="showcase-content">
                    <h1>Build better stays, from day one.</h1>

                    <p>
                        Create your account and bring your hotel operations into one simple, secure workspace.
                    </p>

                    <div class="benefit-list">
                        <div class="benefit-item">
                            <i class="fa fa-check"></i>
                            Manage reservations with confidence
                        </div>

                        <div class="benefit-item">
                            <i class="fa fa-check"></i>
                            Keep guest information organised
                        </div>

                        <div class="benefit-item">
                            <i class="fa fa-check"></i>
                            Coordinate rooms and daily operations
                        </div>
                    </div>
                </div>

                <div class="showcase-footer">
                    <i class="fa fa-shield"></i>
                    Your information is protected and secure
                </div>
            </aside>

            <section class="register-form-area">
                <div class="register-form">
                    <div class="form-eyebrow">Get started</div>
                    <h2>Create your account</h2>
                    <p class="form-intro">
                        Fill in your details below to join {{ appName() }}.
                    </p>

                    <x-forms.post :action="route('frontend.auth.register')">
                        <div class="form-group">
                            <label for="name">@lang('Full Name')</label>
                            <div class="input-wrapper">
                                <i class="fa fa-user"></i>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    maxlength="100"
                                    required
                                    autofocus
                                    autocomplete="name">
                            </div>

                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">@lang('Email Address')</label>
                            <div class="input-wrapper">
                                <i class="fa fa-envelope"></i>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    maxlength="255"
                                    required
                                    autocomplete="email">
                            </div>

                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
    <label>Phone Number</label>

    <input type="text"
           name="phone"
           class="form-control"
           value="{{ old('phone') }}"
           required>

    @error('phone')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
                        

                        <div class="form-group">
                            <label for="password">@lang('Password')</label>
                            <div class="input-wrapper">
                                <i class="fa fa-lock"></i>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Create a secure password"
                                    maxlength="100"
                                    required
                                    autocomplete="new-password">
                            </div>

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">@lang('Confirm Password')</label>
                            <div class="input-wrapper">
                                <i class="fa fa-lock"></i>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Re-enter your password"
                                    maxlength="100"
                                    required
                                    autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    name="terms"
                                    value="1"
                                    id="terms"
                                    class="form-check-input @error('terms') is-invalid @enderror"
                                    {{ old('terms') ? 'checked' : '' }}
                                    required>

                                <label class="form-check-label" for="terms">
                                    @lang('I agree to the')
                                    <a href="{{ route('frontend.pages.terms') }}" target="_blank" rel="noopener">
                                        @lang('Terms & Conditions')
                                    </a>
                                </label>
                            </div>

                            @error('terms')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (config('boilerplate.access.captcha.registration'))
                            <div class="form-group">
                                @captcha
                                <input type="hidden" name="captcha_status" value="true">
                            </div>
                        @endif

                        <button class="register-button" type="submit">
                            Create Account <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </x-forms.post>

                    <div class="form-footer">
                        Already have an account?
                        <a href="{{ route('frontend.auth.login') }}">Sign in</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection