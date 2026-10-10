<div>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="d-flex" style="width: 300px;">

            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                placeholder="Search hotel...">
            @if($search)
                <button type="button" wire:click="clearSearch" class="btn btn-outline-secondary ms-2">
                    ×
                </button>
            @endif

        </div>

        <div>
            <select wire:model.live="perPage" class="form-select" style="width: 60px;">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}">
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="table-responsive">

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Country
                    </th>
                    <th>
                        State
                    </th>
                    <th>
                        City
                    </th>
                    <th>
                        Hotel Name
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse($hotels as $hotel)
                    <tr>
                        <td>
                            {{ $hotel->id }}
                        </td>
                        <td>
                            {{ $hotel->country->name ?? '-' }}
                        </td>
                        <td>
                            {{ $hotel->state->name ?? '-' }}
                        </td>
                        <td>
                            {{ $hotel->city->name ?? '-' }}
                        </td>
                        <td>
                            {{ $hotel->name }}
                        </td>
                        <td>

                            <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-primary">
                                Edit
                            </a>

                            <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this hotel?')">
                                    Delete
                                </button>
                            </form>
                        </td>       
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-search fa-2x mb-3"></i>
                                <h5>No Hotels Found</h5>
                                <p class="mb-0">
                                    Please check your search keyword and try again.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- <script>
                            Swal.fire({
                                icon: 'info',
                                title: 'No Hotels Found',
                                text: 'Please check your search keyword and try again.',
                                confirmButtonText: 'Okay'
                            });
                        </script> -->
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="text-muted">
            Showing
            {{ $hotels->firstItem() ?? 0 }}
            -
            {{ $hotels->lastItem() ?? 0 }}
            of
            {{ $hotels->total() }}
            results
        </div>

        <div>
            {{ $hotels->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>