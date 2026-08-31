@extends('backend.layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Add Service</h4>

        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Back
</a>

      
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.services.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>

                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}">

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
                               value="{{ old('icon') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*"
                               onchange="previewImage(event)">

                        <img id="preview"
                             src=""
                             class="mt-3 rounded border"
                             width="150"
                             style="display:none;">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Sort Order</label>

                        <input type="number"
                               name="sort_order"
                               class="form-control"
                               value="{{ old('sort_order',0) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Short Description</label>

                        <textarea name="short_description"
                                  rows="3"
                                  class="form-control">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  id="description"
                                  rows="6"
                                  class="form-control">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="text-end">

                    <a href="{{ route('admin.services.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Service
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function previewImage(event){
    const preview=document.getElementById('preview');
    preview.src=URL.createObjectURL(event.target.files[0]);
    preview.style.display='block';
}
</script>

{{-- Summernote / CKEditor init yahan kar sakte ho --}}
{{-- $('#description').summernote({height:250}); --}}
@endsection