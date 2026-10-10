<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DataTable extends DataTableComponent
{
    public string $model;

    public array $columns = [];

    public array $with = [];

    public ?string $editRoute = null;

    public ?string $deleteRoute = null;

    public int $perPage = 5;

    public array $perPageAccepted = [5, 10, 20, 25];

    protected string $pageName = 'dataTablePage';

    public function mount(
        string $model,
        array $columns = [],
        array $with = [],
        ?string $editRoute = null,
        ?string $deleteRoute = null,
        int $perPage = 5
    ): void {
        $this->model = $model;
        $this->columns = $columns;
        $this->with = $with;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->perPage = $perPage;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setPerPageAccepted($this->perPageAccepted);

        $this->setSearchEnabled();

        $this->setPaginationEnabled();

        $this->setEmptyMessage('No Data Found');
    }

    public function builder(): Builder
    {
        $query = app($this->model)->newQuery();

        if (!empty($this->with)) {
            $query->with($this->with);
        }

        return $query->latest();
    }

    public function columns(): array
    {
        $tableColumns = [];

        foreach ($this->columns as $field => $label) {

            $tableColumns[] = Column::make($label, $field)
                ->sortable()
                ->searchable();
        }

        $tableColumns[] = Column::make('Actions')
            ->label(function ($row) {

                $html = '<div class="d-flex gap-2">';

                /*
                |--------------------------------------------------------------------------
                | Edit
                |--------------------------------------------------------------------------
                */

                if ($this->editRoute) {

                    $html .= '
                        <a href="' . route($this->editRoute, $row->id) . '"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>
                    ';
                }

                /*
                |--------------------------------------------------------------------------
                | Delete
                |--------------------------------------------------------------------------
                */

                if ($this->deleteRoute) {

                    $html .= '
                        <form action="' . route($this->deleteRoute, $row->id) . '"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm(\'Are you sure you want to delete this record?\')">

                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '

                            <button type="submit"
                                    class="btn btn-sm btn-danger">
                                Delete
                            </button>

                        </form>
                    ';
                }

                $html .= '</div>';

                return $html;
            })
            ->html();

        return $tableColumns;
    }
}