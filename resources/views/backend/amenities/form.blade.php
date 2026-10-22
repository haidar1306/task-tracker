@php
    $isEdit = isset($amenity) && $amenity->exists;
@endphp

{{-- Name --}}
<div class="form-group mb-3">
    <label for="name" class="form-label">
        Amenity Name <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="name"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $amenity->name ?? '') }}"
        placeholder="e.g. Free WiFi"
        maxlength="100"
        required
    >

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Description --}}
<div class="form-group mb-3">
    <label for="description" class="form-label">Description</label>

    <textarea
        name="description"
        id="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Enter amenity description"
    >{{ old('description', $amenity->description ?? '') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Image URL --}}
<div class="form-group mb-3">
    <label for="image" class="form-label">Image URL</label>

    <input
        type="url"
        name="image"
        id="image"
        class="form-control @error('image') is-invalid @enderror"
        value="{{ old('image', $amenity->image ?? '') }}"
        placeholder="https://example.com/amenity.jpg"
        maxlength="500"
    >

    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(!empty(old('image', $amenity->image ?? '')))
        <div class="mt-3">
            <img
                src="{{ old('image', $amenity->image ?? '') }}"
                alt="Amenity image preview"
                style="width: 180px; height: 110px; object-fit: cover; border-radius: 8px;"
                onerror="this.style.display='none';"
            >
        </div>
    @endif
</div>

{{-- Icon --}}
<div class="form-group mb-3">
    <label for="icon" class="form-label">Font Awesome Icon</label>

    <input
        type="text"
        name="icon"
        id="icon"
        class="form-control @error('icon') is-invalid @enderror"
        value="{{ old('icon', $amenity->icon ?? '') }}"
        placeholder="e.g. wifi, dumbbell, car"
        maxlength="100"
    >

    @error('icon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <small class="text-muted">
        Enter the icon name without the "fas fa-" prefix.
    </small>
</div>

{{-- Tag --}}
<div class="form-group mb-3">
    <label for="tag" class="form-label">Tag</label>

    <input
        type="text"
        name="tag"
        id="tag"
        class="form-control @error('tag') is-invalid @enderror"
        value="{{ old('tag', $amenity->tag ?? '') }}"
        placeholder="e.g. Complimentary, Premium, 24/7"
        maxlength="100"
    >

    @error('tag')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Status --}}
<div class="form-group mb-4">
    <label for="status" class="form-label">Status</label>

    <select
        name="status"
        id="status"
        class="form-control @error('status') is-invalid @enderror"
        required
    >
        <option value="1"
            {{ (string) old('status', $amenity->status ?? 1) === '1' ? 'selected' : '' }}>
            Active
        </option>

        <option value="0"
            {{ (string) old('status', $amenity->status ?? 1) === '0' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>

    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Buttons --}}
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('admin.amenities.index') }}"
       class="btn btn-light border">
        Cancel
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i>
        {{ $isEdit ? 'Update Amenity' : 'Create Amenity' }}
    </button>
</div>