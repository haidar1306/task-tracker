@extends('frontend.layouts.app')

{{-- Hero image ke upar navbar transparent rahega (overlay). Navbar ka code touch nahi hua. --}}

@section('title', 'Available Rooms | Hotel Luxura Palace')

@push('after-styles')
    <link href="{{ asset('css/frontendd/rooms-search.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $checkIn      = $search['check_in'] ?? null;
        $checkOut     = $search['check_out'] ?? null;
        $guestCount   = (int) ($search['guests'] ?? 1);
        $hasStayDates = $checkIn && $checkOut;

        $stayQuery = array_filter([
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'guests'    => $search['guests'] ?? null,
        ], function ($value) {
            return $value !== null && $value !== '';
        });

        $nights       = isset($nights) && $nights > 0 ? (int) $nights : null;
        $minimumPrice = $priceBounds->min_price ?? 0;
        $maximumPrice = $priceBounds->max_price ?? 0;

        $sliderMin = (int) floor($minimumPrice);
        $sliderMax = (int) ceil($maximumPrice);
        $selMin    = $search['price_min'] ?? '';
        $selMax    = $search['price_max'] ?? '';

        $currentSort = $search['sort'] ?? 'recommended';

        // image path -> full url
        $imgUrl = function ($path) {
            if (!$path) {
                return null;
            }
            return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : asset('storage/' . ltrim($path, '/'));
        };

        // amenity name -> icon
        $amenityIcon = function ($name) {
            $n = strtolower($name);
            if (str_contains($n, 'wi-fi') || str_contains($n, 'wifi')) return 'fa-wifi';
            if (str_contains($n, 'air') || str_contains($n, 'ac'))     return 'fa-snowflake';
            if (str_contains($n, 'tv'))                                return 'fa-tv';
            if (str_contains($n, 'bar'))                               return 'fa-glass-martini-alt';
            if (str_contains($n, 'parking'))                           return 'fa-parking';
            if (str_contains($n, 'breakfast') || str_contains($n, 'coffee')) return 'fa-coffee';
            if (str_contains($n, 'pool'))                              return 'fa-swimming-pool';
            return 'fa-check';
        };

        // hero background = pehle room ki image (na ho to dark gradient)
        $firstRoom = $rooms->first();
        $heroImage = $firstRoom ? $imgUrl($firstRoom->image ?? ($firstRoom->roomType->image ?? null)) : null;
    @endphp

    <div class="rm-page">

        {{-- ================= HERO + SEARCH ================= --}}
        <section class="rm-hero" aria-labelledby="stay-summary-title">
            @if($heroImage)
                <div class="rm-hero-bg" style="background-image:url('{{ $heroImage }}')"></div>
            @endif

            <div class="rm-container rm-hero-grid">
                <div>
                    <p class="rm-kicker">Your stay</p>
                    <h1 id="stay-summary-title">Find a room that feels like yours</h1>

                    <ul class="rm-meta">
                        <li>
                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                            @if($hasStayDates)
                                <span>
                                    <strong>{{ \Carbon\Carbon::parse($checkIn)->format('d M Y') }}</strong>
                                    &rarr;
                                    <strong>{{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}</strong>
                                </span>
                            @else
                                <span>Select dates to check availability</span>
                            @endif
                        </li>

                        @if($nights)
                            <li>
                                <i class="far fa-moon" aria-hidden="true"></i>
                                <span>{{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}</span>
                            </li>
                        @endif

                        <li>
                            <i class="far fa-user" aria-hidden="true"></i>
                            <span>{{ $guestCount }} {{ $guestCount === 1 ? 'guest' : 'guests' }}</span>
                        </li>

                        <li>
                            <i class="fas fa-bed" aria-hidden="true"></i>
                            <span>
                                {{ $availableRoomCount }}
                                {{ $hasStayDates ? 'available' : 'total' }}
                                {{ $availableRoomCount === 1 ? 'room' : 'rooms' }}
                            </span>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('frontend.room.index') }}"
                      method="GET"
                      class="rm-search"
                      aria-label="Modify stay search"
                      novalidate>

                    <div class="rm-field">
                        <label for="summary-check-in">Check-in</label>
                        <div class="rm-input">
                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                            <input id="summary-check-in"
                                   type="date"
                                   name="check_in"
                                   class="@error('check_in') is-invalid @enderror"
                                   min="{{ today()->toDateString() }}"
                                   value="{{ old('check_in', $checkIn) }}"
                                   required>
                        </div>
                        @error('check_in')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="rm-field">
                        <label for="summary-check-out">Check-out</label>
                        <div class="rm-input">
                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                            <input id="summary-check-out"
                                   type="date"
                                   name="check_out"
                                   class="@error('check_out') is-invalid @enderror"
                                   min="{{ old('check_in', $checkIn) ?: today()->toDateString() }}"
                                   value="{{ old('check_out', $checkOut) }}"
                                   required>
                        </div>
                        @error('check_out')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="rm-field">
                        <label for="summary-guests">Guests</label>
                        <div class="rm-input">
                            <i class="far fa-user" aria-hidden="true"></i>
                            <select id="summary-guests"
                                    name="guests"
                                    class="@error('guests') is-invalid @enderror">
                                @for($count = 1; $count <= 20; $count++)
                                    <option value="{{ $count }}"
                                        {{ (int) old('guests', $guestCount) === $count ? 'selected' : '' }}>
                                        {{ $count }} {{ $count === 1 ? 'guest' : 'guests' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        @error('guests')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="rm-btn" type="submit">Update search</button>
                </form>
            </div>
        </section>

        {{-- ================= FILTERS + RESULTS ================= --}}
        <div class="rm-container">
            <form class="rm-layout"
                  id="room-filters"
                  action="{{ route('frontend.room.index') }}"
                  method="GET">

                @if($checkIn)
                    <input type="hidden" name="check_in" value="{{ $checkIn }}">
                @endif

                @if($checkOut)
                    <input type="hidden" name="check_out" value="{{ $checkOut }}">
                @endif

                @if(isset($search['guests']))
                    <input type="hidden" name="guests" value="{{ $search['guests'] }}">
                @endif

                {{-- ---------- Filters ---------- --}}
                <aside class="rm-filters" aria-label="Room filters">
                    <details class="rm-filter-details" open>
                        <summary>
                            <span><i class="fas fa-sliders-h" aria-hidden="true"></i>Filter rooms</span>
                            <i class="fas fa-chevron-down" aria-hidden="true"></i>
                        </summary>

                        <div class="rm-filter-body">
                            <div class="rm-filter-head">
                                <h2><i class="fas fa-sliders-h" aria-hidden="true"></i>Filter rooms</h2>
                                <a class="rm-link" href="{{ route('frontend.room.index', $stayQuery) }}">Clear all</a>
                            </div>

                            {{-- Price --}}
                            <div class="rm-filter-group">
                                <h3>Price per night</h3>

                                <div class="rm-price-grid">
                                    <div class="rm-mini-field">
                                        <label for="price-min">Min ₹</label>
                                        <input id="price-min"
                                               type="number"
                                               name="price_min"
                                               min="0"
                                               step="100"
                                               placeholder="{{ number_format($minimumPrice, 0) }}"
                                               value="{{ $selMin }}">
                                    </div>

                                    <div class="rm-mini-field">
                                        <label for="price-max">Max ₹</label>
                                        <input id="price-max"
                                               type="number"
                                               name="price_max"
                                               min="0"
                                               step="100"
                                               placeholder="{{ number_format($maximumPrice, 0) }}"
                                               value="{{ $selMax }}">
                                    </div>
                                </div>

                                @if($sliderMax > $sliderMin)
                                    <div class="rm-range"
                                         data-min="{{ $sliderMin }}"
                                         data-max="{{ $sliderMax }}">
                                        <div class="rm-range-track"></div>
                                        <div class="rm-range-fill"></div>
                                        <input type="range"
                                               id="range-min"
                                               aria-label="Minimum price"
                                               min="{{ $sliderMin }}"
                                               max="{{ $sliderMax }}"
                                               step="100"
                                               value="{{ $selMin !== '' ? $selMin : $sliderMin }}">
                                        <input type="range"
                                               id="range-max"
                                               aria-label="Maximum price"
                                               min="{{ $sliderMin }}"
                                               max="{{ $sliderMax }}"
                                               step="100"
                                               value="{{ $selMax !== '' ? $selMax : $sliderMax }}">
                                    </div>
                                @endif
                            </div>

                            {{-- Room type --}}
                            @if($roomTypes->isNotEmpty())
                                <div class="rm-filter-group">
                                    <h3>Room type</h3>

                                    <div class="rm-checks">
                                        @foreach($roomTypes as $roomType)
                                            <label class="rm-check">
                                                <input type="checkbox"
                                                       name="room_types[]"
                                                       value="{{ $roomType->id }}"
                                                       {{ in_array($roomType->id, $search['room_types'] ?? []) ? 'checked' : '' }}>
                                                <span>{{ $roomType->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Capacity --}}
                            @if($capacityOptions->isNotEmpty())
                                <div class="rm-filter-group">
                                    <h3>Guest capacity</h3>

                                    <div class="rm-mini-field">
                                        <label for="capacity-filter">Rooms for at least</label>
                                        <select id="capacity-filter" name="capacity">
                                            <option value="">Any capacity</option>

                                            @foreach($capacityOptions as $capacity)
                                                <option value="{{ $capacity }}"
                                                    {{ (string) ($search['capacity'] ?? '') === (string) $capacity ? 'selected' : '' }}>
                                                    {{ $capacity }} guests
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            {{-- Amenities --}}
                            @if($amenities->isNotEmpty())
                                <div class="rm-filter-group">
                                    <h3>Amenities</h3>

                                    <div class="rm-checks" id="amenity-checks">
                                        @foreach($amenities as $amenity)
                                            <label class="rm-check {{ $loop->iteration > 5 ? 'rm-more' : '' }}">
                                                <input type="checkbox"
                                                       name="amenities[]"
                                                       value="{{ $amenity->id }}"
                                                       {{ in_array($amenity->id, $search['amenities'] ?? []) ? 'checked' : '' }}>
                                                <span>{{ $amenity->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    @if($amenities->count() > 5)
                                        <button type="button" class="rm-toggle-more" id="amenity-toggle">
                                            + Show more
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <button class="rm-btn rm-filter-submit" type="submit">
                                Show {{ $rooms->total() }} {{ $rooms->total() === 1 ? 'room' : 'rooms' }}
                            </button>
                        </div>
                    </details>
                </aside>

                {{-- ---------- Results ---------- --}}
                <section aria-labelledby="results-title">
                    <header class="rm-results-head">
                        <div>
                            <h2 id="results-title">{{ $hasStayDates ? 'Available Rooms' : 'Browse Rooms' }}</h2>

                            <p class="rm-count">
                                {{ $rooms->total() }} matching {{ $rooms->total() === 1 ? 'room' : 'rooms' }}
                                @if($hasStayDates)
                                    &middot; {{ \Carbon\Carbon::parse($checkIn)->format('d M') }}
                                    &ndash; {{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}
                                @endif
                            </p>
                        </div>

                        <label class="rm-sort">
                            Sort by
                            <select name="sort"
                                    aria-label="Sort available rooms"
                                    onchange="document.getElementById('room-filters').submit()">
                                <option value="recommended" {{ $currentSort === 'recommended' ? 'selected' : '' }}>Recommended</option>
                                <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="capacity_desc" {{ $currentSort === 'capacity_desc' ? 'selected' : '' }}>Guest Capacity</option>
                                <option value="name_asc" {{ $currentSort === 'name_asc' ? 'selected' : '' }}>Room Name</option>
                            </select>
                        </label>
                    </header>

                    @if($rooms->isEmpty())
                        <div class="rm-empty">
                            <i class="fas fa-bed" aria-hidden="true"></i>

                            @if(!$hasStayDates)
                                <h3>Choose your dates to see rooms</h3>
                                <p>Select check-in and check-out dates above to see rooms available for your stay.</p>
                            @else
                                <h3>No rooms available for these dates</h3>
                                <p>Try different dates, reduce the number of guests, or clear the filters.</p>
                                <a class="rm-btn" href="{{ route('frontend.room.index') }}">Reset search</a>
                            @endif
                        </div>
                    @else
                        <div class="rm-cards">
                            @foreach($rooms as $room)
                                @php
                                    $roomType     = $room->roomType;
                                    $roomName     = \Illuminate\Support\Str::title($roomType->name ?? ('Room ' . $room->room_number));
                                    $roomPrice    = (float) ($roomType->price ?? 0);
                                    $roomCapacity = (int) ($roomType->capacity ?? 1);
                                    $roomImage    = $imgUrl($room->image ?? ($roomType->image ?? null));
                                    $stayTotal    = $nights ? $roomPrice * $nights : $roomPrice;
                                    $roomDesc     = data_get($roomType, 'description');
                                    $amenityList  = $room->amenities;
                                    $detailsUrl   = route('frontend.room.show', array_merge(['room' => $room->id], $stayQuery));
                                @endphp

                                <article class="rm-card">
                                    <a class="rm-card-media" href="{{ $detailsUrl }}" tabindex="-1" aria-hidden="true">
                                        @if($roomImage)
                                            <img src="{{ $roomImage }}" alt="{{ $roomName }}" loading="lazy">
                                        @else
                                            <div class="rm-card-placeholder">
                                                <i class="fas fa-hotel" aria-hidden="true"></i>
                                                {{ $roomName }}
                                            </div>
                                        @endif
                                    </a>

                                    <div class="rm-card-body">
                                        <h3>{{ $roomName }}</h3>
                                        <p class="rm-room-no">Room {{ $room->room_number }}</p>

                                       <ul class="rm-facts">
    <li>
        <i class="fas fa-user-friends" aria-hidden="true"></i>
        {{ $roomCapacity }} {{ $roomCapacity === 1 ? 'guest' : 'guests' }}
    </li>

    @if($room->bedType)
        <li>
            <i class="fas fa-bed" aria-hidden="true"></i>
            {{ $room->bedType->name }}
        </li>
    @endif
</ul>
                                        @if($amenityList->isNotEmpty())
                                            <ul class="rm-amen">
                                                @foreach($amenityList->take(4) as $amenity)
                                                    <li>
                                                        <i class="fas {{ $amenityIcon($amenity->name) }}" aria-hidden="true"></i>
                                                        {{ $amenity->name }}
                                                    </li>
                                                @endforeach

                                                @if($amenityList->count() > 4)
                                                    <li class="rm-amen-more">+{{ $amenityList->count() - 4 }} more</li>
                                                @endif
                                            </ul>
                                        @endif

                                        @if($roomDesc)
                                            <p class="rm-card-desc">{{ \Illuminate\Support\Str::limit(strip_tags($roomDesc), 120) }}</p>
                                        @endif
                                    </div>

                                    <div class="rm-card-price">
                                        <div class="rm-availability {{ $hasStayDates ? '' : 'is-neutral' }}">
                                            {{ $hasStayDates ? 'Available for your stay' : 'Select dates to confirm' }}
                                        </div>

                                        <div class="rm-price">
                                            ₹{{ number_format($roomPrice, 0) }}
                                            <small>/ night</small>
                                        </div>

                                        @if($nights)
                                            <div class="rm-total">
                                                {{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }} &middot; stay total
                                                <strong>₹{{ number_format($stayTotal, 0) }}</strong>
                                            </div>
                                        @endif

                                        <div class="rm-card-actions">
                                            <a class="rm-btn rm-btn-ghost" href="{{ $detailsUrl }}">View Details</a>
                                            <a class="rm-btn"
                                               href="{{ route('bookings.create', array_merge(['room' => $room->id], $stayQuery)) }}">
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @if($rooms->hasPages())
                            <nav class="rm-pagination" aria-label="Room results pages">
                                {{ $rooms->onEachSide(1)->links('vendor.pagination.admin', ['label' => 'rooms']) }}
                            </nav>
                        @endif
                    @endif
                </section>
            </form>
        </div>
    </div>
@endsection

@push('after-scripts')
<script>
    (function () {
        /* ---- check-out min date sync (pehle jaisa) ---- */
        var inEl  = document.getElementById('summary-check-in');
        var outEl = document.getElementById('summary-check-out');

        if (inEl && outEl) {
            var sync = function () {
                if (!inEl.value) return;
                var next = new Date(inEl.value + 'T00:00:00');
                next.setDate(next.getDate() + 1);
                var min = next.getFullYear() + '-' +
                    String(next.getMonth() + 1).padStart(2, '0') + '-' +
                    String(next.getDate()).padStart(2, '0');
                outEl.min = min;
                if (outEl.value && outEl.value < min) outEl.value = '';
            };
            inEl.addEventListener('change', sync);
            sync();
        }

        /* ---- filters: desktop par hamesha open, mobile par band ---- */
        var details = document.querySelector('.rm-filter-details');
        if (details && window.matchMedia) {
            var mq = window.matchMedia('(min-width: 992px)');
            var apply = function () {
                if (mq.matches) details.setAttribute('open', '');
                else details.removeAttribute('open');
            };
            apply();
            if (mq.addEventListener) mq.addEventListener('change', apply);
            else if (mq.addListener) mq.addListener(apply);
        }

        /* ---- amenities: show more ---- */
        var amenityBox = document.getElementById('amenity-checks');
        var amenityBtn = document.getElementById('amenity-toggle');
        if (amenityBox && amenityBtn) {
            var setExpanded = function (on) {
                amenityBox.classList.toggle('is-expanded', on);
                amenityBtn.textContent = on ? '− Show less' : '+ Show more';
            };
            amenityBtn.addEventListener('click', function () {
                setExpanded(!amenityBox.classList.contains('is-expanded'));
            });
            if (amenityBox.querySelector('.rm-more input:checked')) setExpanded(true);
        }

        /* ---- dual price slider <-> number inputs ---- */
        var range = document.querySelector('.rm-range');
        if (range) {
            var lo = document.getElementById('range-min');
            var hi = document.getElementById('range-max');
            var nMin = document.getElementById('price-min');
            var nMax = document.getElementById('price-max');
            var fill = range.querySelector('.rm-range-fill');
            var min = +range.dataset.min, max = +range.dataset.max, span = (max - min) || 1;

            var paint = function () {
                fill.style.left  = ((+lo.value - min) / span * 100) + '%';
                fill.style.right = (100 - (+hi.value - min) / span * 100) + '%';
            };

            lo.addEventListener('input', function () {
                if (+lo.value > +hi.value) lo.value = hi.value;
                nMin.value = (+lo.value <= min) ? '' : lo.value;
                paint();
            });
            hi.addEventListener('input', function () {
                if (+hi.value < +lo.value) hi.value = lo.value;
                nMax.value = (+hi.value >= max) ? '' : hi.value;
                paint();
            });
            nMin.addEventListener('input', function () {
                lo.value = nMin.value === '' ? min : nMin.value; paint();
            });
            nMax.addEventListener('input', function () {
                hi.value = nMax.value === '' ? max : nMax.value; paint();
            });
            paint();
        }
    })();
</script>
@endpush