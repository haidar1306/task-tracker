<tr wire:key="state-mgmt-row-{{ $row->id }}">
    <td>
        {{ $row->id }}
    </td>

    <td>
        {{ $row->name }}
    </td>

    <td>
        {{-- Ye buttons page ke existing jQuery (.edit-state / .delete-state) se chalte hain --}}
        <button type="button"
                class="btn btn-sm btn-warning edit-state"
                data-id="{{ $row->id }}"
                data-name="{{ $row->name }}">
            Edit
        </button>

        <button type="button"
                class="btn btn-sm btn-danger delete-state"
                data-id="{{ $row->id }}">
            Delete
        </button>
    </td>
</tr>