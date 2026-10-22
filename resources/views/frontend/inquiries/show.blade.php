@extends('frontend.layouts.apps')

@section('title', 'My Inquiry')

@push('after-styles')
<style>
    .inquiry-page {
        padding: 70px 0 90px;
        background: #f7f2ea;
        min-height: 70vh;
    }

    .inquiry-card {
        max-width: 860px;
        margin: 0 auto;
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        box-shadow: 0 18px 40px rgba(43, 38, 33, .08);
        overflow: hidden;
    }

    /* Header */
    .inquiry-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        padding: 30px 36px;
        border-bottom: 1px solid #eee2d0;
    }

    .inquiry-kicker {
        display: block;
        margin-bottom: 6px;
        color: #a9825c;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .inquiry-head h1 {
        margin: 0;
        color: #2b2621;
        font-family: 'Playfair Display', serif;
        font-size: 30px;
        font-weight: 700;
    }

    /* Status badge */
    .inquiry-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 30px;
        font-family: 'Jost', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .inquiry-status::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .inquiry-status.replied {
        background: #eef7ee;
        color: #2e6b34;
        border: 1px solid #b9dcb9;
    }

    .inquiry-status.pending {
        background: #fdf6e7;
        color: #8f6a1f;
        border: 1px solid #ecd9a8;
    }

    /* Body */
    .inquiry-body {
        padding: 34px 36px 38px;
    }

    .inquiry-field {
        margin-bottom: 26px;
    }

    .inquiry-label {
        display: block;
        margin-bottom: 8px;
        color: #8a7f6f;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.6px;
        text-transform: uppercase;
    }

    .inquiry-value {
        margin: 0;
        color: #2b2621;
        font-family: 'Jost', sans-serif;
        font-size: 16px;
        line-height: 1.8;
        word-break: break-word;
    }

    .inquiry-message {
        padding: 18px 20px;
        background: #f7f2ea;
        border: 1px solid #e5dccb;
        border-radius: 10px;
    }

    .inquiry-meta {
        margin-top: 8px;
        color: #a39886;
        font-family: 'Jost', sans-serif;
        font-size: 12px;
    }

    /* Hotel reply */
    .inquiry-reply {
        margin-top: 30px;
        padding: 24px 26px;
        background: #fbf7ef;
        border: 1px solid #e5dccb;
        border-left: 4px solid #a9825c;
        border-radius: 10px;
    }

    .inquiry-reply h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 14px;
        color: #2b2621;
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
    }

    .inquiry-reply h2 i {
        color: #a9825c;
        font-size: 17px;
    }

    .inquiry-reply .inquiry-value {
        font-size: 15px;
    }

    .inquiry-reply .inquiry-meta {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed #e5dccb;
    }

    /* Waiting note */
    .inquiry-waiting {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-top: 30px;
        padding: 16px 20px;
        background: #fdf6e7;
        border: 1px solid #ecd9a8;
        border-radius: 10px;
        color: #7a5d1c;
        font-family: 'Jost', sans-serif;
        font-size: 14px;
        line-height: 1.6;
    }

    .inquiry-waiting i {
        margin-top: 3px;
    }

    /* Footer */
    .inquiry-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 34px;
        padding-top: 26px;
        border-top: 1px solid #eee2d0;
    }

    .btn-back,
    .btn-outline-lux {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 26px;
        border-radius: 8px;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        transition: .25s ease;
    }

    .btn-back {
        background: #2b2621;
        border: 1px solid #2b2621;
        color: #fff;
    }

    .btn-back:hover {
        background: #a9825c;
        border-color: #a9825c;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-outline-lux {
        background: transparent;
        border: 1px solid #a9825c;
        color: #a9825c;
    }

    .btn-outline-lux:hover {
        background: #a9825c;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    @media (max-width: 575px) {
        .inquiry-page { padding: 30px 0 60px; }
        .inquiry-head,
        .inquiry-body { padding-left: 20px; padding-right: 20px; }
        .inquiry-head h1 { font-size: 24px; }
        .btn-back, .btn-outline-lux { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
    @php
        $isReplied = !empty($inquiry->reply);
        $backUrl   = url()->previous() !== url()->current()
            ? url()->previous()
            : route('frontend.contact');
    @endphp

    <section class="inquiry-page">
        <div class="container">

            <div class="inquiry-card">

                <div class="inquiry-head">
                    <div>
                        <span class="inquiry-kicker">Inquiry #{{ $inquiry->id }}</span>
                        <h1>Inquiry Details</h1>
                    </div>

                    <span class="inquiry-status {{ $isReplied ? 'replied' : 'pending' }}">
                        {{ $isReplied ? 'Replied' : 'Pending' }}
                    </span>
                </div>

                <div class="inquiry-body">

                    <div class="inquiry-field">
                        <span class="inquiry-label">Subject</span>
                        <p class="inquiry-value">{{ $inquiry->subject }}</p>
                        @if($inquiry->created_at)
                            <div class="inquiry-meta">
                                Sent on {{ $inquiry->created_at->format('d M Y, h:i A') }}
                            </div>
                        @endif
                    </div>

                    <div class="inquiry-field">
                        <span class="inquiry-label">Your Message</span>
                        <div class="inquiry-message">
                            <p class="inquiry-value">{!! nl2br(e($inquiry->message)) !!}</p>
                        </div>
                    </div>

                    @if($isReplied)
                        <div class="inquiry-reply">
                            <h2><i class="fas fa-concierge-bell"></i> Hotel Reply</h2>

                            <p class="inquiry-value">{!! nl2br(e($inquiry->reply)) !!}</p>

                            @if($inquiry->replied_at)
                                <div class="inquiry-meta">
                                    Replied on
                                    {{ \Carbon\Carbon::parse($inquiry->replied_at)->format('d M Y, h:i A') }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="inquiry-waiting">
                            <i class="fas fa-clock"></i>
                            <span>
                                Our team has received your message and will reply shortly.
                                You will be notified as soon as we respond.
                            </span>
                        </div>
                    @endif

                    <div class="inquiry-actions">
                        <a href="{{ $backUrl }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>

                        <a href="{{ route('frontend.contact') }}" class="btn-outline-lux">
                            <i class="fas fa-envelope"></i> New Inquiry
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection