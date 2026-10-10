<div class="mb-3">
    <label for="name" class="form-label">Country Name</label>

    <input type="text"
           name="name"
           id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $country->name ?? '') }}"
           placeholder="Enter country name">

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="iso" class="form-label">ISO Code</label>

    <input type="text"
           name="iso"
           id="iso"
           class="form-control @error('iso') is-invalid @enderror"
           value="{{ old('iso', $country->iso ?? '') }}"
           placeholder="e.g. IN"
           maxlength="2">

    @error('iso')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($country) ? 'Update Country' : 'Save Country' }}
</button>

<a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
    Cancel
</a>
