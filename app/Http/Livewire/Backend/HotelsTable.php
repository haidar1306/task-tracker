<?php

namespace App\Http\Livewire\Backend;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithPagination;

class HotelsTable extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $sortField = 'id';

    public string $sortDirection = 'desc';

    public int $perPage = 5;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 5],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function applySorting($query)
    {
        if ($this->sortField === 'country') {
            $query->orderBy('countries.name', $this->sortDirection);
        } elseif ($this->sortField === 'state') {
            $query->orderBy('states.name', $this->sortDirection);
        } elseif ($this->sortField === 'city') {
            $query->orderBy('cities.name', $this->sortDirection);
        } else {
            $query->orderBy('hotels.' . $this->sortField, $this->sortDirection);
        }

        return $query;
    }

    // public function deleteHotel($hotelId)
    // {
    //     Hotel::findOrFail($hotelId)->delete();

    //     session()->flash('success', 'Hotel deleted successfully.');
    // }

    public function render()
    {
        $query = Hotel::query()
            ->select('hotels.*')
            ->with(['country', 'state', 'city'])
            ->leftJoin('countries', 'countries.id', '=', 'hotels.country_id')
            ->leftJoin('states', 'states.id', '=', 'hotels.state_id')
            ->leftJoin('cities', 'cities.id', '=', 'hotels.city_id')
            ->when($this->search, function ($q) {
                $q->where('hotels.name', 'like', '%' . $this->search . '%')
                    ->orWhere('countries.name', 'like', '%' . $this->search . '%')
                    ->orWhere('states.name', 'like', '%' . $this->search . '%')
                    ->orWhere('cities.name', 'like', '%' . $this->search . '%');
            });

        $query = $this->applySorting($query);

        $hotels = $query->paginate($this->perPage);

        return view('livewire.backend.hotels-table', [
            'hotels' => $hotels,
        ]);
    }
}