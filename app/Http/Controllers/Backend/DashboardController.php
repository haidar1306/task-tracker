<?php

namespace App\Http\Controllers\Backend;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Inquiry;
use App\Models\ActivityLog;

class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $recentBookings = Room::count();
        
        $totalRooms = Room::count();

        $availableRooms = Room::where('status', 'available')->count();

        $occupiedRooms = Room::where('status', 'occupied')->count();

        $totalBookings = Booking::count();

        $pendingBookings = Booking::where(
            'booking_status',
            'Pending'
        )->count();
        $todayBookings = Booking::whereDate('created_at', today())->count();

        $todayCheckIns = Booking::whereDate('check_in', today())->count();

        $todayCheckOuts = Booking::whereDate('check_out', today())->count();

        $todayRevenue = Payment::where('payment_status', 'Paid')
            ->whereDate('payment_date', today())
            ->sum('amount');

        $paidAmount = Invoice::sum('paid_amount');

        $pendingAmount = Invoice::sum(\DB::raw('total_amount - paid_amount'));

        $partialAmount = Invoice::where('payment_status', 'Partial')
            ->sum(\DB::raw('total_amount - paid_amount'));

        $recentPayments = Payment::with('invoice')
            ->latest()
            ->take(5)
            ->get();

        $recentInquiries = Inquiry::latest()
            ->take(5)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        $totalGuests = Guest::count();

        $totalRevenue = Payment::where(
            'payment_status',
            'Paid'
        )->sum('amount');

        $year = now()->year;

        $monthlySales = Payment::selectRaw(
            'MONTH(payment_date) as month, SUM(amount) as total'
        )
            ->where('payment_status', 'Paid')
            ->whereYear('payment_date', $year)
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month');

        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];

        $salesGrowth = [];

        for ($month = 1; $month <= 12; $month++) {
            $salesGrowth[] = (float) ($monthlySales[$month] ?? 0);
        }

        $roomStatus = Room::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentBookings = Booking::with([
            'guest',
            'room'
        ])
            ->latest()
            ->take(5)
            ->get();



        return view('backend.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'totalBookings',
            'pendingBookings',
            'totalGuests',
            'totalRevenue',
            'months',
            'salesGrowth',
            'roomStatus',
            'recentBookings',
            'todayBookings',
            'todayCheckIns',
            'todayCheckOuts',
            'todayRevenue',
            'paidAmount',
            'pendingAmount',
            'partialAmount',
            'recentPayments',
            'recentInquiries',
            'recentActivities'
        ));
    }
}
