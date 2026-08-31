<div class="row">

    <div class="col-md-6 mb-3">

        <label>Guest</label>

        <select name="guest_id" class="form-control" required>

            <option value="">Select Guest</option>

            @foreach($guests as $guest)

                <option value="{{ $guest->id }}" {{ old('guest_id', $booking->guest_id ?? '') == $guest->id ? 'selected' : '' }}>

                    {{ $guest->first_name }} {{ $guest->last_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label>Room</label>

        <select name="room_id" class="form-control" required>

            <option value="">Select Room</option>

            @foreach($rooms as $room)

                <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id ?? '') == $room->id ? 'selected' : '' }}>

                    {{ $room->room_number }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label>Check In</label>

        <input type="date" name="check_in" class="form-control"
            value="{{ old('check_in', isset($booking) ? $booking->check_in->format('Y-m-d') : '') }}" required>

    </div>

    <div class="col-md-6 mb-3">

        <label>Check Out</label>

        <input type="date" name="check_out" class="form-control"
            value="{{ old('check_out', isset($booking) ? $booking->check_out->format('Y-m-d') : '') }}" required>

    </div>

    <div class="col-md-6 mb-3">

        <label>Adults</label>

        <input type="number" name="adults" class="form-control" value="{{ old('adults', $booking->adults ?? 1) }}">

    </div>

    <div class="col-md-6 mb-3">

        <label>Children</label>

        <input type="number" name="children" class="form-control" value="{{ old('children', $booking->children ?? 0) }}">

    </div>

    <div class="col-md-6 mb-3">

        <label>Total Amount</label>

        <input type="number" step="0.01" name="total_amount" class="form-control"
            value="{{ old('total_amount', $booking->total_amount ?? '') }}">

    </div>

    <div class="col-md-6 mb-3">

        <label>Booking Status</label>

        <select name="booking_status" class="form-control">

            <option value="Pending" {{ old('booking_status', $booking->booking_status ?? '') == 'Pending' ? 'selected' : '' }}>
                Pending</option>

            <option value="Confirmed" {{ old('booking_status', $booking->booking_status ?? '') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>

            <option value="Checked In" {{ old('booking_status', $booking->booking_status ?? '') == 'Checked In' ? 'selected' : '' }}>Checked In</option>

            <option value="Checked Out" {{ old('booking_status', $booking->booking_status ?? '') == 'Checked Out' ? 'selected' : '' }}>Checked Out</option>

            <option value="Cancelled" {{ old('booking_status', $booking->booking_status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label>Payment Status</label>

        <select name="payment_status" class="form-control">

            <option value="Pending" {{ old('payment_status', $booking->payment_status ?? '') == 'Pending' ? 'selected' : '' }}>
                Pending</option>

            <option value="Partial" {{ old('payment_status', $booking->payment_status ?? '') == 'Partial' ? 'selected' : '' }}>
                Partial</option>

            <option value="Paid" {{ old('payment_status', $booking->payment_status ?? '') == 'Paid' ? 'selected' : '' }}>Paid
            </option>

            <option value="Refunded" {{ old('payment_status', $booking->payment_status ?? '') == 'Refunded' ? 'selected' : '' }}>Refunded</option>

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label>Status</label>

        <select name="status" class="form-control">

            <option value="1" {{ old('status', $booking->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>

            <option value="0" {{ old('status', $booking->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>

        </select>

    </div>

    <div class="col-md-12 mb-3">

        <label>Remarks</label>

        <textarea name="remarks" class="form-control" rows="4">{{ old('remarks', $booking->remarks ?? '') }}</textarea>

    </div>

</div>

<button class="btn btn-primary">

    <i class="fas fa-save"></i>

    {{ isset($booking) ? 'Update Booking' : 'Save Booking' }}

</button>

<a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">

    Cancel

</a>