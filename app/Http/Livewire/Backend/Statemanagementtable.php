<?php

namespace App\Http\Livewire\Backend;

use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StateManagementTable extends DataTableComponent
{
    protected string $pageName = 'stateMgmtPage';

    public int $perPage = 5;

    public array $perPageAccepted = [5, 10, 20, 25];

    public string $emptyMessage = 'Please select a country.';

    // Page ka country dropdown yahan bhejta hai
    public $countryId = null;

    /**
     * JS se:
     *   Livewire.emit('countryChanged', id)  -> country badla
     *   Livewire.emit('refreshStates')       -> add/edit/delete ke baad refresh
     */
    protected function getListeners()
    {
        return array_merge(parent::getListeners(), [
            'countryChanged' => 'setCountry',
            'refreshStates'  => '$refresh',
        ]);
    }

    public function setCountry($countryId = null)
    {
        $this->countryId    = $countryId ?: null;
        $this->emptyMessage = $this->countryId ? 'No States Found' : 'Please select a country.';

        $this->resetPage($this->pageName);
    }

    public function query(): Builder
    {
        return State::query()
            ->when(
                $this->countryId,
                fn ($q) => $q->where('country_id', $this->countryId),
                fn ($q) => $q->whereRaw('1 = 0')   // country select nahi to kuch mat dikhao
            );
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),

            Column::make('State Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Actions'),
        ];
    }

    public function rowView(): string
    {
        return 'backend.state-management.includes.row';
    }
}