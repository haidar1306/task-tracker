<style>
    .frontend-content {
        padding-top: 50px;
        min-height: 100vh;
    }

    .page-section {
        padding: 80px 0;
    }

    /* .navbar-nav .nav-item.active>.nav-link {
        color: #d4af37 !important;
    }

    .dropdown-menu .dropdown-item.active {
        background: #d4af37;
        color: #fff !important;
    } */


    .navbar .nav-link.active::after {
        width: 100%;
    }

    .nav-item.active>.nav-link,
    .nav-item.dropdown.active>.nav-link,
    .dropdown-item.active {
        color: #c9d269 !important;
        font-weight: 600;
    }

    .nav-item.active>.nav-link::after,
    .nav-item.dropdown.active>.nav-link::after {
        width: 100%;
        background: #d4af37;
    }

    .dropdown-menu .dropdown-item.active {
        background: rgba(212, 175, 55, 0.12);
        color: #d4af37 !important;
        border-radius: 6px;
    }

    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus {
        background: rgba(212, 175, 55, 0.08);
        color: #d4af37;
    }

    .notification-dropdown {
        min-width: 370px;
        max-height: 500px;
        overflow-y: auto;
        border-radius: 12px;
        padding: 0;
    }

    .notification-dropdown::-webkit-scrollbar {
        width: 6px;
    }

    .notification-dropdown::-webkit-scrollbar-thumb {
        background: #c8c8c8;
        border-radius: 20px;
    }
    .notification-dropdown{
    width:380px;
    max-height:500px;
    overflow-y:auto;
    overflow-x:hidden;
}

.notification-dropdown::-webkit-scrollbar{
    width:6px;
}

.notification-dropdown::-webkit-scrollbar-thumb{
    background:#d6d6d6;
    border-radius:20px;
}

    .notification-dropdown::-webkit-scrollbar-track {
        background: #f5f5f5;
    }
