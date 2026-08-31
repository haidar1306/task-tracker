@extends('backend.layouts.app')

@section('title', 'General Settings')

@section('content')

<x-backend.card>
    <x-slot name="header">
        General Settings
    </x-slot>

    <x-slot name="body">

        <form action="{{ route('admin.website.general.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                {{-- Website Name --}}
                <div class="col-md-6 mb-3">
                    <label>Website Name</label>
                    <input type="text"
                           name="website_name"
                           class="form-control"
                           value="{{ old('website_name', $setting->website_name ?? '') }}">
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $setting->email ?? '') }}">
                </div>

                {{-- Phone --}}
                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone', $setting->phone ?? '') }}">
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="1"
                            {{ old('status', $setting->status ?? 1) ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('status', $setting->status ?? 1) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>
                </div>

                {{-- Address --}}
                <div class="col-md-12 mb-3">
                    <label>Address</label>

                    <textarea name="address"
                              rows="3"
                              class="form-control">{{ old('address', $setting->address ?? '') }}</textarea>
                </div>

                {{-- Copyright --}}
                <div class="col-md-12 mb-3">
                    <label>Copyright</label>

                    <input type="text"
                           name="copyright"
                           class="form-control"
                           value="{{ old('copyright', $setting->copyright ?? '') }}">
                </div>

                {{-- Website Logo --}}
                <div class="col-md-6 mb-4">
                    <label>Website Logo</label>

                    <input type="file"
                           name="website_logo"
                           class="form-control">

                    @if(!empty($setting->website_logo))
                        <img src="{{ asset('storage/'.$setting->website_logo) }}"
                             class="mt-3 rounded border"
                             width="180">
                    @endif
                </div>

                {{-- Favicon --}}
                <div class="col-md-6 mb-4">
                    <label>Favicon</label>

                    <input type="file"
                           name="favicon"
                           class="form-control">

                    @if(!empty($setting->favicon))
                        <img src="{{ asset('storage/'.$setting->favicon) }}"
                             class="mt-3 rounded border"
                             width="70">
                    @endif
                </div>

            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>

        </form>

    </x-slot>
</x-backend.card>

@endsection