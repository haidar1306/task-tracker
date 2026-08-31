@extends('frontend.layouts.app')

@section('title', __('Reset Password'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>

                    <x-slot name="header">
                        @lang('Reset Password')
                    </x-slot>

                    <x-slot name="body">

                        <x-forms.post :action="route('frontend.auth.password.update')">

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">
                                    @lang('E-mail Address')
                                </label>

                                <div class="col-md-6">
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="{{ old('email') }}"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">
                                    @lang('New Password')
                                </label>

                                <div class="col-md-6">
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">
                                    @lang('Confirm Password')
                                </label>

                                <div class="col-md-6">
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" type="submit">
                                        @lang('Reset Password')
                                    </button>
                                </div>
                            </div>

                        </x-forms.post>

                    </x-slot>

                </x-frontend.card>
            </div>
        </div>
    </div>
@endsection