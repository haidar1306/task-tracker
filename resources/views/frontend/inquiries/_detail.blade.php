@php $replied = $inquiry->is_replied; @endphp

<div class="iq-d-top">
    <span class="iq-d-id">Inquiry #{{ $inquiry->id }}</span>
    <span class="iq-badge {{ $replied ? 'replied' : 'pending' }}">{{ $replied ? 'Replied' : 'Pending' }}</span>
</div>

<h3 class="iq-d-subject">{{ $inquiry->subject }}</h3>

<ol class="iq-timeline">
    <li class="done">
        <strong>Sent</strong>
        <span>{{ $inquiry->created_at->format('d M Y, h:i A') }}</span>
    </li>
    <li class="{{ $replied ? 'done' : 'wait' }}">
        <strong>{{ $replied ? 'Replied' : 'Waiting for reply' }}</strong>
        <span>{{ $replied && $inquiry->replied_at ? $inquiry->replied_at->format('d M Y, h:i A') : 'Our team will respond shortly' }}</span>
    </li>
</ol>

<div class="iq-d-block">
    <span class="iq-d-label">Your message</span>
    <div class="iq-d-msg">{!! nl2br(e($inquiry->message)) !!}</div>
</div>

@if($replied)
    <div class="iq-d-reply">
        <span class="iq-d-label"><i class="fas fa-concierge-bell"></i> Hotel reply</span>
        <p>{!! nl2br(e($inquiry->reply)) !!}</p>
    </div>
@endif

<div class="iq-d-actions">
    <a href="{{ route('frontend.contact') }}" class="iq-btn-outline"><i class="fas fa-envelope"></i> Send new inquiry</a>
</div>