</style>
<nav class="navbar navbar-expand-lg hotel-navbar">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand">

            <div class="brand-title">
                HOTEL BOOKING
            </div>

            <div class="brand-subtitle">
                Hotel Luxura
            </div>

        </a>


        <!-- Mobile Button -->
        <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav">

            <i class="fas fa-bars"></i>

        </button>



        <div class="collapse navbar-collapse" id="navbarNav">


            <!-- Menu -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {{ request()->routeIs('frontend.index') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('frontend.index') ? 'active' : '' }}"
                        href="{{ route('frontend.index') }}">
                        Home
                    </a>
                </li>

                <li
                    class="nav-item dropdown {{ request()->routeIs('frontend.room.*', 'frontend.amenities.*') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('frontend.room.*', 'frontend.amenities.*') ? 'active' : '' }}"
                        href="#" id="roomsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        Rooms
                    </a>

                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ request()->routeIs('frontend.room.*') ? 'active' : '' }}"
                            href="{{ route('frontend.room.index') }}">
                            Rooms
                        </a>

                        <a class="dropdown-item {{ request()->routeIs('frontend.amenities.*') ? 'active' : '' }}"
                            href="{{ route('frontend.amenities.index') }}">
                            Amenities
                        </a>
                    </div>
                </li>

                <li class="nav-item {{ request()->routeIs('frontend.about') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}"
                        href="{{ route('frontend.about') }}">
                        About Us
                    </a>
                </li>

                <li
                    class="nav-item dropdown {{ request()->routeIs('frontend.services', 'frontend.gallery', 'frontend.offers', 'frontend.hotel-updates') ? 'active' : '' }}">

                    <a class="nav-link dropdown-toggle {{ request()->routeIs('frontend.services', 'frontend.gallery', 'frontend.offers', 'frontend.hotel-updates') ? 'active' : '' }}"
                        href="#" id="pagesDropdown" data-toggle="dropdown">

                        Pages

                    </a>

                    <div class="dropdown-menu">

                        <a class="dropdown-item {{ request()->routeIs('frontend.services') ? 'active' : '' }}"
                            href="{{ route('frontend.services') }}">
                            Services
                        </a>

                        <a class="dropdown-item {{ request()->routeIs('frontend.gallery') ? 'active' : '' }}"
                            href="{{ route('frontend.gallery') }}">
                            Gallery
                        </a>

                        <a class="dropdown-item {{ request()->routeIs('frontend.offers') ? 'active' : '' }}"
                            href="{{ route('frontend.offers') }}">
                            Offers
                        </a>

                        <a class="dropdown-item {{ request()->routeIs('frontend.hotel-updates') ? 'active' : '' }}"
                            href="{{ route('frontend.hotel-updates') }}">
                            Hotel Updates
                        </a>

                    </div>

                </li>

                @auth
                    @if (auth()->user()->isUser())
                    <li class="nav-item {{ request()->routeIs('frontend.reservation.*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('frontend.reservation.*') ? 'active' : '' }}"
                            href="{{ route('frontend.reservation.index') }}">
                            My Reservations
                        </a>
                    </li>
                    @endif
                @endauth

                <li class="nav-item {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}"
                        href="{{ route('frontend.contact') }}">
                        Contact
                    </a>
                </li>
            </ul>





            <!-- Right Side -->
            <div class="d-flex align-items-center">

                <!-- Notification Bell -->



                @auth
                    @if (auth()->user()->isUser())
                    <div class="dropdown mr-3">

                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp

                        <a href="#" class="text-white position-relative" id="notificationDropdown" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">

                            <i class="fas fa-bell fa-lg"></i>

                            @if($unreadCount > 0)
                                <span class="badge badge-danger" style="position:absolute;top:-8px;right:-10px;">
                                    {{ $unreadCount }}
                                </span>
                            @endif

                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow notification-dropdown">

                            <div class="dropdown-header bg-white sticky-top py-3 border-bottom">
                                <strong>Notifications</strong>
                            </div>
                            @forelse(auth()->user()->notifications()->latest()->get() as $notification)

                                <a class="dropdown-item"
                                    href="{{ route('frontend.frontend.notifications.read', $notification->id) }}">

                                    <div class="small text-muted">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>

                                    <strong>
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </strong>

                                    <br>

                                    <span>
                                        {{ $notification->data['message'] ?? '' }}
                                    </span>

                                </a>

                            @empty

                                <div class="dropdown-item text-center">
                                    No Notifications
                                </div>

                            @endforelse
                            <!-- <div class="border-top text-center p-2">

                                <a href="{{ route('frontend.frontend.notifications.index') }}" class="btn btn-sm btn-primary w-100">

                                    View All Notifications

                                </a>

                            </div> -->

                        </div>

                    </div>



                    <!-- Account Dropdown -->

                    <div class="dropdown">

                        <a href="#" class="dropdown-toggle text-white" id="accountDropdown" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">

                            <i class="fas fa-user-circle me-2"></i>
                            {{ auth()->user()->name }}

                        </a>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">


                            <a class="dropdown-item" href="{{ route('frontend.user.account') }}">

                                <i class="fas fa-user mr-2"></i>

                                My Account

                            </a>



                            <a class="dropdown-item" href="{{ route('frontend.reservation.index') }}">

                                <i class="fas fa-calendar-check mr-2"></i>

                                My Reservations

                            </a>



                            <div class="dropdown-divider"></div>



                            <a class="dropdown-item text-danger" href="{{ route('frontend.auth.logout') }}">


                                <i class="fas fa-sign-out-alt mr-2"></i>

                                Logout


                            </a>



                        </div>


                    </div>
                    @endif

                @else



                    <a href="{{ route('frontend.auth.login') }}" class="btn btn-gold mr-3">


                        Login

                    </a>



                    <a href="{{ route('frontend.auth.register') }}" class="btn btn-outline-light">


                        Register

                    </a>


                @endauth



            </div>



        </div>


    </div>


</nav>