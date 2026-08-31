@extends('frontend.layouts.app')

@section('title', 'My Notifications')

@section('content')

<div class="container py-5">

    <h3 class="mb-4">
        My Notifications
    </h3>

    @forelse($notifications as $notification)

        <div class="card mb-3 shadow-sm">

            <div class="card-body">

                <h5>
                    {{ $notification->data['title'] ?? 'Notification' }}
                </h5>

                <p class="mb-1">
                    {{ $notification->data['message'] ?? '' }}
                </p>

                <small class="text-muted">
                    {{ $notification->created_at->diffForHumans() }}
                </small>

            </div>

        </div>

    @empty

        <div class="alert alert-info">
            No Notifications Found.
        </div>

    @endforelse

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

</div>

@endsection