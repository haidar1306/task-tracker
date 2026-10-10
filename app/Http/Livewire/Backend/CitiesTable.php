<?php

namespace App\Http\Livewire\Backend;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CitiesTable extends DataTableComponent
{
    protected string $pageName = 'citiesPage';

    public int $perPage = 5;

    public array $perPageAccepted = [5, 10, 20, 25];

    public string $emptyMessage = 'No Cities Found';

    public string $search = '';

    public function query(): Builder
    {
        return City::query()
            ->with(['country', 'state'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('country', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('state', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest();
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),

            Column::make('Country Name', 'country.name')
                ->sortable(),

            Column::make('State Name', 'state.name')
                ->sortable(),

            Column::make('City Name', 'name')
                ->sortable(),

            Column::make('Actions'),
        ];
    }

    public function rowView(): string
    {
        return 'backend.cities.includes.row';
    }
}