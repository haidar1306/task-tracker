<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div style="max-width: 300px;">
            <input type="text" wire:model.live.debounce.400ms="search" class="form-control" placeholder="Search">
        </div>
        <div>
            <select wire:model.live="perPage" class="form-select">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="25">25</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th wire:click="sortBy('id')" style="cursor:pointer">
                        # @if ($sortField === 'id') <i
                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @else <i
                            class="fas fa-sort"></i> @endif
                    </th>
                    <th wire:click="sortBy('country')" style="cursor:pointer">
                        Country @if ($sortField === 'country') <i
                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @else <i
                            class="fas fa-sort"></i> @endif
                    </th>
                    <th wire:click="sortBy('state')" style="cursor:pointer">
                        State @if ($sortField === 'state') <i
                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @else <i
                            class="fas fa-sort"></i> @endif
                    </th>
                    <th wire:click="sortBy('city')" style="cursor:pointer">
                        City @if ($sortField === 'city') <i
                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @else <i
                            class="fas fa-sort"></i> @endif
                    </th>
                    <th wire:click="sortBy('name')" style="cursor:pointer">
                        Hotel Name @if ($sortField === 'name') <i
                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @else <i
                            class="fas fa-sort"></i> @endif
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hotels as $hotel)
                <tr wire:key="hotel-{{ $hotel->id }}">
                    <td>{{ $hotel->id }}</td>
                    <td>{{ $hotel->country?->name ?? '-' }}</td>
                    <td>{{ $hotel->state?->name ?? '-' }}</td>
                    <td>{{ $hotel->city?->name ?? '-' }}</td>
                    <td>
                        <strong>{{ $hotel->name }}</strong>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.hotels.edit', $hotel->id) }}"
                            class="btn btn-sm btn-warning text-white">
                            Edit
                        </a>
                        <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST"
                            class="d-inline delete-state-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-hotel fa-2x mb-3 d-block"></i>
                        No Hotels Found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center p-3">
        <div class="text-muted">
            Showing <strong>{{ $hotels->count() }}</strong> results
        </div>
        <div>
            {{ $hotels->links() }}
        </div>

    </div>

</div>