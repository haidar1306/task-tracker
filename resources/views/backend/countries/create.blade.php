@extends('backend.layouts.app')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Create Country</h2>

            <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.countries.store') }}" method="POST">
                    @csrf

                    @include('backend.countries.form')
                </form>
            </div>
        </div>
    </div>
@endsection