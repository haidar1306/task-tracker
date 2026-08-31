<div class="form-group">

    <label>Name</label>

    <input type="text"
        name="name"
        class="form-control"
        value="{{ old('name',$bedType->name ?? '') }}"
        required>

</div>

<div class="form-group">

    <label>Description</label>

    <textarea
        name="description"
        rows="4"
        class="form-control">{{ old('description',$bedType->description ?? '') }}</textarea>

</div>

<div class="form-group">

    <label>Status</label>

    <select
        name="status"
        class="form-control">

        <option value="1"
            {{ old('status',$bedType->status ?? 1)==1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0"
            {{ old('status',$bedType->status ?? '')==0 ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

</div>

<div class="mt-4">

    <button class="btn btn-primary">

        <i class="fas fa-save"></i>

        {{ isset($bedType) ? 'Update Bed Type' : 'Save Bed Type' }}

    </button>

    <a href="{{ route('admin.bed-types.index') }}"
        class="btn btn-secondary">

        Cancel

    </a>

</div>