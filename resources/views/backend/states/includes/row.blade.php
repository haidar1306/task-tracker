<tr>
    <td>
        {{ $row->id }}
    </td>

    <td>
        {{ $row->name }}
    </td>

    <td>
        {{ $row->country->name ?? 'N/A' }}
    </td>

    <td width="180">
        <a href="{{ route('admin.states.edit', $row->id) }}" class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('admin.states.destroy', $row->id) }}" method="POST" class="d-inline delete-state-form">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>

        </form>

        
    </td>
</tr>