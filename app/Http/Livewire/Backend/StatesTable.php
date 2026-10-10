<?php

namespace App\Http\Livewire\Backend;

use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StatesTable extends DataTableComponent
{
    protected string $pageName = 'statesPage';

    public int $perPage = 5;

    public array $perPageAccepted = [5, 10, 20, 25];

    public string $emptyMessage = 'No States Found';

    public function query(): Builder
    {
        return State::query()
            ->with('country');
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),

            Column::make('State Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Country', 'country.name')
                ->sortable()
                ->searchable(),

            Column::make('Actions'),
        ];
    }

    public function rowView(): string
    {
        return 'backend.states.includes.row';
    }
}
