<?php

namespace App\DataTables;

use App\Models\PaymentGateway;
use App\Support\Lang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrderHistoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('plan_name', fn ($row) => auth()->guard()->name == 'customer' ? view('datatable.column.link', ['to' => route('customer:order.detail', $row), 'text' => $row->plan_name]) : $row->plan_name)
            ->editColumn('price', fn ($row) => Lang::moneyFormat($row->price))
            ->editColumn('created_at', fn ($row) => Lang::dateTimeFormat($row->created_at))
            ->editColumn('expired_date', fn ($row) => Lang::dateTimeFormat($row->expired_date))
            ->editColumn('paid_date', fn ($row) => Lang::dateTimeFormat($row->paid_date))
            ->editColumn('status', fn ($row) => $row->status->name)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PaymentGateway $model): QueryBuilder
    {
        $username = auth()->guard()->name == 'customer' ? auth()->user()->username : request()->username;

        return $model->newQuery()->where('username', $username)->latest('id')->when(auth()->guard()->name == 'admin', fn ($query) => $query->limit(30));
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('plan_name'),
            Column::make('gateway'),
            Column::make('router_name'),
            Column::make('payment_channel')->title('Type'),
            Column::make('price'),
            Column::make('created_at')->title('Created On')->className('text-info'),
            Column::make('expired_date')->title('Expires On')->className('text-danger'),
            Column::make('paid_date')->title('Date Done')->className('text-success'),
            Column::make('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ActivationHistory_'.date('YmdHis');
    }
}
