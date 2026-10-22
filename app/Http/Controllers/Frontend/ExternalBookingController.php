<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ExternalBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DubaiHotelService;

class ExternalBookingController extends Controller
{
    /**
     * Show logged-in user's external bookings.
     */
    public function index()
    {
        $bookings = ExternalBooking::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('frontend.external-bookings.index', compact('bookings'));
    }

    /**
     * Show a single external booking.
     */
    public function show($id)
    {
        $booking = ExternalBooking::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.external-bookings.show', compact('booking'));
    }

    /**
     * Save a Dubai hotel booking request.
     */
    public function store(Request $request, DubaiHotelService $dubai)
    {
        $data = $request->validate([
            'hotel_id'  => ['required', 'integer'],
            'check_in'  => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'guests'    => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Fetch hotel and price again from the API.
        $hotel = $dubai->find(
            (int) $data['hotel_id'],
            $data['check_in'],
            $data['check_out'],
            (int) $data['guests']
        );

        abort_if(!$hotel, 404, 'Hotel unavailable. Please search again.');

        abort_if(
            (float) $hotel['total_price'] <= 0,
            422,
            'Invalid hotel price. Please search again.'
        );

        $booking = ExternalBooking::create([
            'user_id'     => $user->id,
            'hotel_id'    => $hotel['id'],
            'hotel_name'  => $hotel['name'],
            'hotel_image' => $hotel['image'] ?? null,
            'check_in'    => $data['check_in'],
            'check_out'   => $data['check_out'],
            'guests'      => $data['guests'],
            'total_price' => $hotel['total_price'],
            'currency'    => $hotel['currency'] ?? 'INR',
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('frontend.room.index', [
                'check_in'  => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests'    => $data['guests'],
            ])
            ->withFlashSuccess(
                'Dubai booking request saved. Reference: ' . $booking->id
            );
    }
}
