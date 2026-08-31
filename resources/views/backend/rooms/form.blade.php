<div class="form-group">
    
    <label>Room Number</label>

    <input type="text"
           name="room_number"
           class="form-control @error('room_number') is-invalid @enderror"
           value="{{ old('room_number', $room->room_number ?? '') }}"
           required>

    @error('room_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label>Room Type</label>

    <select name="room_type_id"
            class="form-control @error('room_type_id') is-invalid @enderror"
            required>

        <option value="">Select Room Type</option>

        @foreach($roomTypes as $roomType)

            <option value="{{ $roomType->id }}"
                {{ old('room_type_id', $room->room_type_id ?? '') == $roomType->id ? 'selected' : '' }}>

                {{ $roomType->name }}

            </option>

        @endforeach

    </select>

    @error('room_type_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label>Floor</label>

    <input type="number"
           name="floor"
           class="form-control @error('floor') is-invalid @enderror"
           value="{{ old('floor', $room->floor ?? '') }}"
           required>

    @error('floor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label>Status</label>

    <select name="status"
            class="form-control @error('status') is-invalid @enderror">

        <option value="available"
            {{ old('status', $room->status ?? 'available') == 'available' ? 'selected' : '' }}>
            Available
        </option>

        <option value="occupied"
            {{ old('status', $room->status ?? '') == 'occupied' ? 'selected' : '' }}>
            Occupied
        </option>

        <option value="maintenance"
            {{ old('status', $room->status ?? '') == 'maintenance' ? 'selected' : '' }}>
            Maintenance
        </option>

    </select>


    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mt-4">

    <label>
        Amenities
    </label>

    <div class="row">

        @foreach($amenities as $amenity)

            <div class="col-md-4 mb-2">

                <div class="form-check">

                    <input 
                    class="form-check-input"
                    type="checkbox"
                    name="amenities[]"
                    value="{{ $amenity->id }}"

                    {{ isset($room) && $room->amenities->contains($amenity->id)
                        ? 'checked'
                        : '' }}

                    >

                    <label class="form-check-label">
                        {{ $amenity->name }}
                    </label>

                </div>

            </div>

        @endforeach

    </div>

</div>


<div class="mt-4">

    <button class="btn btn-primary">
        <i class="fas fa-save"></i>

        {{ isset($room) ? 'Update Room' : 'Save Room' }}

    </button>

    <a href="{{ route('admin.rooms.index') }}"
       class="btn btn-secondary">

        Cancel

    </a>

</div>