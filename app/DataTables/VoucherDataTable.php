<?php

namespace App\DataTables;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VoucherDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', fn ($voucher) => view('datatable.action.voucher-action', $voucher))
            ->editColumn('customer.username', fn ($voucher) => $voucher->customer?->username ?? '-')
            ->editColumn('code', fn ($voucher) => view('datatable.column.voucher-code', $voucher))
            ->editColumn('status', fn ($voucher) => $voucher->status->label())
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Voucher $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('plan:id,name')
            ->with('customer:id,username')
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
            Column::make('id'),
            Column::make('type'),
            Column::make('router.name')->title('Router'),
            Column::make('plan.name'),
            Column::make('code')->title('Code Voucher'),
            Column::make('status')->title('Status Vocher'),
            Column::make('customer.username')->title('Customer'),
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
        return 'Voucher_'.date('YmdHis');
    }
}
