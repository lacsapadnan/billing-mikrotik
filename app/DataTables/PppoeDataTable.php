<?php

namespace App\DataTables;

use App\Enum\PlanType;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PppoeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', fn ($row) => view('datatable.action.pppoe-action', $row))
            ->editColumn('pool_expired.pool_name', fn ($row) => $row->pool_expired?->pool_name ?? '-')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Plan $model): QueryBuilder
    {
        return $model->newQuery()->where('type', PlanType::PPPOE)
            ->with('router:id,name')
            ->with('pool:id,pool_name')
            ->with('pool_expired:id,pool_name')
            ->with('bandwidth:id,name_bw');
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
        // ->buttons([
        //     Button::make('excel'),
        //     Button::make('csv'),
        //     Button::make('pdf'),
        //     Button::make('print'),
        //     Button::make('reset'),
        //     Button::make('reload')
        // ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->hidden(),
            Column::make('name')->title('Name'),
            Column::make('bandwidth.name_bw')->title('Bandwidth Plan'),
            Column::make('price')->title('Price'),
            Column::computed('validity_text')->title('Plan Validity'),
            Column::make('pool.pool_name')->title('IP Pool'),
            Column::make('pool_expired.pool_name')->title('Expired IP Pool'),
            Column::make('router.name')->title('Routers'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pppoe_'.date('YmdHis');
    }
}
