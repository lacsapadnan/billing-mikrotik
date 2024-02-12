<?php

namespace App\DataTables;

use App\Models\Log;
use App\Support\Lang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('date', fn ($row) => Lang::dateTimeFormat($row->date))
            ->editColumn('loggable_type', fn ($row) => match ($row->loggable_type) {
                'App\Models\Customer' => 'Customer',
                'App\Models\User' => 'Admin',
                default => 'Unknown',
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Log $model): QueryBuilder
    {
        return $model->newQuery()->latest('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
                    //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('date'),
            Column::make('loggable_type')->title('Type'),
            Column::make('ip'),
            Column::make('description'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminLog_'.date('YmdHis');
    }
}
