@props(['dismissable' => true, 'type' => 'success', 'ariaLabel' => __('Close')])

@php
    $labels = [
        'success' => 'Success',
        'danger' => 'Error',
        'warning' => 'Warning',
        'info' => 'Info',
    ];
    $label = $labels[$type] ?? ucfirst($type);
@endphp

<div {{ $attributes->merge(['class' => 'global-toast global-toast-'.$type]) }} role="alert">
    <div class="global-toast-content">
        <strong>{{ $label }}</strong>
        <div class="global-toast-body">{{ $slot }}</div>
    </div>

    @if ($dismissable)
        <button type="button" class="toast-close" aria-label="{{ $ariaLabel }}">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
</div>

<style>
    .global-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: min(360px, calc(100vw - 30px));
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 12px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        background: #ffffff;
        border-left: 5px solid #28a745;
        animation: globalToastSlideIn 0.25s ease;
        margin: 0;
        color: #1f2937;
    }

    .global-toast-success {
        border-left-color: #28a745;
        background: #edfdf3;
    }

    .global-toast-danger {
        border-left-color: #dc3545;
        background: #fff1f2;
    }

    .global-toast-warning {
        border-left-color: #ffc107;
        background: #fff8e6;
    }

    .global-toast-info {
        border-left-color: #17a2b8;
        background: #eefcff;
    }

    .global-toast-content {
        flex: 1;
        min-width: 0;
    }

    .global-toast-content strong {
        display: block;
        margin-bottom: 5px;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .global-toast-body {
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
    }

    .toast-close {
        border: none;
        background: transparent;
        color: #4b5563;
        font-size: 22px;
        cursor: pointer;
        line-height: 1;
        padding: 0 0 0 8px;
    }

    .toast-close:hover {
        color: #111827;
    }

    @keyframes globalToastSlideIn {
        from {
            opacity: 0;
            transform: translateX(24px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
