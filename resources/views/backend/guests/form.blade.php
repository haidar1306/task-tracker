<div class="row">

    <div class="col-md-6 mb-3">
        <label>First Name</label>
        <input type="text"
               name="first_name"
               class="form-control"
               value="{{ old('first_name',$guest->first_name ?? '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input type="text"
               name="last_name"
               class="form-control"
               value="{{ old('last_name',$guest->last_name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email',$guest->email ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="{{ old('phone',$guest->phone ?? '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Gender</label>

        <select name="gender" class="form-control">

            <option value="">Select Gender</option>

            <option value="Male"
                {{ old('gender',$guest->gender ?? '')=='Male'?'selected':'' }}>
                Male
            </option>

            <option value="Female"
                {{ old('gender',$guest->gender ?? '')=='Female'?'selected':'' }}>
                Female
            </option>

            <option value="Other"
                {{ old('gender',$guest->gender ?? '')=='Other'?'selected':'' }}>
                Other
            </option>

        </select>

    </div>

    <div class="col-md-6 mb-3">
        <label>Date Of Birth</label>

        <input type="date"
               name="dob"
               class="form-control"
               value="{{ old('dob',isset($guest) && $guest->dob ? $guest->dob->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-12 mb-3">
        <label>Address</label>

        <textarea name="address"
                  class="form-control"
                  rows="3">{{ old('address',$guest->address ?? '') }}</textarea>
    </div>

    <div class="col-md-4 mb-3">
        <label>City</label>

        <input type="text"
               name="city"
               class="form-control"
               value="{{ old('city',$guest->city ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>State</label>

        <input type="text"
               name="state"
               class="form-control"
               value="{{ old('state',$guest->state ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Country</label>

        <input type="text"
               name="country"
               class="form-control"
               value="{{ old('country',$guest->country ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Zip Code</label>

        <input type="text"
               name="zip_code"
               class="form-control"
               value="{{ old('zip_code',$guest->zip_code ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>ID Proof Type</label>

        <input type="text"
               name="id_proof_type"
               class="form-control"
               value="{{ old('id_proof_type',$guest->id_proof_type ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>ID Proof Number</label>

        <input type="text"
               name="id_proof_number"
               class="form-control"
               value="{{ old('id_proof_number',$guest->id_proof_number ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">

        <label>Status</label>

        <select name="status" class="form-control">

            <option value="1"
                {{ old('status',$guest->status ?? 1)==1?'selected':'' }}>
                Active
            </option>

            <option value="0"
                {{ old('status',$guest->status ?? 1)==0?'selected':'' }}>
                Inactive
            </option>

        </select>

    </div>

</div>

<hr>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i>
    {{ isset($guest) ? 'Update Guest' : 'Save Guest' }}
</button>

<a href="{{ route('admin.guests.index') }}" class="btn btn-secondary">
    Cancel
</a>