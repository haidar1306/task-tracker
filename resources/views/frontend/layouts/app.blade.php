<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')
    @stack('before-styles')

    <!-- Frontend CSS -->
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- User Dashboard CSS -->
    <link href="{{ asset('css/frontend/user-dashboard.css') }}" rel="stylesheet">

    <livewire:styles />

    <style>
        :root {
            --hotel-bg: #edf2f0;
            --hotel-surface: #ffffff;
            --hotel-panel: #eef5f4;
            --hotel-dark: #111827;
            --hotel-text: #1f2937;
            --hotel-muted: #6b7280;
            --hotel-gold: #d4af37;
            --hotel-gold-dark: #b8921f;
            --hotel-success: #1f9d5a;
            --hotel-danger: #dc3545;
        }

        body {
            background: var(--hotel-bg);
            color: var(--hotel-text);
            font-family: 'Segoe UI', sans-serif;
        }

        .frontend-content {
            background: var(--hotel-bg);
        }

        .hotel-section {
            padding: 80px 0;
        }

        .hotel-card {
            background: var(--hotel-surface);
            border: 1px solid rgba(17, 24, 39, 0.06);
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .hotel-title {
            font-size: clamp(2.2rem, 5vw, 4rem);
            font-weight: 800;
            color: var(--hotel-dark);
            letter-spacing: -0.04em;
            margin-bottom: 30px;
        }

        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            width: min(360px, calc(100vw - 30px));
            z-index: 9999;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 18px;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
            background: #fff;
            border-left: 6px solid #28a745;
            animation: slideInRight 0.25s ease;
        }

        .custom-alert.error-alert {
            border-left-color: #dc3545;
        }

        .custom-alert.warning-alert {
            border-left-color: #ffc107;
        }

        .custom-alert-content {
            flex: 1;
        }

        .custom-alert-content strong {
            display: block;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .custom-alert-content p {
            margin: 0;
            font-size: 14px;
            line-height: 1.4;
        }

        .toast-close {
            border: none;
            background: transparent;
            color: #555;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            padding: 0;
            margin-left: 6px;
        }

        .toast-close:hover {
            color: #000;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    @stack('after-styles')
    <link href="{{ asset('css/frontendd/navbar.css') }}" rel="stylesheet">
</head>

@php $navMode = trim($__env->yieldContent('navbar_mode')) ?: 'overlay'; @endphp

<body class="frontend-shell lx-{{ $navMode }} {{ request()->routeIs('frontend.index', 'frontend.hotel.dashboard') ? 'frontend-dark-hero' : '' }} {{ request()->routeIs('frontend.index', 'frontend.user.dashboard', 'frontend.room.index', 'frontend.amenities.index', 'frontend.about', 'frontend.reservation.index', 'frontend.contact', 'frontend.auth.login', 'frontend.auth.register', 'frontend.services', 'frontend.gallery', 'frontend.offers', 'frontend.hotel-updates', 'frontend.services.show', 'frontend.room.show','frontend.bookings.create','frontend.user.account') ? 'home-page' : '' }} {{ request()->routeIs('frontend.room.index') ? 'room-search-results' : '' }} {{ request()->routeIs('frontend.payment.create') ? 'frontend-standalone-payment' : '' }}">

    @include('frontend.layouts.navbar')

    <main class="frontend-content">

        @include('includes.partials.messages')
        @include('frontend.components.alerts')
        @yield('content')
    </main>

    @include('frontend.layouts.footer')

    @stack('before-scripts')

    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>

    <livewire:scripts />

    @stack('after-scripts')
    <script>

        function closeAlert(button) {
            const alert = button ? button.closest('.custom-alert') : document.querySelector('.custom-alert');

            if (alert) {
                alert.remove();
            }
        }

        document.addEventListener('click', function (event) {
            const closeButton = event.target.closest('.toast-close');

            if (!closeButton) {
                return;
            }

            const toast = closeButton.closest('.global-toast');

            if (toast) {
                toast.remove();
            }
        });

        setTimeout(function () {
            document.querySelectorAll('.custom-alert').forEach(function (alert) {
                alert.remove();
            });
        }, 5000);

        setTimeout(function () {
            document.querySelectorAll('.global-toast').forEach(function (toast) {
                toast.remove();
            });
        }, 5000);

    </script>
    <script>
        (function () {
            var nav = document.getElementById('lxNav');
            if (!nav) return;
            var solid = nav.dataset.mode === 'solid';
            function update() { nav.classList.toggle('is-pill', solid || window.scrollY > 40); }
            update();
            window.addEventListener('scroll', update, { passive: true });
            if (window.jQuery) {
                jQuery('#navbarNav')
                    .on('show.bs.collapse', function () { nav.classList.add('menu-open'); })
                    .on('hidden.bs.collapse', function () { nav.classList.remove('menu-open'); });
            }
        })();
    </script>

</body>

</html>