<div class="card">
    @if (isset($header))
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                {{ $header }}
            </div>

            @if (isset($headerActions))
                <div class="card-header-actions">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    @if (isset($body))
        <div class="card-body">
            {{ $body }}
        </div>
    @endif

    @if (isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>