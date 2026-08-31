<div class="form-group">

    <label>Name</label>

    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name',$roomStatus->name ?? '') }}"
           required>

</div>

<div class="form-group">

    <label>Color</label>

    <select name="color" class="form-control">

        <option value="success" {{ old('color',$roomStatus->color ?? 'success')=='success' ? 'selected' : '' }}>Green</option>

        <option value="primary" {{ old('color',$roomStatus->color ?? '')=='primary' ? 'selected' : '' }}>Blue</option>

        <option value="warning" {{ old('color',$roomStatus->color ?? '')=='warning' ? 'selected' : '' }}>Yellow</option>

        <option value="danger" {{ old('color',$roomStatus->color ?? '')=='danger' ? 'selected' : '' }}>Red</option>

        <option value="secondary" {{ old('color',$roomStatus->color ?? '')=='secondary' ? 'selected' : '' }}>Gray</option>

        <option value="info" {{ old('color',$roomStatus->color ?? '')=='info' ? 'selected' : '' }}>Sky Blue</option>

    </select>

</div>

<div class="form-group">

    <label>Description</label>

    <textarea name="description"
              rows="4"
              class="form-control">{{ old('description',$roomStatus->description ?? '') }}</textarea>

</div>

<div class="form-group">

    <label>Status</label>

    <select name="status" class="form-control">

        <option value="1"
            {{ old('status',$roomStatus->status ?? 1)==1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0"
            {{ old('status',$roomStatus->status ?? '')==0 ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

</div>

<div class="mt-4">

    <button class="btn btn-primary">

        <i class="fas fa-save"></i>

        {{ isset($roomStatus) ? 'Update Room Status' : 'Save Room Status' }}

    </button>

    <a href="{{ route('admin.room-statuses.index') }}"
       class="btn btn-secondary">

        Cancel

    </a>

</div>