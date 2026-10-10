<tr>
    <td>
        {{ $row->id }}
    </td>

    <td>
        {{ $row->country->name ?? 'N/A' }}
    </td>

    <td>
        {{ $row->state->name ?? 'N/A' }}
    </td>

    <td>
        {{ $row->name }}
    </td>

    <td>
        <a href="{{ route('admin.cities.edit', $row->id) }}" class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('admin.cities.destroy', $row->id) }}" method="POST" class="d-inline delete-state-form">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>

        </form>
    </td>
</tr>