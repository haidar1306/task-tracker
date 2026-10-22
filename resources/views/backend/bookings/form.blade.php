@php
    $isEdit = isset($booking);
    $editable = !$isEdit || $booking->isEditable();
    $lock = $editable ? '' : 'disabled';
@endphp

@unless($editable)
    <div class="alert alert-info">
        This booking is <strong>{{ $booking->booking_status }}</strong>. Only payment status, remarks and active flag can be
        changed.
    </div>
@endunless

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Guest</label>
        <select name="guest_id" class="form-control @error('guest_id') is-invalid @enderror" required {{ $lock }}>
            <option value="">Select Guest</option>
            @foreach($guests as $guest)
                <option value="{{ $guest->id }}" {{ old('guest_id', $booking->guest_id ?? '') == $guest->id ? 'selected' : '' }}>
                    {{ $guest->first_name }} {{ $guest->last_name }}
                </option>
            @endforeach
        </select>
        @error('guest_id')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Room</label>
        <select name="room_id" id="room_id" class="form-control @error('room_id') is-invalid @enderror" required {{ $lock }}>
            <option value="">Select Room</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" data-price="{{ $room->roomType->price ?? 0 }}" {{ old('room_id', $booking->room_id ?? '') == $room->id ? 'selected' : '' }}>
                    {{ $room->room_number }} @if($room->roomType) - {{ $room->roomType->name }} @endif
                </option>
            @endforeach
        </select>
        @error('room_id')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Check In</label>
        <input type="date" name="check_in" id="check_in" class="form-control @error('check_in') is-invalid @enderror"
            @unless($isEdit) min="{{ today()->toDateString() }}" @endunless
            value="{{ old('check_in', $isEdit ? $booking->check_in->format('Y-m-d') : '') }}" required {{ $lock }}>
        @error('check_in')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Check Out</label>
        <input type="date" name="check_out" id="check_out" class="form-control @error('check_out') is-invalid @enderror"
            value="{{ old('check_out', $isEdit ? $booking->check_out->format('Y-m-d') : '') }}" required {{ $lock }}>
        @error('check_out')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Adults</label>
        <input type="number" name="adults" min="1" max="20" class="form-control @error('adults') is-invalid @enderror"
            value="{{ old('adults', $booking->adults ?? 1) }}" required {{ $lock }}>
        @error('adults')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Children</label>
        <input type="number" name="children" min="0" max="20"
            class="form-control @error('children') is-invalid @enderror"
            value="{{ old('children', $booking->children ?? 0) }}" {{ $lock }}>
        @error('children')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Total Amount <small class="text-muted">(room price x nights, server par calculate hota
                hai)</small></label>
        <input type="text" id="total_preview" class="form-control" readonly
            value="{{ $isEdit ? '₹' . number_format($booking->total_amount, 2) : '' }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Booking Status</label>
        @if($isEdit)
            <div>
                <span class="badge badge-{{ $booking->badgeClass() }}"
                    style="font-size:14px;">{{ $booking->booking_status }}</span>
                <small class="text-muted d-block mt-1">Status ab sirf booking page ke action buttons se badlega.</small>
            </div>
        @else
            <select name="booking_status" class="form-control @error('booking_status') is-invalid @enderror">
                <option value="Pending" {{ old('booking_status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ old('booking_status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
            </select>
            @error('booking_status')
            <div class="invalid-feedback">{{ $message }}</div> @enderror
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label>Payment Status</label>
        <select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
            @foreach(\App\Models\Booking::PAYMENT_STATUSES as $pay)
                <option value="{{ $pay }}" {{ old('payment_status', $booking->payment_status ?? 'Pending') == $pay ? 'selected' : '' }}>{{ $pay }}</option>
            @endforeach
        </select>
        @error('payment_status')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
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
        <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror"
            rows="4">{{ old('remarks', $booking->remarks ?? '') }}</textarea>
        @error('remarks')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i>
    {{ $isEdit ? 'Update Booking' : 'Save Booking' }}
</button>

<a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>

<script>
    (function () {
        const room = document.getElementById('room_id');
        const inEl = document.getElementById('check_in');
        const outEl = document.getElementById('check_out');
        const out = document.getElementById('total_preview');

        if (!room || !inEl || !outEl || !out) return;

        function preview() {
            const opt = room.options[room.selectedIndex];
            const price = parseFloat(opt ? opt.getAttribute('data-price') : 0) || 0;

            if (!inEl.value || !outEl.value || price <= 0) return;

            const nights = Math.round((new Date(outEl.value) - new Date(inEl.value)) / 86400000);

            if (nights > 0) {
                out.value = '₹' + (price * nights).toLocaleString('en-IN', { minimumFractionDigits: 2 });
            }
        }

        [room, inEl, outEl].forEach(function (el) { el.addEventListener('change', preview); });
    })();
</script>