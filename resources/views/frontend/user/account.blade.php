@extends('frontend.layouts.app')

@section('title', __('My Account'))

@push('after-styles')
    <style>
        /* HOTEL LUXURA: MY ACCOUNT (page-scoped) */
        .ac {
            --gold: #b99765;
            --gold-d: #8a6a47;
            --ink: #26231e;
            --mute: #7a746a;
            --line: #e9e2d6;
            --bg: #f6f3ec;
            background: var(--bg);
            color: var(--ink);
            font-family: 'Jost', sans-serif;
            padding-bottom: 90px;
        }

        .ac * {
            box-sizing: border-box;
        }

        .ac-wrap {
            width: min(1140px, calc(100% - 40px));
            margin: auto;
        }

        /* Cover + profile header */
        .ac-cover {
            height: 200px;
            background: radial-gradient(circle at 85% 0%, rgba(185, 151, 101, .45), transparent 55%), linear-gradient(120deg, #2b2621, #4b3a28 60%, #6b5436);
        }

        .ac-head {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-top: -72px;
            padding: 26px 30px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(43, 38, 33, .09);
        }

        .ac-avatar {
            flex: 0 0 96px;
            width: 96px;
            height: 96px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #d3b784, #a98650);
            color: #2b2621;
            font: 700 34px 'Playfair Display', serif;
            box-shadow: 0 0 0 5px #fff, 0 0 0 6px var(--line);
        }

        .ac-who {
            flex: 1;
            min-width: 0;
        }

        .ac-who h1 {
            margin: 0 0 4px;
            font: 700 30px/1.2 'Playfair Display', serif;
            word-break: break-word;
        }

        .ac-who p {
            margin: 0;
            color: var(--mute);
            font-size: 15px;
            word-break: break-all;
        }

        .ac-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .ac-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border-radius: 30px;
            background: #f6efe1;
            color: var(--gold-d);
            font-size: 12px;
            font-weight: 600;
        }

        .ac-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ac-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 10px;
            border: 1px solid var(--ink);
            background: var(--ink);
            color: #fff !important;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
            transition: .2s;
        }

        .ac-btn:hover {
            background: var(--gold-d);
            border-color: var(--gold-d);
        }

        .ac-btn.ghost {
            background: #fff;
            color: var(--ink) !important;
            border-color: var(--line);
        }

        .ac-btn.ghost:hover {
            border-color: var(--gold);
            background: #fff;
        }

        .ac-badge {
            min-width: 20px;
            padding: 1px 6px;
            border-radius: 20px;
            background: var(--gold);
            color: #fff;
            font-size: 11px;
            text-align: center;
        }

        /* Grid */
        .ac-grid {
            display: grid;
            grid-template-columns: 290px minmax(0, 1fr);
            gap: 24px;
            margin-top: 24px;
            align-items: start;
        }

        .ac-side {
            position: sticky;
            top: 20px;
            display: grid;
            gap: 18px;
        }

        .ac-box {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 12px;
        }

        .ac-box h6 {
            margin: 6px 12px 10px;
            color: var(--mute);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        /* Menu (tabs) */
        .ac .nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin: 0;
            padding: 0;
            border: 0;
        }

        .ac .nav .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border: 0 !important;
            border-radius: 10px !important;
            background: transparent !important;
            color: #5d574d;
            font-size: 15px;
            font-weight: 500;
            text-align: left;
            transition: background .2s, color .2s;
        }

        .ac .nav .nav-link::before {
            font-family: 'Font Awesome 5 Free', 'Font Awesome 6 Free';
            font-weight: 900;
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            background: #f3eee3;
            color: var(--gold-d);
            font-size: 14px;
            transition: .2s;
        }

        #my-profile-tab::before {
            content: "\f007";
        }

        #information-tab::before {
            content: "\f4ff";
        }

        #password-tab::before {
            content: "\f023";
        }

        #two-factor-authentication-tab::before {
            content: "\f3ed";
        }

        .ac .nav .nav-link:hover {
            background: #faf7f0 !important;
            color: var(--ink);
        }

        .ac .nav .nav-link.active {
            background: #f6efe1 !important;
            color: var(--ink);
            font-weight: 700;
        }

        .ac .nav .nav-link.active::before {
            background: var(--gold);
            color: #fff;
        }

        .ac .nav .nav-link:focus-visible,
        .ac-help a:focus-visible,
        .ac-btn:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 2px;
        }

        .ac-help {
            padding: 18px;
            background: linear-gradient(140deg, #2b2621, #4b3a28);
            border: 0;
            color: #fff;
        }

        .ac-help b {
            display: block;
            margin-bottom: 6px;
            font: 700 18px 'Playfair Display', serif;
        }

        .ac-help p {
            margin: 0 0 14px;
            color: #d8cdb9;
            font-size: 14px;
            line-height: 1.6;
        }

        .ac-help a {
            display: inline-block;
            padding: 9px 16px;
            border-radius: 8px;
            background: var(--gold);
            color: #2b2621 !important;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
        }

        /* Main panel */
        .ac-main {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 20px;
            min-width: 0;
            overflow: hidden;
        }

        .ac-main-head {
            padding: 28px 36px 22px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #fffdf9, #fff);
        }

        .ac-main-head h2 {
            margin: 0 0 4px;
            font: 700 26px 'Playfair Display', serif;
        }

        .ac-main-head p {
            margin: 0;
            color: var(--mute);
            font-size: 15px;
        }

        .ac-content {
            padding: 32px 36px 40px;
        }

        .ac .tab-pane {
            min-width: 0;
            padding-top: 0 !important;
            outline: none;
        }

        .ac .tab-pane.active.show {
            animation: acIn .3s ease both;
        }

        @keyframes acIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .ac-content h1,
        .ac-content h2,
        .ac-content h3,
        .ac-content h4,
        .ac-content h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--ink);
        }

        .ac-content hr {
            border-color: var(--line);
        }

        .ac img {
            max-width: 100%;
            height: auto;
        }

        /* Forms inside tabs */
        .ac .form-group {
            margin-bottom: 22px;
        }

        .ac label {
            display: inline-block;
            margin-bottom: 8px;
            color: #6d665b;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .ac .form-control,
        .ac select.form-control,
        .ac textarea.form-control {
            min-height: 48px;
            padding: 12px 15px;
            border: 1px solid #e5ded2;
            border-radius: 10px;
            background: #fcfbf8;
            color: #282923;
            font: 15px 'Jost', sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }

        .ac .form-control:hover {
            border-color: #d5c7ae;
        }

        .ac .form-control:focus {
            border-color: var(--gold);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(185, 151, 101, .14);
            outline: none;
        }

        .ac .form-control::placeholder {
            color: #aaa397;
        }

        .ac .tab-content .btn-primary,
        .ac .tab-content button[type="submit"] {
            min-height: 46px;
            padding: 12px 28px;
            border: 1px solid var(--ink);
            border-radius: 10px;
            background: var(--ink);
            color: #fff;
            font: 700 13px 'Jost', sans-serif;
            letter-spacing: .6px;
            transition: .2s;
        }

        .ac .tab-content .btn-primary:hover,
        .ac .tab-content button[type="submit"]:hover {
            background: var(--gold-d);
            border-color: var(--gold-d);
            transform: translateY(-1px);
        }

        .ac .alert {
            border: 1px solid #e9dfcd;
            border-radius: 10px;
        }

        .ac .table-responsive {
            overflow-x: auto;
        }

        .ac .table th {
            color: #777064;
            font-size: 12px;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        @media (max-width:900px) {
            .ac-cover {
                height: 150px;
            }

            .ac-head {
                flex-direction: column;
                text-align: center;
                margin-top: -60px;
                padding: 22px 20px;
            }

            .ac-chips,
            .ac-actions {
                justify-content: center;
            }

            .ac-grid {
                grid-template-columns: minmax(0, 1fr);
                gap: 16px;
            }

            .ac-side {
                position: static;
            }

            .ac-help {
                display: none;
            }

            .ac-box h6 {
                display: none;
            }

            .ac .nav {
                flex-direction: row;
                overflow-x: auto;
                gap: 6px;
                scrollbar-width: thin;
            }

            .ac .nav .nav-link {
                flex: 0 0 auto;
                white-space: nowrap;
                padding: 10px 14px;
                font-size: 14px;
            }

            .ac .nav .nav-link::before {
                display: none;
            }

            .ac-main-head {
                padding: 22px 20px 18px;
            }

            .ac-content {
                padding: 24px 20px 30px;
            }
        }

        @media (prefers-reduced-motion:reduce) {
            .ac * {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $uName = trim((string) $logged_in_user->name);
        $initials = collect(preg_split('/\s+/', $uName ?: 'Guest'))->take(2)
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');

        $inqUnread = 0;
        if (class_exists(\App\Models\Inquiry::class)) {
            $inqUnread = \App\Models\Inquiry::where('email', $logged_in_user->email)->unreadReply()->count();
        }
    @endphp

    <div class="ac">

        <div class="ac-cover"></div>

        <div class="ac-wrap">

            {{-- Profile header --}}
            <header class="ac-head">
                <span class="ac-avatar" aria-hidden="true">{{ $initials }}</span>

                <div class="ac-who">
                    <h1>{{ $uName ?: __('Guest') }}</h1>
                    <p>{{ $logged_in_user->email }}</p>
                    <div class="ac-chips">
                        @if($logged_in_user->created_at)
                            <span class="ac-chip"><i class="fas fa-calendar-check"></i> {{ __('Member since') }}
                                {{ $logged_in_user->created_at->format('M Y') }}</span>
                        @endif
                        <span class="ac-chip"><i class="fas fa-shield-alt"></i>
                            {{ $logged_in_user->isSocial() ? __('Social login') : __('Email login') }}</span>
                    </div>
                </div>

                <div class="ac-actions">
                    @if(Route::has('frontend.frontend.inquiries.index'))
                        <a href="{{ route('frontend.frontend.inquiries.index') }}" class="ac-btn ghost">
                            <i class="fas fa-envelope"></i> {{ __('My Inquiries') }}
                            @if($inqUnread > 0)<span class="ac-badge">{{ $inqUnread }}</span>@endif
                        </a>
                    @endif
                    @if(Route::has('frontend.room.index'))
                        <a href="{{ route('frontend.room.index') }}" class="ac-btn"><i class="fas fa-bed"></i>
                            {{ __('Browse rooms') }}</a>
                    @endif
                </div>
            </header>

            <div class="ac-grid">

                {{-- Left: settings menu (same tabs) --}}
                <aside class="ac-side">
                    <nav class="ac-box" aria-label="Account settings">
                        <h6>{{ __('Settings') }}</h6>
                        <div class="nav" id="nav-tab" role="tablist">

                            <x-utils.link :text="__('My Profile')" class="nav-link active" id="my-profile-tab"
                                data-toggle="pill" href="#my-profile" role="tab" aria-controls="my-profile"
                                aria-selected="true" />

                            <x-utils.link :text="__('Edit Information')" class="nav-link" id="information-tab"
                                data-toggle="pill" href="#information" role="tab" aria-controls="information"
                                aria-selected="false" />

                            @if (!$logged_in_user->isSocial())
                                <x-utils.link :text="__('Password')" class="nav-link" id="password-tab" data-toggle="pill"
                                    href="#password" role="tab" aria-controls="password" aria-selected="false" />
                            @endif

                            <x-utils.link :text="__('Two Factor Authentication')" class="nav-link"
                                id="two-factor-authentication-tab" data-toggle="pill" href="#two-factor-authentication"
                                role="tab" aria-controls="two-factor-authentication" aria-selected="false" />
                        </div>
                    </nav>

                    @if(Route::has('frontend.contact'))
                        <div class="ac-box ac-help">
                            <b>{{ __('Need help?') }}</b>
                            <p>{{ __('Questions about your stay or account? Our team replies quickly.') }}</p>
                            <a href="{{ route('frontend.contact') }}">{{ __('Contact the hotel') }}</a>
                        </div>
                    @endif
                </aside>

                {{-- Right: content --}}
                <main class="ac-main">
                    <div class="ac-main-head">
                        <h2 id="acTitle">{{ __('My Profile') }}</h2>
                        <p id="acDesc">{{ __('Your personal details and account overview.') }}</p>
                    </div>

                    <div class="ac-content">
                        <div class="tab-content" id="my-profile-tabsContent">

                            <div class="tab-pane fade show active" id="my-profile" role="tabpanel"
                                aria-labelledby="my-profile-tab">
                                @include('frontend.user.account.tabs.profile')
                            </div>

                            <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                                @include('frontend.user.account.tabs.information')
                            </div>

                            @if (!$logged_in_user->isSocial())
                                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                    @include('frontend.user.account.tabs.password')
                                </div>
                            @endif

                            <div class="tab-pane fade" id="two-factor-authentication" role="tabpanel"
                                aria-labelledby="two-factor-authentication-tab">
                                @include('frontend.user.account.tabs.two-factor-authentication')
                            </div>

                        </div>
                    </div>
                </main>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const info = {
                'my-profile-tab': ['My Profile', 'Your personal details and account overview.'],
                'information-tab': ['Edit Information', 'Update your name and contact details.'],
                'password-tab': ['Password', 'Change your password to keep your account secure.'],
                'two-factor-authentication-tab': ['Two Factor Authentication', 'Add an extra layer of security to your account.']
            };
            const title = document.getElementById('acTitle');
            const desc = document.getElementById('acDesc');

            document.querySelectorAll('#nav-tab .nav-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    const t = info[link.id];
                    if (t) { title.textContent = t[0]; desc.textContent = t[1]; }
                    history.replaceState(null, '', link.getAttribute('href'));
                });
            });

            // Direct link, e.g. /account#password opens that tab
            const target = location.hash && document.querySelector('#nav-tab a[href="' + location.hash + '"]');
            if (target) target.click();
        });
    </script>
@endpush