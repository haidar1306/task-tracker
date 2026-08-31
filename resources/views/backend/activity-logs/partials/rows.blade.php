@forelse($activityLogs as $log)

    <tr>

        <td>{{ $log->id }}</td>

        <td>
            {{ optional($log->user)->name ?? 'N/A' }}
        </td>

        <td>

            <span class="badge badge-info">
                {{ $log->module }}
            </span>

        </td>

        <td>

            @php

                $color = 'secondary';

                switch ($log->action) {

                    case 'Created':
                        $color = 'success';
                        break;

                    case 'Updated':
                        $color = 'warning';
                        break;

                    case 'Deleted':
                        $color = 'danger';
                        break;

                    case 'Confirmed':
                        $color = 'primary';
                        break;

                    case 'Checked In':
                        $color = 'success';
                        break;

                    case 'Checked Out':
                        $color = 'dark';
                        break;

                    case 'Generated':
                        $color = 'info';
                        break;

                    case 'Submitted':
                        $color = 'primary';
                        break;

                    case 'Replied':
                        $color = 'success';
                        break;

                    case 'Partial Payment':
                        $color = 'warning';
                        break;

                    case 'Full Payment':
                        $color = 'success';
                        break;
                }

            @endphp

            <span class="badge badge-{{ $color }}">
                {{ $log->action }}
            </span>

        </td>
        <td>

            @if(!empty($search))

                {!! preg_replace(
                    '/' . preg_quote($search, '/') . '/i',
                    '<mark style="background:#fff9c4;color:#000;padding:2px 4px;border-radius:4px;font-weight:600;">$0</mark>',
                    e($log->description)
                ) !!}

            @else

                {{ $log->description }}

            @endif

        </td>

        <td>

            {{ $log->ip_address }}

        </td>

        <td>

            {{ $log->created_at->format('d M Y h:i A') }}

        </td>

    </tr>

@empty

    <tr>

        <td colspan="7" class="text-center py-5">

            <i class="fas fa-history fa-3x text-muted mb-3"></i>

            <br>

            No Activity Found

        </td>

    </tr>

@endforelse