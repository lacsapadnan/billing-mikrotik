<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ReportPeriodDataTable extends ReportDataTable
{
    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $from = request('from') ?? now()->startOfMonth();
        $to = request('to') ?? now()->endOfMonth();
        $type = request('type') ?? 'all';

        return $model->newQuery()->whereBetween('created_at', [$from, $to])
            ->when($type != 'all', function ($query) use ($type) {
                $query->where('type', $type);
            });
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Report_Period_'.date('YmdHis');
    }
}
