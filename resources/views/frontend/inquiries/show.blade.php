@extends('frontend.layouts.app')

@section('title', 'My Inquiry')

@section('content')
<style>
   .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: #1f2937;        /* Dark Slate */
    color: #ffffff;
    border: 1px solid #1f2937;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.btn-back:hover {
    background: #d4af37;        /* Luxury Gold */
    border-color: #d4af37;
    color: #1f2937;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(212,175,55,0.35);
}

.btn-back:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(212,175,55,0.25);
}

.btn-back i {
    font-size: 14px;
}
    </style>

<div class="container py-5">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Inquiry Details
            </h4>
        </div>

        <div class="card-body">

            <div class="mb-4">
                <strong>Subject</strong>
                <p>{{ $inquiry->subject }}</p>
            </div>

            <div class="mb-4">
                <strong>Your Message</strong>
                <p>{{ $inquiry->message }}</p>
            </div>

            <div class="mb-4">

                <strong>Status</strong>

                @if($inquiry->reply)

                    <span class="badge badge-success">
                        Replied
                    </span>

                @else

                    <span class="badge badge-warning">
                        Pending
                    </span>

                @endif

            </div>

            @if($inquiry->reply)

                <div class="alert alert-success">

                    <h5>
                        Hotel Reply
                    </h5>

                    <hr>

                    <p class="mb-1">
                        {{ $inquiry->reply }}
                    </p>

                    @if($inquiry->replied_at)

                        <small class="text-muted">
                            Replied on :
                            {{ $inquiry->replied_at }}
                        </small>

                    @endif

                </div>

            @endif
            <div>
          <a href="{{ url()->previous() }}" class="btn-back">
    <i class="fas fa-arrow-left"></i>
    Back
</a>
            </div>
             </div>
    

        </div>

   

</div>

         


@endsection
