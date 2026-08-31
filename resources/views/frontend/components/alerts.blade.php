@if(request()->has('success'))
    <div class="global-toast global-toast-success" role="alert">
        <div class="global-toast-content">
            <strong>✔ Success</strong>
            <div class="global-toast-body">{{ request('success') }}</div>
        </div>
        <button type="button" class="toast-close" aria-label="Close">×</button>
    </div>
@endif
