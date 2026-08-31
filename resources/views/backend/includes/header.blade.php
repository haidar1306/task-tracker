<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <div class="d-flex align-items-center mr-auto">

    <img src="{{ asset('backend/img/7.jfif') }}"
         alt="Hotel"
         width="42"
         class="mr-3">

    <div>
        <h5 class="mb-0 font-weight-bold text-dark">
            Hotel Management
        </h5>

        <small class="text-muted">
            Admin Panel
        </small>
    </div>

</div>
    <!-- </ul> -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications -->
        <li class="nav-item dropdown no-arrow mx-2">

            @php
                $unreadCount = auth()->user()->unreadNotifications->count();
            @endphp

            <a class="nav-link dropdown-toggle position-relative" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-bell fa-fw" style="color:#4e73df;"></i>

                @if($unreadCount > 0)
                    <span class="badge badge-danger badge-counter">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif

            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in notification-dropdown"
                aria-labelledby="alertsDropdown">

                <h6 class="dropdown-header">
                    Notifications
                </h6>
                <div class="notification-scroll">

                    @forelse(auth()->user()->notifications()->latest()->limit(50)->get() as $notification)

                        <div class="dropdown-item d-flex align-items-center">

                            <a href="{{ route('admin.notifications.read', $notification->id) }}"
                                class="d-flex align-items-center text-decoration-none flex-grow-1">

                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                </div>

                                <div>
                                    <div class="small text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>

                                    <span class="{{ is_null($notification->read_at) ? 'font-weight-bold' : '' }}">
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    </span>
                                </div>

                            </a>

                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST"
                                class="ml-2">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm text-danger">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </div>

                    @empty

                        <div class="dropdown-item text-center">
                            No notifications
                        </div>

                    @endforelse
                </div>

            </div>

        </li>
        <li class="nav-item no-arrow mx-2 d-flex align-items-center">
            <input type="text" id="topDate">
        </li>


        <!-- <div class="topbar-divider d-none d-sm-block"></div>

    User Information
    <li class="nav-item dropdown no-arrow">

        <a class="nav-link dropdown-toggle"
           href="#"
           id="userDropdown"
           role="button"
           data-toggle="dropdown">

            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                Super Admin
            </span>

            <img class="img-profile rounded-circle"
                 src="{{ asset('img/undraw_profile.svg') }}">

        </a>

        User dropdown

    </li>

</ul> -->
        <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- User -->
            <li class="nav-item dropdown no-arrow">

                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ $logged_in_user->name }}
                    </span>

                    <img class="img-profile rounded-circle" src="{{ $logged_in_user->avatar }}"
                        alt="{{ $logged_in_user->name }}">
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">

                    <a class="dropdown-item" href="{{ route('frontend.user.account') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('frontend.auth.logout') }}">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>

            </li>

        </ul>

</nav>
<style>
    .notification-dropdown {
        width: 400px !important;
        max-height: 420px !important;
        overflow: hidden !important;
        padding: 0 !important;
    }

    .notification-dropdown .dropdown-header {
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .notification-dropdown .notification-scroll {
        max-height: 360px;
        overflow-y: auto;
    }

    .notification-dropdown .notification-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .notification-dropdown .notification-scroll::-webkit-scrollbar-thumb {
        background: #d4d4d4;
        border-radius: 10px;
    }

    #topDate {
        width: 165px;
        height: 42px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(180deg, #ffffff, #f7f9fc);
        box-shadow: 0 8px 20px rgba(15, 23, 42, .08);
        padding-left: 42px;
        padding-right: 15px;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        cursor: pointer;

        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%235564ff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 14px center;
    }
   
        
    
</style>
@push('page-libraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('after-scripts')
    @push('after-scripts')
        @push('after-scripts')
            <script>
                flatpickr("#topDate", {
                    dateFormat: "d M Y",
                    defaultDate: "today",
                    allowInput: false,
                    clickOpens: true
                });
            </script>
        @endpush
    @endpush
@endpush