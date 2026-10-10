<?php

namespace App\Http\Livewire\Backend;

use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CountriesTable extends DataTableComponent
{
    protected string $pageName = 'countriesPage';

    public int $perPage = 5;

    public array $perPageAccepted = [5, 10, 20, 25];

    public string $emptyMessage = 'No Countries Found';

    public function query(): Builder
    {
        return Country::query();
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),

            Column::make('Country Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('ISO', 'iso')
                ->sortable()
                ->searchable(),

            Column::make('Actions'),
        ];
    }

    public function rowView(): string
    {
        return 'backend.countries.includes.row';
    }
}