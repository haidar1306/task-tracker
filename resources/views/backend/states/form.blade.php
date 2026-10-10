
<div class="mb-3">
    <label for="country_id" class="form-label">Country</label>

    <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror">

        <option value="">Select Country</option>

        @foreach ($countries as $country)
            <option value="{{ $country->id }}" {{ old('country_id', $state->country_id ?? '') == $country->id ? 'selected' : '' }}>
                {{ $country->name }}
            </option>
        @endforeach

    </select>

    @error('country_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="name" class="form-label">State Name</label>

    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $state->name ?? '') }}" placeholder="Enter state name">

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($state) ? 'Update State' : 'Save State' }}
</button>

<a href="{{ route('admin.states.index') }}" class="btn btn-secondary">
    Cancel
</a>