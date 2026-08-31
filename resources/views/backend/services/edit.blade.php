@extends('backend.layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Service</h4>

        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.services.update', $service->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Title <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $service->title) }}">

                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icon Class</label>

                        <input type="text"
                               name="icon"
                               class="form-control"
                               placeholder="fas fa-spa"
                               value="{{ old('icon', $service->icon) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*"
                               onchange="previewImage(event)">

                        <div class="mt-3">
                            <img id="preview"
                                 src="{{ $service->image ? asset('uploads/services/'.$service->image) : '' }}"
                                 width="150"
                                 class="rounded border {{ $service->image ? '' : 'd-none' }}">
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Sort Order</label>

                        <input type="number"
                               name="sort_order"
                               class="form-control"
                               value="{{ old('sort_order', $service->sort_order) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $service->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('status', $service->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Short Description</label>

                        <textarea name="short_description"
                                  rows="3"
                                  class="form-control">{{ old('short_description', $service->short_description) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  id="description"
                                  rows="6"
                                  class="form-control">{{ old('description', $service->description) }}</textarea>
                    </div>

                </div>

                <div class="text-end">

                    <a href="{{ route('admin.services.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Service
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function previewImage(event) {

    let preview = document.getElementById('preview');

    preview.src = URL.createObjectURL(event.target.files[0]);

    preview.classList.remove('d-none');
}
</script>

{{-- Summernote / CKEditor --}}
{{-- $('#description').summernote({ height:250 }); --}}
@endsection