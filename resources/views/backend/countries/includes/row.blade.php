<tr wire:key="country-{{ $row->id }}">

    <td>
        {{ $row->id }}
    </td>

    <td>
        {{ $row->name }}
    </td>

    <td>
        {{ $row->iso }}
    </td>

    <td>
        <a href="{{ route('admin.countries.edit', $row) }}" class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('admin.countries.destroy', $row) }}" method="POST" class="d-inline">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure you want to delete this country?')">
                Delete
            </button>

        </form>
    </td>

</tr>