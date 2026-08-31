<div class="form-group mb-3">
    <label for="name">Room Type Name</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $roomType->name ?? '') }}" required>

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="capacity">Capacity</label>
    <input type="number" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror"
        value="{{ old('capacity', $roomType->capacity ?? '') }}" required>

    @error('capacity')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="price">Price</label>
    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
        value="{{ old('price', $roomType->price ?? '') }}" required>

    @error('price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label>Room Image</label>

    <input type="file" name="image" class="form-control">
</div>
@if(isset($roomType) && $roomType->image)

    <div class="mt-3">

        <img src="{{ asset('storage/'.$roomType->image) }}"
             width="150"
             class="img-thumbnail">

    </div>

@endif

<div class="form-group mb-3">
    <label for="description">Description</label>
    <textarea name="description" id="description" rows="4"
        class="form-control @error('description') is-invalid @enderror">{{ old('description', $roomType->description ?? '') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-4">
    <label for="status">Status</label>

    <select name="status" id="status" class="form-control">
        <option value="1" {{ old('status', $roomType->status ?? 1) == 1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0" {{ old('status', $roomType->status ?? 1) == 0 ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($roomType) ? 'Update Room Type' : 'Create Room Type' }}
</button>

<a href="{{ route('admin.room-types.index') }}" class="btn btn-secondary">
    Cancel
</a>