@if ($paginator->hasPages())

    @once
        <style>
            .lux-pagination {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 16px;
                margin: 32px 0 8px;
            }

            .lux-pagination-info {
                color: #8a8176;
                font-family: 'Jost', sans-serif;
                font-size: 13px;
                letter-spacing: .3px;
            }

            .lux-pagination-info strong {
                color: #2b2621;
                font-weight: 600;
            }

            .lux-pagination-list {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .lux-pagination-list li {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .lux-page-link {
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 42px;
                height: 42px;
                padding: 0 12px;
                border: 1px solid #e5dccb;
                border-radius: 8px;
                background: #fff;
                color: #3a342d;
                font-family: 'Jost', sans-serif;
                font-size: 14px;
                font-weight: 500;
                line-height: 1;
                text-decoration: none;
                transition: background .2s ease, border-color .2s ease, color .2s ease, transform .2s ease;
            }

            a.lux-page-link:hover {
                background: #faf5ea;
                border-color: #b68a35;
                color: #8f6a1f;
                transform: translateY(-1px);
            }

            .lux-page.active .lux-page-link {
                background: #b68a35;
                border-color: #b68a35;
                color: #fff;
                cursor: default;
            }

            .lux-page.disabled .lux-page-link {
                background: #f7f4ee;
                color: #c5bcae;
                cursor: not-allowed;
            }

            @media (max-width: 575px) {
                .lux-page-link {
                    min-width: 38px;
                    height: 38px;
                    font-size: 13px;
                }
            }
        </style>
    @endonce

    <nav class="lux-pagination" role="navigation" aria-label="Pagination">

        <div class="lux-pagination-info">
            Showing <strong>{{ $paginator->firstItem() }}</strong>
            to <strong>{{ $paginator->lastItem() }}</strong>
            of <strong>{{ $paginator->total() }}</strong> {{ $label ?? 'results' }}
        </div>

        <ul class="lux-pagination-list">

            @if ($paginator->onFirstPage())
                <li class="lux-page disabled" aria-disabled="true">
                    <span class="lux-page-link">&lsaquo;</span>
                </li>
            @else
                <li class="lux-page">
                    <a class="lux-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="Previous page">&lsaquo;</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="lux-page disabled"><span class="lux-page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="lux-page active" aria-current="page">
                                <span class="lux-page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="lux-page">
                                <a class="lux-page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="lux-page">
                    <a class="lux-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="Next page">&rsaquo;</a>
                </li>
            @else
                <li class="lux-page disabled" aria-disabled="true">
                    <span class="lux-page-link">&rsaquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif