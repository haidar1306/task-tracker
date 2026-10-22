@extends('backend.layouts.app')

@section('title', 'View Guest')

@section('content')
<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Guest Details
        </h6>

        <div>
            <a href="{{ route('admin.guests.edit', $guest) }}"
               class="btn btn-info btn-sm">
                <i class="fas fa-edit"></i> Edit Guest
            </a>

            <a href="{{ route('admin.guests.index') }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        @include('includes.partials.messages')

        <div class="row">

            <div class="col-md-6 mb-3">
                <strong>First Name:</strong>
                <p>{{ $guest->first_name ?? '' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Last Name:</strong>
                <p>{{ $guest->last_name ?? '' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Email:</strong>
                <p>{{ $guest->email ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Phone:</strong>
                <p>{{ $guest->phone ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Gender:</strong>
                <p>{{ $guest->gender ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Date Of Birth:</strong>
                <p>
                    {{ $guest->date_of_birth
                        ? \Carbon\Carbon::parse($guest->date_of_birth)->format('d-m-Y')
                        : 'N/A' }}
                </p>
            </div>

            <div class="col-md-12 mb-3">
                <strong>Address:</strong>
                <p>{{ $guest->address ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>City:</strong>
                <p>{{ $guest->city ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>State:</strong>
                <p>{{ $guest->state ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Country:</strong>
                <p>{{ $guest->country ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Zip Code:</strong>
                <p>{{ $guest->zip_code ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>ID Proof Type:</strong>
                <p>{{ $guest->id_proof_type ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>ID Proof Number:</strong>
                <p>{{ $guest->id_proof_number ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Status:</strong>
                <p>
                    @if($guest->status)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </p>
            </div>

        </div>
    </div>
</div>
@endsection