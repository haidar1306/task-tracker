<ul class="navbar-nav sidebar sidebar-dark accordion shadow" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">

        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hotel"></i>
        </div>
        

        <div class="sidebar-brand-text mx-3">
            Hotel Management
        </div>
    </a>
    
    <hr class="sidebar-divider my-0">
    <!-- Dashboard -->
<li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#managementMenu" aria-expanded="true"
            aria-controls="managementMenu">
            <i class="fas fa-users-cog"></i>
            <span>Management</span>
        </a>

        <div id="managementMenu"
            class="collapse {{ request()->routeIs('admin.auth.user.*') || request()->routeIs('admin.auth.role.*') ? 'show' : '' }}">

            <div class="py-2 collapse-inner rounded">

                @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.access.user.list'))
                    <a class="collapse-item {{ request()->routeIs('admin.auth.user.*') ? 'active' : '' }}"
                        href="{{ route('admin.auth.user.index') }}">
                        User Management
                    </a>
                @endif

                @if ($logged_in_user->hasAllAccess())
                    <a class="collapse-item {{ request()->routeIs('admin.auth.role.*') ? 'active' : '' }}"
                        href="{{ route('admin.auth.role.index') }}">
                        Role Management
                    </a>
                @endif

            </div>
        </div>
    </li>


    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Masters
    </div>

    <!-- Room Types -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#mastersMenu">
            <i class="fas fa-hotel"></i>
            <span>Masters</span>
        </a>

        <div id="mastersMenu"
            class="collapse {{ request()->routeIs('admin.room-types.*') || request()->routeIs('admin.rooms.*') || request()->routeIs('admin.amenities.*') || request()->routeIs('admin.bed-types.*') || request()->routeIs('admin.room-statuses.*') ? 'show' : '' }}">

            <div class="py-2 collapse-inner rounded">

                <a class="collapse-item {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}"
                    href="{{ route('admin.room-types.index') }}">
                    Room Types
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}"
                    href="{{ route('admin.rooms.index') }}">
                    Rooms
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}"
                    href="{{ route('admin.amenities.index') }}">
                    Amenities
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.bed-types.*') ? 'active' : '' }}"
                    href="{{ route('admin.bed-types.index') }}">
                    Bed Types
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.room-statuses.*') ? 'active' : '' }}"
                    href="{{ route('admin.room-statuses.index') }}">
                    Room Statuses
                </a>

            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Booking
    </div>

    <!-- Guests -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bookingMenu">
            <i class="fas fa-calendar-alt"></i>
            <span>Booking</span>
        </a>

        <div id="bookingMenu"
            class="collapse {{ request()->routeIs('admin.guests.*') || request()->routeIs('admin.bookings.*') ? 'show' : '' }}">

            <div class="py-2 collapse-inner rounded">

                <a class="collapse-item {{ request()->routeIs('admin.guests.*') ? 'active' : '' }}"
                    href="{{ route('admin.guests.index') }}">
                    Guests
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
                    href="{{ route('admin.bookings.index') }}">
                    Bookings
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.bookings.checkInIndex') ? 'active' : '' }}"
                    href="{{ route('admin.bookings.checkInIndex') }}">
                    Check In
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.bookings.checkOutIndex') ? 'active' : '' }}"
                    href="{{ route('admin.bookings.checkOutIndex') }}">
                    Check Out
                </a>
                

            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Accounts
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.payments.index') }}">
            <i class="fas fa-money-bill-wave"></i>
            <span>Payments</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{ route('admin.invoices.index') }}">
                   <i class="fas fa-file-invoice-dollar"></i>
            <span>invoices</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Reports
    </div>
<li class="nav-item {{ request()->routeIs('admin.admin.inquiries.*') ? 'active' : '' }}">
    <a class="nav-link"
       href="{{ route('admin.inquiries.index') }}">
        <i class="fas fa-comments"></i>
        <span> Inquiries</span>
    </a>
</li>
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-bed"></i>
            <span>Rooms</span>
        </a>
    </li> -->

    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}"
        href="{{ route('admin.admin.activity-logs.index') }}">

        <i class="nav-icon fas fa-history"></i>

        <span>Activity Logs</span>

    </a>
</li>
    
     <hr class="sidebar-divider">

     <div class="sidebar-heading">
        services
    </div>
    <li class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.services.index') }}">
        <i class="fas fa-concierge-bell"></i>
        <span>Services</span>
    </a>
</li>

    
     <hr class="sidebar-divider">
    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWebsite">
        <i class="fas fa-globe"></i>
        <span>Website Management</span>
    </a>

    <div id="collapseWebsite" class="collapse">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item"
               href="{{ route('admin.website.hero.edit') }}">
                Hero Section
            </a>
              <a class="collapse-item"
             href="{{ route('admin.website.general.edit') }}">general settings</a>
            </a>
            

        </div>
    </div>

</li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- <hr class="sidebar-divider">

    <div class="sidebar-heading">
       Room
    </div>

    <li class="nav-item {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.room-types.index') }}">
        <i class="fas fa-bed"></i>
        <span>Room Types</span>
    </a>
</li> -->

</ul>