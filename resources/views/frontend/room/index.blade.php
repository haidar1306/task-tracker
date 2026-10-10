@extends('frontend.layouts.app')

@section('title', 'Available Rooms | Hotel Luxura Palace')

@push('after-styles')
    <style>
        .hotel-search-page {
            --search-ink: #211d18;
            --search-muted: #756d61;
            --search-gold: #b58a30;
            --search-line: #e7e1d7;
            --search-paper: #fff;
            background: #f7f5f1;
            color: var(--search-ink);
            min-height: 100vh;
            padding: 28px 0 72px;
            font-family: 'Jost', sans-serif;
        }

        body.home-page.room-search-results .hotel-navbar .container {
            width: min(1280px, calc(100% - 40px));
            height: 100%;
        }

        .hotel-search-wrap { width: min(1280px, calc(100% - 40px)); margin: 0 auto; }
        .stay-summary { position: relative; background: #211d18; color: #fff; padding: 24px 28px; display: grid; grid-template-columns: minmax(230px, .85fr) minmax(0, 1.4fr); gap: 32px; align-items: center; margin-bottom: 28px; border-left: 3px solid var(--search-gold); }
        .stay-summary-kicker, .results-kicker { color: var(--search-gold); font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; }
        .stay-summary h1 { max-width: 390px; color: #fff; font: 500 28px/1.18 'Playfair Display', serif; margin: 7px 0 14px; }
        .stay-summary-meta { display: flex; flex-wrap: wrap; gap: 8px 0; color: #ded8ce; font-size: 12px; }
        .stay-summary-meta span { padding: 0 13px; border-left: 1px solid #5b5145; }
        .stay-summary-meta span:first-child { padding-left: 0; border-left: 0; }
        .stay-summary-meta strong { color: #fff; font-weight: 600; }
        .stay-edit-form { display: grid; grid-template-columns: repeat(3, minmax(112px, 1fr)) auto; align-items: end; gap: 12px; }
        .stay-edit-form label, .filter-field label { display: block; color: var(--search-muted); font-size: 12px; font-weight: 600; margin-bottom: 5px; }
        .stay-edit-form label { color: #e5dccd; font-size: 11px; }
        .stay-edit-form input, .stay-edit-form select { width: 100%; min-height: 44px; border: 1px solid #6d6255; border-radius: 3px; background: #302b24; color: #fff; padding: 8px 10px; font: 13px 'Jost', sans-serif; color-scheme: dark; }
        .search-action, .filter-submit, .room-action-primary { display: inline-flex; min-height: 40px; align-items: center; justify-content: center; border: 1px solid var(--search-gold); border-radius: 2px; background: var(--search-gold); color: #1d1913; padding: 9px 15px; font: 600 12px 'Jost', sans-serif; text-decoration: none; transition: background .18s ease, border-color .18s ease; cursor: pointer; }
        .stay-edit-form .search-action { min-height: 44px; padding: 9px 19px; white-space: nowrap; }
        .search-action:hover, .filter-submit:hover, .room-action-primary:hover { background: #c49a45; border-color: #c49a45; color: #1d1913; text-decoration: none; }
        .search-results-layout { display: grid; grid-template-columns: 255px minmax(0, 1fr); gap: 24px; align-items: start; }
        .search-filter-panel, .search-results-panel { background: var(--search-paper); border: 1px solid var(--search-line); }
        .search-filter-panel { padding: 19px; position: sticky; top: 18px; }
        .filter-heading-row, .results-heading-row, .room-result-footer, .filter-actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .filter-heading-row h2 { font: 600 17px 'Playfair Display', serif; margin: 0; }
        .text-action { color: #78633a; font-size: 12px; text-decoration: underline; text-underline-offset: 3px; }
        .filter-group { border-top: 1px solid var(--search-line); margin-top: 17px; padding-top: 15px; }
        .filter-group h3 { color: var(--search-ink); font-size: 13px; font-weight: 600; margin: 0 0 11px; }
        .filter-price-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .filter-field input, .filter-field select { width: 100%; min-height: 38px; border: 1px solid #d9d3ca; border-radius: 2px; background: #fff; color: var(--search-ink); padding: 7px 9px; font: 13px 'Jost', sans-serif; }
        .filter-checks { display: grid; gap: 9px; max-height: 210px; overflow: auto; }
        .filter-check { display: flex; align-items: flex-start; gap: 9px; color: #504a42; font-size: 13px; line-height: 1.35; }
        .filter-check input { accent-color: var(--search-gold); margin-top: 3px; }
        .filter-actions { margin-top: 20px; }
        .filter-submit { flex: 1; }
        .results-heading-row { padding: 19px 22px; border-bottom: 1px solid var(--search-line); }
        .results-heading-row h2 { font: 500 24px 'Playfair Display', serif; margin: 3px 0 0; }
        .results-count { color: var(--search-muted); font-size: 13px; margin-top: 4px; }
        .results-sort { display: flex; align-items: center; gap: 8px; color: var(--search-muted); font-size: 12px; white-space: nowrap; }
        .results-sort select { min-height: 38px; border: 1px solid var(--search-line); border-radius: 2px; background: #fff; color: var(--search-ink); padding: 6px 9px; font: 13px 'Jost', sans-serif; }
        .results-cards { padding: 16px; }
        .room-result-card { display: grid; grid-template-columns: 245px minmax(0, 1fr) 180px; min-height: 218px; border: 1px solid var(--search-line); background: #fff; margin-bottom: 14px; transition: border-color .18s ease, box-shadow .18s ease; }
        .room-result-card:last-child { margin-bottom: 0; }
        .room-result-card:hover { border-color: #c6a75d; box-shadow: 0 8px 22px rgba(32, 27, 20, .07); }
        .room-result-image { min-height: 218px; background: #e9e4da; overflow: hidden; }
        .room-result-image img { width: 100%; height: 100%; min-height: 218px; object-fit: cover; display: block; }
        .room-image-placeholder { height: 100%; min-height: 218px; display: grid; place-items: center; background: linear-gradient(135deg, #e9e4da, #d8cdbb); color: #5b5142; text-align: center; padding: 20px; }
        .room-image-placeholder i { display: block; font-size: 27px; margin-bottom: 8px; }
        .room-result-info { padding: 19px 20px; }
        .room-result-title { color: var(--search-ink); font: 600 21px/1.25 'Playfair Display', serif; margin: 0 0 5px; }
        .room-result-number { color: var(--search-muted); font-size: 12px; margin-bottom: 12px; }
        .room-result-description { color: #625b51; font-size: 13px; line-height: 1.6; margin: 0 0 13px; }
        .room-result-facts, .room-result-amenities { display: flex; flex-wrap: wrap; gap: 8px 15px; color: #5d564c; font-size: 12px; }
        .room-result-facts span, .room-result-amenities span { display: inline-flex; align-items: center; gap: 6px; }
        .room-result-facts i, .room-result-amenities i { color: var(--search-gold); }
        .room-result-amenities { margin-top: 12px; }
        .room-result-price { display: flex; align-items: stretch; flex-direction: column; border-left: 1px solid var(--search-line); padding: 18px 16px; text-align: right; }
        .room-availability-label { color: #3f734a; font-size: 11px; font-weight: 600; }
        .room-availability-label.unverified { color: var(--search-muted); }
        .room-nightly-price { color: var(--search-ink); font: 600 22px 'Playfair Display', serif; margin-top: 10px; }
        .room-nightly-price small { color: var(--search-muted); font: 12px 'Jost', sans-serif; }
        .room-total-price { color: var(--search-muted); font-size: 12px; line-height: 1.5; margin: 4px 0 12px; }
        .room-result-footer { margin-top: auto; justify-content: flex-end; flex-wrap: wrap; }
        .room-action-secondary { color: #534733; font-size: 12px; font-weight: 600; text-decoration: underline; text-underline-offset: 3px; }
        .room-action-primary { width: 100%; min-height: 38px; }
        .results-empty { margin: 16px; padding: 42px 24px; border: 1px dashed #d8cdbb; color: var(--search-muted); text-align: center; }
        .results-empty h3 { color: var(--search-ink); font: 500 21px 'Playfair Display', serif; margin: 0 0 8px; }
        .results-empty p { margin: 0 0 15px; }
        .results-pagination { padding: 0 18px 18px; }
        .filter-disclosure > summary { display: none; cursor: pointer; font-weight: 600; list-style: none; }
        .filter-disclosure > summary::-webkit-details-marker { display: none; }

        @media (max-width: 980px) {
            .stay-summary { grid-template-columns: 1fr; gap: 20px; }
            .stay-edit-form { max-width: none; }
            .room-result-card { grid-template-columns: 210px minmax(0, 1fr); }
            .room-result-price { grid-column: 1 / -1; flex-direction: row; align-items: center; text-align: left; border-left: 0; border-top: 1px solid var(--search-line); }
            .room-nightly-price { margin: 0 0 0 auto; }
            .room-total-price { margin: 0 14px; }
            .room-action-primary { width: auto; }
        }

        @media (max-width: 720px) {
            .hotel-search-page { padding-top: 22px; }
            .hotel-search-wrap { width: min(100% - 24px, 620px); }
            body.home-page.room-search-results .hotel-navbar,
            body.home-page.room-search-results .hotel-navbar.scrolled {
                height: 68px !important;
                min-height: 68px;
                padding: 0 16px !important;
            }
            body.home-page.room-search-results .hotel-navbar .container {
                width: 100%;
            }
            .stay-summary { padding: 20px 17px; gap: 18px; }
            .stay-summary h1 { max-width: none; font-size: 23px; }
            .stay-summary-meta { gap: 7px 0; }
            .stay-summary-meta span { padding: 0 9px; }
            .stay-edit-form { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stay-edit-form .search-action { grid-column: 1 / -1; }
            .search-results-layout { grid-template-columns: 1fr; gap: 14px; }
            .search-filter-panel { position: static; padding: 15px; }
            .filter-disclosure > summary { display: flex; justify-content: space-between; align-items: center; }
            .filter-disclosure[open] > summary { padding-bottom: 15px; }
            .filter-disclosure:not([open]) .filter-content { display: none; }
            .results-heading-row { align-items: flex-start; flex-direction: column; padding: 16px; }
            .results-sort { width: 100%; justify-content: space-between; }
            .results-sort select { flex: 1; }
            .results-cards { padding: 10px; }
            .room-result-card { grid-template-columns: 1fr; }
            .room-result-image, .room-result-image img, .room-image-placeholder { min-height: 205px; height: 205px; }
            .room-result-info { padding: 16px; }
            .room-result-price { display: grid; grid-template-columns: 1fr auto; gap: 5px 12px; padding: 14px 16px; }
            .room-availability-label { grid-column: 1 / -1; }
            .room-nightly-price { grid-column: 1; grid-row: 2; margin: 0; }
            .room-total-price { grid-column: 1; grid-row: 3; margin: 0; }
            .room-result-footer { grid-column: 2; grid-row: 2 / 4; flex-direction: column; align-items: stretch; }
            .room-action-primary { width: 100%; }
        }

        @media (max-width: 380px) {
            .stay-edit-form { grid-template-columns: 1fr; }
            .stay-edit-form .search-action { grid-column: auto; }
            .room-result-price { grid-template-columns: 1fr; }
            .room-nightly-price, .room-total-price, .room-result-footer { grid-column: 1; grid-row: auto; }
        }
    </style>
@endpush

@section('content')
    @php
        $checkIn = $search['check_in'] ?? null;
        $checkOut = $search['check_out'] ?? null;
        $guestCount = $search['guests'] ?? 1;
        $hasStayDates = $checkIn && $checkOut;
        $stayQuery = array_filter([
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guests' => $search['guests'] ?? null,
        ], function ($value) { return $value !== null && $value !== ''; });
        $nights = $nights ?: null;
        $minimumPrice = $priceBounds->min_price ?? 0;
        $maximumPrice = $priceBounds->max_price ?? 0;
    @endphp

    <main class="hotel-search-page">
        <div class="hotel-search-wrap">
            <section class="stay-summary" aria-labelledby="stay-summary-title">
                <div>
                    <div class="stay-summary-kicker">Your stay</div>
                    <h1 id="stay-summary-title">Find a room that feels like yours</h1>
                    <div class="stay-summary-meta">
                        @if($checkIn && $checkOut)
                            <span><strong>{{ \Carbon\Carbon::parse($checkIn)->format('D, d M Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($checkOut)->format('D, d M Y') }}</strong></span>
                            <span>{{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}</span>
                        @else
                            <span>Select dates to check room availability</span>
                        @endif
                        <span>{{ $guestCount }} {{ (int) $guestCount === 1 ? 'guest' : 'guests' }}</span>
                        @if($hasStayDates)
                            <span>{{ $availableRoomCount }} available {{ $availableRoomCount === 1 ? 'room' : 'rooms' }}</span>
                        @else
                            <span>{{ $availableRoomCount }} {{ $availableRoomCount === 1 ? 'room' : 'rooms' }} · dates not checked</span>
                        @endif
                    </div>
                </div>

                <form action="{{ route('frontend.room.index') }}" method="GET" class="stay-edit-form" aria-label="Modify stay search">
                    <div>
                        <label for="summary-check-in">Check-in</label>
                        <input id="summary-check-in" type="date" name="check_in" min="{{ today()->toDateString() }}" value="{{ $checkIn }}" required>
                    </div>
                    <div>
                        <label for="summary-check-out">Check-out</label>
                        <input id="summary-check-out" type="date" name="check_out" min="{{ today()->toDateString() }}" value="{{ $checkOut }}" required>
                    </div>
                    <div>
                        <label for="summary-guests">Guests</label>
                        <select id="summary-guests" name="guests">
                            @for($count = 1; $count <= 20; $count++)
                                <option value="{{ $count }}" {{ (int) $guestCount === $count ? 'selected' : '' }}>{{ $count }} {{ $count === 1 ? 'guest' : 'guests' }}</option>
                            @endfor
                        </select>
                    </div>
                    <button class="search-action" type="submit">Update search</button>
                </form>
            </section>

            <form class="search-results-layout" id="room-filters" action="{{ route('frontend.room.index') }}" method="GET">
                @if($checkIn)<input type="hidden" name="check_in" value="{{ $checkIn }}">@endif
                @if($checkOut)<input type="hidden" name="check_out" value="{{ $checkOut }}">@endif
                @if(isset($search['guests']))<input type="hidden" name="guests" value="{{ $search['guests'] }}">@endif

                <aside class="search-filter-panel" aria-label="Room filters">
                    <details class="filter-disclosure" open>
                        <summary>Filter rooms <span aria-hidden="true">⌄</span></summary>
                        <div class="filter-content">
                            <div class="filter-heading-row">
                                <h2>Filters</h2>
                                <a class="text-action" href="{{ route('frontend.room.index', $stayQuery) }}">Clear all</a>
                            </div>

                            <div class="filter-group">
                                <h3>Price per night</h3>
                                <div class="filter-price-grid">
                                    <div class="filter-field">
                                        <label for="price-min">Min ₹</label>
                                        <input id="price-min" type="number" name="price_min" min="0" step="100" placeholder="{{ number_format($minimumPrice, 0) }}" value="{{ $search['price_min'] ?? '' }}">
                                    </div>
                                    <div class="filter-field">
                                        <label for="price-max">Max ₹</label>
                                        <input id="price-max" type="number" name="price_max" min="0" step="100" placeholder="{{ number_format($maximumPrice, 0) }}" value="{{ $search['price_max'] ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            @if($roomTypes->isNotEmpty())
                                <div class="filter-group">
                                    <h3>Room type</h3>
                                    <div class="filter-checks">
                                        @foreach($roomTypes as $roomType)
                                            <label class="filter-check">
                                                <input type="checkbox" name="room_types[]" value="{{ $roomType->id }}" {{ in_array($roomType->id, $search['room_types'] ?? []) ? 'checked' : '' }}>
                                                <span>{{ $roomType->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($capacityOptions->isNotEmpty())
                                <div class="filter-group">
                                    <h3>Guest capacity</h3>
                                    <div class="filter-field">
                                        <label for="capacity-filter">Rooms for at least</label>
                                        <select id="capacity-filter" name="capacity">
                                            <option value="">Any capacity</option>
                                            @foreach($capacityOptions as $capacity)
                                                <option value="{{ $capacity }}" {{ (string) ($search['capacity'] ?? '') === (string) $capacity ? 'selected' : '' }}>{{ $capacity }} guests</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            @if(count($amenities))
                                <div class="filter-group">
                                    <h3>Amenities</h3>
                                    <div class="filter-checks">
                                        @foreach($amenities as $amenity)
                                            <label class="filter-check">
                                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" {{ in_array($amenity->id, $search['amenities'] ?? []) ? 'checked' : '' }}>
                                                <span>{{ $amenity->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="filter-actions"><button class="filter-submit" type="submit">Show {{ $rooms->total() }} rooms</button></div>
                        </div>
                    </details>
                </aside>

                <section class="search-results-panel" aria-labelledby="results-title">
                    <header class="results-heading-row">
                        <div>
                            <h2 id="results-title">{{ $hasStayDates ? 'Available Rooms' : 'Browse Rooms' }}</h2>
                            <div class="results-count">
                                {{ $rooms->total() }} matching {{ $rooms->total() === 1 ? 'room' : 'rooms' }}
                                @if($checkIn && $checkOut)
                                    · {{ \Carbon\Carbon::parse($checkIn)->format('d M') }} – {{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}
                                @endif
                            </div>
                        </div>
                        <label class="results-sort">Sort by
                            <select name="sort" aria-label="Sort available rooms" onchange="document.getElementById('room-filters').submit()">
                                <option value="recommended" {{ ($search['sort'] ?? 'recommended') === 'recommended' ? 'selected' : '' }}>Recommended</option>
                                <option value="price_asc" {{ ($search['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ ($search['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="capacity_desc" {{ ($search['sort'] ?? '') === 'capacity_desc' ? 'selected' : '' }}>Guest Capacity</option>
                                <option value="name_asc" {{ ($search['sort'] ?? '') === 'name_asc' ? 'selected' : '' }}>Room Name</option>
                            </select>
                        </label>
                    </header>

                    @if($rooms->isEmpty())
                        <div class="results-empty">
                            @if($availableRoomCount === 0)
                                <h3>No rooms are available for your selected dates.</h3>
                                <p>Please try different dates or adjust your guest count.</p>
                            @else
                                <h3>No rooms match these filters.</h3>
                                <p>Clear filters to see all rooms available for your stay.</p>
                                <a class="search-action" href="{{ route('frontend.room.index', $stayQuery) }}">Clear filters</a>
                            @endif
                        </div>
                    @else
                        <div class="results-cards">
                            @foreach($rooms as $room)
                                @php
                                    $stayTotal = $nights ? (float) $room->roomType->price * $nights : null;
                                    $stayLinks = array_merge(['room' => $room->id], $stayQuery);
                                    $detailsLink = array_merge($stayLinks, array_diff_key($search, array_flip(['check_in', 'check_out', 'guests'])));
                                    $roomImage = $room->roomType->room_photo_url;
                                @endphp
                                <article class="room-result-card">
                                    <div class="room-result-image">
                                        @if($roomImage)
                                            <img src="{{ $roomImage }}" alt="{{ $room->roomType->name }} room" loading="lazy">
                                        @else
                                            <div class="room-image-placeholder" aria-label="No room image available"><div><i class="fas fa-bed" aria-hidden="true"></i>{{ $room->roomType->name }}</div></div>
                                        @endif
                                    </div>
                                    <div class="room-result-info">
                                        <h3 class="room-result-title">{{ $room->roomType->name }}</h3>
                                        <div class="room-result-number">Room {{ $room->room_number }} · Floor {{ $room->floor ?? 'N/A' }}</div>
                                        @if($room->roomType->description)
                                            <p class="room-result-description">{{ Str::limit($room->roomType->description, 145) }}</p>
                                        @endif
                                        <div class="room-result-facts">
                                            <span><i class="fas fa-user-friends" aria-hidden="true"></i> Up to {{ $room->roomType->capacity }} guests</span>
                                            <span>
                                                <i class="fas {{ $hasStayDates ? 'fa-check-circle' : 'fa-calendar-alt' }}" aria-hidden="true"></i>
                                                {{ $hasStayDates ? 'Available for these dates' : 'Select dates to check availability' }}
                                            </span>
                                        </div>
                                        @if($room->amenities->where('status', true)->isNotEmpty())
                                            <div class="room-result-amenities">
                                                @foreach($room->amenities->where('status', true)->take(3) as $amenity)
                                                    <span><i class="fas fa-check" aria-hidden="true"></i>{{ $amenity->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="room-result-price">
                                        <div class="room-availability-label {{ $hasStayDates ? '' : 'unverified' }}">
                                            {{ $hasStayDates ? 'Available for selected stay' : 'Availability not checked' }}
                                        </div>
                                        <div class="room-nightly-price">₹{{ number_format((float) $room->roomType->price, 2) }} <small>/ night</small></div>
                                        <div class="room-total-price">
                                            @if($stayTotal)
                                                {{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }} · stay total <strong>₹{{ number_format($stayTotal, 2) }}</strong>
                                            @else
                                                Select dates to view stay total
                                            @endif
                                        </div>
                                        <div class="room-result-footer">
                                            <a class="room-action-secondary" href="{{ route('frontend.room.show', $detailsLink) }}">View details</a>
                                            @if($checkIn && $checkOut)
                                                <a class="room-action-primary" href="{{ route('frontend.bookings.create', $stayLinks) }}">Book now</a>
                                            @else
                                                <a class="room-action-primary" href="{{ route('frontend.bookings.create', $stayLinks) }}">Choose dates</a>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        @if($rooms->hasPages())
                            <nav class="results-pagination" aria-label="Room results pages">{{ $rooms->links() }}</nav>
                        @endif
                    @endif
                </section>
            </form>
        </div>
    </main>
@endsection