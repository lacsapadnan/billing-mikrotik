<?php

namespace App\DataTables;

use App\Models\Customer;
use App\Support\Lang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', fn ($row) => view('datatable.action.customer-action', $row))
            ->editColumn('recharge.is_active', function ($row) {
                if ($d = $row->recharge) {
                    if ($d->is_active) {
                        return '<span class="badge badge-success" title="Expired '.Carbon::createFromFormat($d['expiration'], $d['time']).'">'.$d['namebp'].'</span>';
                    } else {
                        return '<span class="badge badge-danger" title="Expired '.Carbon::createFromFormat($d['expiration'], $d['time']).'">'.$d['namebp'].'</span>';
                    }
                } else {
                    return '<span class="badge badge-danger">&bull;</span>';
                }
            })
            ->editColumn('created_at', fn ($row) => Lang::dateTimeFormat($row->created_at))
            ->rawColumns(['action', 'recharge.is_active'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery()->with('recharge');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
        // ->buttons([
        //     Button::make('excel'),
        //     Button::make('csv'),
        //     Button::make('pdf'),
        //     Button::make('print'),
        // ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('username'),
            Column::make('fullname'),
            Column::make('phonenumber'),
            Column::make('email'),
            Column::make('recharge.is_active')->title('Package')
                ->orderable(false)
                ->searchable(false),
            Column::make('service_type'),
            Column::make('created_at')->title('Created On')
                ->addClass('whitespace-nowrap'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customer_'.date('YmdHis');
    }
}
