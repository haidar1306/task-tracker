@extends('backend.layouts.app')

@section('title', 'Hero Section')

@section('content')

    <x-backend.card>
        <x-slot name="header">
            Hero Section
        </x-slot>

        <x-slot name="body">

            <form action="{{ route('admin.website.hero.update') }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label>Badge</label>
                    <input type="text" name="badge" class="form-control" value="{{ old('badge', $hero->badge ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Heading</label>
                    <input type="text" name="heading" class="form-control"
                        value="{{ old('heading', $hero->heading ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Description</label>
                    <textarea name="description" rows="4"
                        class="form-control">{{ old('description', $hero->description ?? '') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Primary Button Text</label>
                    <input type="text" name="primary_button_text" class="form-control"
                        value="{{ old('primary_button_text', $hero->primary_button_text ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Primary Button Link</label>
                    <input type="text" name="primary_button_link" class="form-control"
                        value="{{ old('primary_button_link', $hero->primary_button_link ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Secondary Button Text</label>
                    <input type="text" name="secondary_button_text" class="form-control"
                        value="{{ old('secondary_button_text', $hero->secondary_button_text ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Secondary Button Link</label>
                    <input type="text" name="secondary_button_link" class="form-control"
                        value="{{ old('secondary_button_link', $hero->secondary_button_link ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Hero Image</label>

                    <input type="file" name="hero_image" class="form-control">

                    @if(!empty($hero->hero_image))
                        <img src="{{ asset('storage/' . $hero->hero_image) }}" width="180" class="mt-3 rounded border">
                    @endif
                </div>
                <div class="form-group mb-3">

                    <label>
                        Overlay Opacity
                        (<span id="overlayValue">
                            {{ old('overlay_opacity', $hero->overlay_opacity ?? 40) }}
                        </span>%)
                    </label>

                    <input type="range" class="form-range" min="0" max="100" name="overlay_opacity" id="overlayOpacity"
                        value="{{ old('overlay_opacity', $hero->overlay_opacity ?? 40) }}">

                </div>

                <script>
                    document.getElementById('overlayOpacity').addEventListener('input', function () {
                        document.getElementById('overlayValue').innerHTML = this.value;
                    });
                </script>

                <div class="form-group mb-3">
                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="1" {{ old('status', $hero->status ?? 1) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ old('status', $hero->status ?? 1) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>
                    <div class="form-group">
                        <label>Text Color</label>
                        <input type="color" name="text_color" class="form-control"
                            value="{{ old('text_color', $hero->text_color ?? '#ffffff') }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Background Image</label>

                    <input type="file" name="background_image" class="form-control">

                    @if(!empty($hero->background_image))
                        <img src="{{ asset('storage/' . $hero->background_image) }}" width="180" class="mt-3 rounded border">
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label>Background Color</label>

                    <input type="color" name="background_color" class="form-control"
                        value="{{ old('background_color', $hero->background_color ?? '#f5f8fb') }}">
                </div>

        </x-slot>

        <x-slot name="footer">
            <button type="submit" class="btn btn-primary">
                Save Hero Section
            </button>
            </form>
        </x-slot>

    </x-backend.card>

@endsection