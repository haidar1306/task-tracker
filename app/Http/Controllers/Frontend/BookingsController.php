<?php

namespace App\Http\Controllers\Frontend;

// use App\Models\User;

use app\Domains\Auth\Models\User;
use App\Notifications\BookingNotification;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Carbon\Carbon;
use App\Models\Booking1;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;


class BookingsController extends Controller
{


    public function create(Room $room)
    {
        return view('frontend.bookings.create', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();

        // Guest find karo email se
        $guest = Guest::where('email', $user->email)->first();

        // Agar guest nahi mila to create karo
        if (!$guest) {

            $name = explode(' ', trim($user->name), 2);

            $guest = Guest::create([
                'first_name' => $name[0] ?? '',
                'last_name' => $name[1] ?? '',
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'status' => true,
            ]);
        }

        $alreadyBooked = Booking1::where('room_id', $request->room_id)
            ->where('booking_status', '!=', 'Cancelled')
            ->where(function ($query) use ($request) {

                $query->whereBetween('check_in', [
                    $request->check_in,
                    $request->check_out
                ])
                    ->orWhereBetween('check_out', [
                        $request->check_in,
                        $request->check_out
                    ])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                    });

            })
            ->exists();

        if ($alreadyBooked) {
            return back()
                ->withInput()
                ->withFlashDanger('This room is already booked for the selected dates.');

        }

        $room = Room::with('roomType')->findOrFail($request->room_id);

        $checkIn = Carbon::parse($request->check_in);

        $checkOut = Carbon::parse($request->check_out);

        $nights = max(1, $checkIn->diffInDays($checkOut));

        $pricePerNight = $room->roomType->price;

        $totalAmount = $pricePerNight * $nights;

        $booking = Booking1::create([
            'booking_no' => 'BK-' . time(),
            'guest_id' => $guest->id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'total_amount' => $totalAmount,
            'booking_status' => 'Pending',
            'payment_status' => 'Pending',
            'remarks' => null,
            'status' => true,
        ]);
        $admins = User::where('type', User::TYPE_ADMIN)->get();
        
        foreach ($admins as $admin) {
            $admin->notify(
                new BookingNotification($booking)
            );
        }


        return redirect()
            ->route('frontend.room.index')
            ->withFlashSuccess('Booking submitted successfully.');
    }

    public function show(Booking1 $booking)
    {
        $booking->load([
            'room.roomType',
            'guest',
        ]);

        // Sirf logged-in user ki booking show ho
        if ($booking->guest->email !== Auth::user()->email) {
            abort(403);
        }

        return view(
            'frontend.bookings.show',
            compact('booking')
        );
    }

    public function cancel(Booking1 $booking)
    {
        $booking->load('guest');

        if ($booking->guest->email !== Auth::user()->email) {
            abort(403);
        }

        if (!in_array($booking->booking_status, ['Pending', 'Confirmed'])) {
            return back()->withFlashDanger(
                'This booking cannot be cancelled.'
            );
        }

        $booking->update([
            'booking_status' => 'Cancelled',
        ]);

        return back()->withFlashSuccess(
            'Booking cancelled successfully.'
        );
    }
}