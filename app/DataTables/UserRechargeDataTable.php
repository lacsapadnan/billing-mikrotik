<?php

namespace App\DataTables;

use App\Models\UserRecharge;
use App\Support\Lang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserRechargeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', fn ($row) => view('datatable.action.prepaid-user-action', $row))
            ->editColumn('created_at', function ($row) {
                return Lang::dateTimeFormat($row->created_at);
            })
            ->editColumn('expired_at', function ($row) {
                return Lang::dateTimeFormat($row->expired_at);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserRecharge $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('plan:id,name,type')
            ->with('router:id,name');
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
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->hidden(),
            Column::make('username'),
            Column::make('plan.name'),
            Column::make('plan.type'),
            Column::make('created_at'),
            Column::computed('expired_at'),
            Column::make('method'),
            Column::make('router.name'),
            Column::computed('action'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserRecharge_'.date('YmdHis');
    }
}
