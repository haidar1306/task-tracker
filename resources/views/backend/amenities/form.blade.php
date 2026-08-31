<div class="form-group">

    <label>Name</label>

    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name',$amenity->name ?? '') }}"
           required>

</div>


<div class="form-group">

    <label>Description</label>

    <textarea name="description"
              rows="4"
              class="form-control">{{ old('description',$amenity->description ?? '') }}</textarea>

</div>


<div class="form-group">

    <label>Status</label>

    <select name="status"
            class="form-control">

        <option value="1"
            {{ old('status',$amenity->status ?? 1)==1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0"
            {{ old('status',$amenity->status ?? '')==0 ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

</div>


<div class="mt-4">

    <button class="btn btn-primary">

        <i class="fas fa-save"></i>

        {{ isset($amenity) ? 'Update Amenity' : 'Save Amenity' }}

    </button>

    <a href="{{ route('admin.amenities.index') }}"
       class="btn btn-secondary">

        Cancel

    </a>

</div>