<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ReportDailyDataTable extends ReportDataTable
{
    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->newQuery()->whereDate('created_at', now());
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Report_Daily_'.date('YmdHis');
    }
}
