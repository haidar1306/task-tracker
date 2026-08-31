@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                Dashboard
            </h1>

            <small class="text-muted">
                Welcome back, {{ $logged_in_user->name }}
            </small>
        </div>

        <div class="text-right">

            <span class="badge badge-success px-3 py-2">
                <i class="fas fa-user-circle"></i>
                {{ $logged_in_user->name }}
            </span>

        </div>

    </div>


    <!-- Statistics -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Rooms
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $totalRooms }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-bed fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Bookings
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{$totalBookings }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Guests
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $totalGuests }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Revenue
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $totalRevenue }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                availableRooms
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $availableRooms }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                occupiedRooms
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $occupiedRooms }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                pendingBookings
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingBookings }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card dashboard-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-chart-line mr-2"></i>
                        Today's Statistics
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-6 mb-3">
                            <h3 class="text-primary font-weight-bold">
                                {{ $todayBookings }}
                            </h3>
                            <small>Today's Bookings</small>
                        </div>

                        <div class="col-6 mb-3">
                            <h3 class="text-success font-weight-bold">
                                {{ $todayCheckIns }}
                            </h3>
                            <small>Today's Check In</small>
                        </div>

                        <div class="col-6">
                            <h3 class="text-danger font-weight-bold">
                                {{ $todayCheckOuts }}
                            </h3>
                            <small>Today's Check Out</small>
                        </div>

                        <div class="col-6">
                            <h3 class="text-warning font-weight-bold">
                                ₹{{ number_format($todayRevenue, 2) }}
                            </h3>
                            <small>Today's Revenue</small>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card dashboard-card">

                <div class="card-header">
                    <h5>
                        <i class="fas fa-wallet mr-2"></i>
                        Payment Summary
                    </h5>
                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <th>Paid Amount</th>
                            <td class="text-success font-weight-bold">
                                ₹{{ number_format($paidAmount, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Pending Amount</th>
                            <td class="text-danger font-weight-bold">
                                ₹{{ number_format($pendingAmount, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Partial Amount</th>
                            <td class="text-warning font-weight-bold">
                                ₹{{ number_format($partialAmount, 2) }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        {{-- Sales Growth --}}
        <div class="col-xl-8 col-lg-6">
            <div class="card dashboard-chart-card h-100">

                <div class="card-header">
                    <h3 class="card-title">Sales Growth</h3>
                </div>

                <div class="card-body">
                    <div id="sales-growth-chart" class="dashboard-chart"></div>
                </div>

            </div>
        </div>


        {{-- Room Status Distribution --}}
        <div class="col-xl-4 col-lg-4">
            <div class="card dashboard-chart-card h-100">

                <div class="card-header">
                    <h3 class="card-title">Room Distribution</h3>
                </div>

                <div class="card-body room-status-body">

                    <div id="room-status-chart"></div>

                </div>

            </div>
        </div>
    </div> {{-- End Chart Row --}}


    {{-- =========================
    RECENT BOOKINGS
    ========================= --}}

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">

                <div class="card-header">
                    <h3 class="mb-0">Recent Bookings</h3>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0 w-100">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking No</th>
                                    <th>Guest</th>
                                    <th>Room</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Payment</th>
                                    <!-- <th>Status</th> -->
                                    <!-- <th width="130">Action</th> -->
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($recentBookings as $booking)

                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $booking->booking_no }}</td>

                                        <td>
                                            {{ optional($booking->guest)->full_name ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ optional($booking->room)->room_number ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $booking->check_in }}
                                        </td>

                                        <td>
                                            {{ $booking->check_out }}
                                        </td>

                                        <td>
                                            ₹ {{ number_format($booking->total_amount, 2) }}
                                        </td>

                                        <td>{{ optional($booking->created_at)->format('d M Y') }}</td>

                                        <td>
                                            <span class="badge badge-warning">
                                                {{ $booking->payment_status ?? 'Pending' }}
                                            </span>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            No recent bookings found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>



@endsection

@push('page-libraries')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush

@push('after-scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ==========================
            // SALES GROWTH CHART
            // ==========================

            const months = @json($months);
            const salesGrowth = @json($salesGrowth);

            new ApexCharts(
                document.querySelector("#sales-growth-chart"),
                {
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },

                    series: [{
                        name: 'Sales',
                        data: salesGrowth
                    }],

                    xaxis: {
                        categories: months
                    },

                    colors: ['#5867e8'],

                    stroke: {
                        curve: 'smooth',
                        width: 4
                    },

                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.35,
                            opacityTo: 0.05
                        }
                    },

                    dataLabels: {
                        enabled: false
                    },

                    grid: {
                        borderColor: '#eef2f7'
                    }
                }
            ).render();


            // ==========================
            // ROOM STATUS DISTRIBUTION
            // ==========================

            const roomStatus = @json($roomStatus);

            new ApexCharts(
                document.querySelector("#room-status-chart"),
                {
                    chart: {
                        type: 'pie',
                        height: 300,
                        width: '100%'
                    },

                    series: Object.values(roomStatus),

                    labels: Object.keys(roomStatus),

                    colors: [
                        '#1b89ad',
                        '#aa3b19',
                        '#f59e0b',
                        '#38bdf8',
                        '#ef4444'
                    ],

                    legend: {
                        position: 'right'
                    },

                    dataLabels: {
                        enabled: false
                    }
                }
            ).render();

        });
    </script>
@endpush
@push('after-styles')
    <style>
        .dashboard-card .card-header {
            background: linear-gradient(135deg, #5867e8 0%, #1b89ad 100%);
            color: #e4e6eb;
            border-bottom: none;
            padding: 14px 20px;
        }

        .dashboard-card .card-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            /* color: #fff; */
        }

        .dashboard-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 .15rem 1rem rgba(58, 59, 69, .12);
        }

        .dashboard-card .card-body {
            padding: 25px;
        }

        /* Gap between dashboard sections */
        .row.mt-4 {
            margin-top: 30px !important;
        }

        .dashboard-chart-card {
            margin-bottom: 0;
        }
    </style>
@endpush