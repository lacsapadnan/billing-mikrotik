<?php

namespace App\DataTables;

use App\Models\Transaction;
use App\Support\Lang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ActivationHistoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'activationhistory.action')
            ->editColumn('price', fn ($row) => Lang::moneyFormat($row->price))
            ->editColumn('created_at', fn ($row) => Lang::dateTimeFormat($row->created_at))
            ->editColumn('expired_at', fn ($row) => Lang::dateTimeFormat($row->expired_at))
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $username = auth()->guard()->name == 'customer' ? auth()->user()->username : request()->username;
        // jika ada $username artinya datatable ini diakses dari tab di detail customer
        // maka limit dan filter berdasarkan username
        return $model->newQuery()->when($username, fn ($query) => $query->where('username', $username)->limit(30))->latest('id');
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
            Column::make('invoice'),
            Column::make('username'),
            Column::make('plan_name'),
            Column::make('price')->title('Plan Price'),
            Column::make('type'),
            Column::make('created_at')->title('Created On')->className('text-success'),
            Column::make('expired_at')->title('Expires On')->className('text-danger'),
            Column::make('method'),
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
