@php
    $navMode = $navMode ?? 'overlay';
    $is = fn(...$r) => request()->routeIs(...$r);
@endphp

<nav class="navbar navbar-expand-lg lx-nav {{ $navMode === 'solid' ? 'is-pill' : '' }}" id="lxNav"
    data-mode="{{ $navMode }}">
    <div class="lx-bar">

        <a class="navbar-brand lx-brand" href="{{ route('frontend.index') }}">
            <img class="lx-logo" src="{{ asset('frontend/images/006.png') }}" alt="Hotel Luxura">
            <span class="lx-brand-text">Luxura Palace</span>
        </a>

        <button class="lx-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav lx-menu">
                <li class="nav-item">
                    <a class="nav-link {{ $is('frontend.index') ? 'active' : '' }}"
                        href="{{ route('frontend.index') }}">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ $is('frontend.room.*', 'frontend.amenities.*') ? 'active' : '' }}"
                        href="#" id="roomsDropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Rooms</a>
                    <div class="dropdown-menu" aria-labelledby="roomsDropdown">
                        <a class="dropdown-item {{ $is('frontend.room.*') ? 'active' : '' }}"
                            href="{{ route('frontend.room.index') }}">Rooms</a>
                        <a class="dropdown-item {{ $is('frontend.amenities.*') ? 'active' : '' }}"
                            href="{{ route('frontend.amenities.index') }}">Amenities</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $is('frontend.about') ? 'active' : '' }}"
                        href="{{ route('frontend.about') }}">About Us</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ $is('frontend.services', 'frontend.gallery', 'frontend.offers', 'frontend.hotel-updates') ? 'active' : '' }}"
                        href="#" id="pagesDropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Pages</a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item {{ $is('frontend.services') ? 'active' : '' }}"
                            href="{{ route('frontend.services') }}">Services</a>
                        <a class="dropdown-item {{ $is('frontend.gallery') ? 'active' : '' }}"
                            href="{{ route('frontend.gallery') }}">Gallery</a>
                        <a class="dropdown-item {{ $is('frontend.offers') ? 'active' : '' }}"
                            href="{{ route('frontend.offers') }}">Offers</a>
                        <a class="dropdown-item {{ $is('frontend.hotel-updates') ? 'active' : '' }}"
                            href="{{ route('frontend.hotel-updates') }}">Hotel Updates</a>
                        <a class="dropdown-item {{ $is('frontend.frontend.inquiries.*') ? 'active' : '' }}"
                            href="{{ route('frontend.frontend.inquiries.index') }}">My Inquiries</a>
                    </div>
                </li>

                @auth
                    @if (auth()->user()->isUser())
                        <li class="nav-item">
                            <a class="nav-link {{ $is('frontend.reservation.*') ? 'active' : '' }}"
                                href="{{ route('frontend.reservation.index') }}">My Reservations</a>
                        </li>
                    @endif
                @endauth

                <li class="nav-item">
                    <a class="nav-link {{ $is('frontend.contact') ? 'active' : '' }}"
                        href="{{ route('frontend.contact') }}">Contact</a>
                </li>
            </ul>

            <div class="lx-right">
                @auth
                    @if (auth()->user()->isUser())
                        @php
                            $notifications = auth()->user()->notifications()->where(function ($q) {
                                $q->where('data->audience', 'user')->orWhere('data->type', 'inquiry_reply');
                            })->latest();
                            $unreadCount = (clone $notifications)->whereNull('read_at')->count();
                        @endphp

                        <div class="dropdown">
                            <a href="#" class="lx-icon-btn" id="notificationDropdown" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                @if ($unreadCount > 0)
                                    <span class="lx-badge">{{ $unreadCount }}</span>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <div class="dropdown-header bg-white sticky-top py-3 border-bottom">
                                    <strong>Notifications</strong>
                                </div>
                                @forelse ($notifications->get() as $notification)
                                    <a class="dropdown-item"
                                        href="{{ route('frontend.frontend.notifications.read', $notification->id) }}">
                                        <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                        <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong><br>
                                        <span>{{ $notification->data['message'] ?? '' }}</span>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-center">No Notifications</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="dropdown">
                            <a href="#" class="lx-user dropdown-toggle" id="accountDropdown" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>{{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                                <a class="dropdown-item" href="{{ route('frontend.user.account') }}">
                                    <i class="fas fa-user mr-2"></i>My Account
                                </a>
                                <a class="dropdown-item" href="{{ route('frontend.reservation.index') }}">
                                    <i class="fas fa-calendar-check mr-2"></i>My Reservations
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('frontend.auth.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- admin/staff roles: pehle yahan kuch nahi dikhta tha (bug) --}}
                        <div class="dropdown">
                            <a href="#" class="lx-user dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>{{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <form method="POST" action="{{ route('frontend.auth.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <a href="{{ route('frontend.auth.login') }}" class="btn-login-join">Login / Join</a>
                @endauth
            </div>

        </div>
    </div>
</nav>