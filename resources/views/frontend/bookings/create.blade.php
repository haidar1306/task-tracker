@extends('frontend.layouts.app')

@section('title', 'Create Reservation')

@push('after-styles')

    <style>
        /* =========================================================
                   LUXURA RESERVATION EXPERIENCE
                   Completely independent booking-page design
                ========================================================= */

        .reservation-page {
            min-height: calc(100vh - 70px);
            background: #e9e7e2;
            padding: 42px 38px 70px;
        }

        .reservation-shell {
            width: 100%;
            max-width: 1380px;
            min-height: 700px;
            margin: 0 auto;

            display: grid;
            grid-template-columns: 1.08fr .92fr;

            background: #ffffff;
            overflow: hidden;

            box-shadow:
                0 30px 80px rgba(20, 20, 20, .13);
        }


        /* =========================================================
                   LEFT VISUAL AREA
                ========================================================= */

        .reservation-visual {
            position: relative;
            min-height: 700px;
            overflow: hidden;
            background: #171717;
        }

        .reservation-visual img {
            position: absolute;
            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: transform 1s ease;
        }

        .reservation-shell:hover .reservation-visual img {
            transform: scale(1.025);
        }

        .reservation-visual::after {
            content: "";

            position: absolute;
            inset: 0;

            background:
                linear-gradient(180deg,
                    rgba(0, 0, 0, .08) 0%,
                    rgba(0, 0, 0, .10) 35%,
                    rgba(0, 0, 0, .82) 100%);
        }


        /* Top label */

        .visual-label {
            position: absolute;
            z-index: 4;

            top: 28px;
            left: 30px;

            padding: 9px 13px;

            background: rgba(255, 255, 255, .92);

            color: #252525;

            font-family: 'Jost', sans-serif;
            font-size: 9px;
            font-weight: 700;

            letter-spacing: 1.8px;
            text-transform: uppercase;
        }


        /* Room information */

        .visual-content {
            position: absolute;
            z-index: 4;

            left: 38px;
            right: 38px;
            bottom: 38px;
        }

        .visual-content .room-category {
            margin-bottom: 9px;

            color: rgba(255, 255, 255, .72);

            font-family: 'Jost', sans-serif;
            font-size: 10px;
            font-weight: 600;

            letter-spacing: 2.2px;
            text-transform: uppercase;
        }

        .visual-content h1 {
            max-width: 650px;

            margin: 0 0 13px;

            color: #ffffff;

            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 4vw, 62px);
            font-weight: 400;

            line-height: 1.02;
            letter-spacing: -1.3px;
        }

        .visual-room-info {
            display: flex;
            align-items: center;
            gap: 18px;

            color: rgba(255, 255, 255, .82);

            font-family: 'Jost', sans-serif;
            font-size: 12px;
        }

        .visual-room-info span {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .visual-room-info i {
            color: #ffffff;
            font-size: 11px;
        }


        /* Price floating element */

        .visual-price {
            position: absolute;
            z-index: 5;

            right: 30px;
            bottom: 34px;

            padding: 13px 16px;

            background: rgba(255, 255, 255, .96);

            color: #202020;

            text-align: right;

            font-family: 'Jost', sans-serif;
        }

        .visual-price small {
            display: block;

            margin-bottom: 2px;

            color: #777;

            font-size: 8px;
            font-weight: 600;

            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .visual-price strong {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 500;
        }


        /* =========================================================
                   RIGHT RESERVATION PANEL
                ========================================================= */

        .reservation-panel {
            display: flex;
            flex-direction: column;

            padding: 54px 55px 45px;

            background: #ffffff;
        }


        /* Header */

        .panel-heading {
            margin-bottom: 38px;
        }

        .panel-heading .panel-index {
            display: block;

            margin-bottom: 11px;

            color: #999;

            font-family: 'Jost', sans-serif;
            font-size: 9px;
            font-weight: 700;

            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .panel-heading h2 {
            margin: 0 0 8px;

            color: #1c1c1c;

            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 500;

            line-height: 1.1;
        }

        .panel-heading p {
            max-width: 450px;

            margin: 0;

            color: #858585;

            font-family: 'Jost', sans-serif;
            font-size: 12px;

            line-height: 1.7;
        }


        /* =========================================================
                   FORM
                ========================================================= */

        .reservation-form {
            width: 100%;
        }


        /* Field */

        .reservation-field {
            margin-bottom: 25px;
        }

        .reservation-field label {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 9px;

            color: #343434;

            font-family: 'Jost', sans-serif;
            font-size: 9px;
            font-weight: 700;

            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .reservation-field label span {
            color: #aaa;

            font-size: 8px;
            letter-spacing: .8px;
        }


        /* Date fields */

        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 13px;
        }

        .reservation-input {
            display: block;

            width: 100%;
            height: 58px;

            padding: 0 15px;

            border: 1px solid #dedede;
            border-radius: 0;

            outline: none;

            background: #fafafa;

            color: #202020;

            font-family: 'Jost', sans-serif;
            font-size: 13px;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }

        .reservation-input:hover {
            background: #fff;
            border-color: #bdbdbd;
        }

        .reservation-input:focus {
            background: #fff;

            border-color: #252525;

            box-shadow:
                0 0 0 1px #252525;
        }


        /* Guest boxes */

        .guest-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 13px;
        }

        .guest-box {
            position: relative;
        }

        .guest-box i {
            position: absolute;

            right: 16px;
            top: 50%;

            transform: translateY(-50%);

            color: #999;

            font-size: 11px;

            pointer-events: none;
        }

        .guest-box .reservation-input {
            padding-right: 40px;
        }


        /* =========================================================
                   LIVE SUMMARY
                ========================================================= */

        .reservation-summary {
            margin-top: 4px;
            padding: 22px 20px;

            background: #f5f5f3;
        }

        .summary-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 17px;
        }

        .summary-head span:first-child {
            color: #555;

            font-family: 'Jost', sans-serif;
            font-size: 9px;
            font-weight: 700;

            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .summary-head span:last-child {
            color: #999;

            font-family: 'Jost', sans-serif;
            font-size: 10px;
        }

        .summary-calculation {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }

        .summary-nights {
            color: #777;

            font-family: 'Jost', sans-serif;
            font-size: 11px;
        }

        .summary-nights strong {
            color: #222;
            font-size: 16px;
        }

        .summary-total {
            color: #181818;

            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 500;
        }


        /* =========================================================
                   SUBMIT
                ========================================================= */

        .reservation-submit {
            position: relative;

            width: 100%;
            height: 60px;

            margin-top: 23px;

            border: 0;
            border-radius: 0;

            background: #191919;

            color: #ffffff;

            cursor: pointer;

            overflow: hidden;

            font-family: 'Jost', sans-serif;
            font-size: 10px;
            font-weight: 700;

            letter-spacing: 2px;
            text-transform: uppercase;

            transition: transform .25s ease;
        }

        .reservation-submit::before {
            content: "";

            position: absolute;

            left: -100%;
            top: 0;

            width: 100%;
            height: 100%;

            background: #353535;

            transition: left .35s ease;
        }

        .reservation-submit:hover::before {
            left: 0;
        }

        .reservation-submit:hover {
            transform: translateY(-2px);
        }

        .reservation-submit span {
            position: relative;
            z-index: 2;
        }

        .reservation-submit i {
            position: relative;
            z-index: 2;

            margin-right: 8px;
        }


        /* =========================================================
                   FOOT NOTE
                ========================================================= */

        .reservation-footer {
            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-top: 17px;

            color: #a0a0a0;

            font-family: 'Jost', sans-serif;
            font-size: 9px;
        }

        .reservation-footer i {
            color: #777;
            font-size: 10px;
        }


        /* =========================================================
                   RESPONSIVE
                ========================================================= */

        @media (max-width: 1050px) {

            .reservation-page {
                padding: 25px;
            }

            .reservation-shell {
                grid-template-columns: 1fr;
            }

            .reservation-visual {
                min-height: 480px;
            }

            .reservation-panel {
                padding: 45px;
            }
        }


        @media (max-width: 650px) {

            .reservation-page {
                padding: 0;
            }

            .reservation-shell {
                box-shadow: none;
            }

            .reservation-visual {
                min-height: 420px;
            }

            .visual-label {
                top: 20px;
                left: 20px;
            }

            .visual-content {
                left: 22px;
                right: 22px;
                bottom: 25px;
            }

            .visual-content h1 {
                font-size: 38px;
                padding-right: 80px;
            }

            .visual-price {
                right: 20px;
                bottom: 23px;
            }

            .reservation-panel {
                padding: 38px 21px 40px;
            }

            .panel-heading {
                margin-bottom: 30px;
            }

            .panel-heading h2 {
                font-size: 30px;
            }

            .date-grid,
            .guest-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .reservation-field {
                margin-bottom: 20px;
            }

            .reservation-input {
                height: 55px;
            }
        }

        /* Hide navbar only on Create Booking page */
        body:has(.reservation-page) .hotel-navbar {
            display: none !important;
        }

        /* Remove top spacing created by navbar */
        body:has(.reservation-page) {
            padding-top: 0 !important;
        }

        body:has(.reservation-page) .reservation-page {
            margin-top: 0 !important;
        }

        .reservation-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            margin-top: 15px;

            color: #777;
            text-decoration: none;

            font-family: 'Jost', sans-serif;
            font-size: 10px;
            font-weight: 600;

            letter-spacing: 1.2px;
            text-transform: uppercase;

            transition: .25s ease;
        }

        .reservation-back i {
            font-size: 9px;
        }

        .reservation-back:hover {
            color: #191919;
            transform: translateX(-3px);
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

        /* ==========================================
       REMOVE EXTRA TOP SPACE - RESERVATION PAGE
       ========================================== */

        .frontend-content {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        .reservation-page,
        .booking-page {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        /* Remove layout navbar-space */
        .frontend-content>*:first-child {
            margin-top: 0 !important;
        }

        /* If reservation wrapper has top spacing */
        .reservation-wrapper,
        .booking-wrapper {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
    </style>

@endpush


@section('content')

    <div class="reservation-page">

        <div class="minimal-auth-topbar">
            <a href="{{ route('frontend.index') }}" class="minimal-auth-brand">
                <i class="fa fa-hotel"></i> Hotel Luxura
            </a>
            <a href="{{ route('frontend.room.show', $room->id) }}" class="minimal-auth-close" aria-label="Close">
                <i class="fa fa-times"></i>
            </a>
        </div>


        <div class="reservation-shell">



            {{-- =====================================================
            ROOM VISUAL
            ====================================================== --}}

            <section class="reservation-visual">

                @if($room->image)

                        <img src="{{ Str::startsWith($room->image, ['http://', 'https://'])
                    ? $room->image
                    : asset('storage/' . $room->image) }}" alt="{{ optional($room->roomType)->name }}">

                @elseif(optional($room->roomType)->image)

                        <img src="{{ Str::startsWith($room->roomType->image, ['http://', 'https://'])
                    ? $room->roomType->image
                    : asset('storage/' . $room->roomType->image) }}" alt="{{ optional($room->roomType)->name }}">

                @else

                    <img src="{{ asset('images/default-room.jpg') }}" alt="{{ optional($room->roomType)->name }}">

                @endif


                <div class="visual-label">
                    Hotel Luxura
                </div>


                <div class="visual-content">

                    <div class="room-category">
                        Your selected room
                    </div>

                    <h1>
                        {{ optional($room->roomType)->name }}
                    </h1>

                    <div class="visual-room-info">

                        <span>
                            <i class="fas fa-door-open"></i>
                            Room {{ $room->room_number }}
                        </span>

                        <span>
                            <i class="fas fa-users"></i>
                            {{ optional($room->roomType)->capacity }} Guests
                        </span>

                    </div>

                </div>


                <div class="visual-price">

                    <small>From / night</small>

                    <strong>
                        ₹{{ number_format($room->roomType->price, 2) }}
                    </strong>

                </div>

            </section>



            {{-- =====================================================
            RESERVATION PANEL
            ====================================================== --}}

            <section class="reservation-panel">


                <div class="panel-heading">

                    <span class="panel-index">
                        Reservation 01
                    </span>

                    <h2>
                        Create your stay
                    </h2>

                    <p>
                        Select your dates and number of guests.
                        Your estimated stay total will update automatically.
                    </p>

                </div>


                <form class="reservation-form" action="{{ route('frontend.bookings.store') }}" method="POST">

                    @csrf

                    <input type="hidden" name="room_id" value="{{ $room->id }}">


                    {{-- Dates --}}

                    <div class="reservation-field">

                        <label for="check_in">
                            Stay dates
                            <span>Required</span>
                        </label>


                        <div class="date-grid">

                            <input type="date" name="check_in" id="check_in" class="reservation-input" required>

                            <input type="date" name="check_out" id="check_out" class="reservation-input" required>

                        </div>

                    </div>


                    {{-- Guests --}}

                    <div class="reservation-field">

                        <label>
                            Guests
                            <span>Who is staying?</span>
                        </label>


                        <div class="guest-grid">

                            <div class="guest-box">

                                <input type="number" name="adults" id="adults" class="reservation-input" min="1" value="1"
                                    required placeholder="Adults">

                                <i class="fas fa-user"></i>

                            </div>


                            <div class="guest-box">

                                <input type="number" name="children" id="children" class="reservation-input" min="0"
                                    value="0" placeholder="Children">

                                <i class="fas fa-child"></i>

                            </div>

                        </div>

                    </div>


                    {{-- Summary --}}

                    <div class="reservation-summary">

                        <div class="summary-head">

                            <span>
                                Stay estimate
                            </span>

                            <span>
                                Room {{ $room->room_number }}
                            </span>

                        </div>


                        <div class="summary-calculation">

                            <div class="summary-nights">

                                <strong id="summary-nights">—</strong>

                                <span>
                                    night(s)
                                </span>

                            </div>


                            <div class="summary-total" id="summary-total">
                                ₹0.00
                            </div>

                        </div>

                    </div>


                    {{-- Submit --}}

                    <button type="submit" class="reservation-submit">

                        <i class="fas fa-arrow-right"></i>

                        <span>
                            Confirm Reservation
                        </span>

                    </button>
                    <a href="{{ route('frontend.room.index') }}" class="reservation-back">
                        <i class="fas fa-arrow-left"></i>
                        Back to Rooms
                    </a>


                    <div class="reservation-footer">

                        <i class="fas fa-lock"></i>

                        <span>
                            Secure reservation · Your details remain private
                        </span>

                    </div>

                </form>

            </section>

        </div>

    </div>

@endsection



@push('after-scripts')

    <script>

        const reservationPrice =
                    {{ $room->roomType->price }};

        const arrival =
            document.getElementById('check_in');

        const departure =
            document.getElementById('check_out');

        const nightsOutput =
            document.getElementById('summary-nights');

        const totalOutput =
            document.getElementById('summary-total');


        /* =========================================================
           TODAY
        ========================================================= */

        const now = new Date();

        const today =
            now.getFullYear() +
            '-' +
            String(now.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(now.getDate()).padStart(2, '0');


        arrival.min = today;
        departure.min = today;


        /* =========================================================
           CALCULATE STAY
        ========================================================= */

        function calculateReservation() {

            if (!arrival.value || !departure.value) {

                nightsOutput.textContent = '—';
                totalOutput.textContent = '₹0.00';

                return;
            }


            const start =
                new Date(arrival.value + 'T00:00:00');

            const end =
                new Date(departure.value + 'T00:00:00');


            const difference =
                end.getTime() - start.getTime();


            const nights =
                Math.round(
                    difference / (1000 * 60 * 60 * 24)
                );


            if (nights > 0) {

                nightsOutput.textContent = nights;


                const total =
                    nights * reservationPrice;


                totalOutput.textContent =
                    '₹' +
                    total.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

            } else {

                nightsOutput.textContent = '—';
                totalOutput.textContent = '₹0.00';

            }

        }


        /* =========================================================
           ARRIVAL
        ========================================================= */

        arrival.addEventListener('change', function () {

            if (!this.value) {

                departure.min = today;

                calculateReservation();

                return;
            }


            const next =
                new Date(this.value + 'T00:00:00');


            next.setDate(next.getDate() + 1);


            const nextDate =
                next.getFullYear() +
                '-' +
                String(next.getMonth() + 1).padStart(2, '0') +
                '-' +
                String(next.getDate()).padStart(2, '0');


            departure.min = nextDate;


            if (
                departure.value &&
                departure.value <= this.value
            ) {
                departure.value = '';
            }


            calculateReservation();

        });


        /* =========================================================
           DEPARTURE
        ========================================================= */

        departure.addEventListener(
            'change',
            calculateReservation
        );


        /* =========================================================
           INITIAL
        ========================================================= */

        calculateReservation();

    </script>

@endpush