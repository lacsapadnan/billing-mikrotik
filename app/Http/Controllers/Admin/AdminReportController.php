<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ActivationHistoryDataTable;
use App\DataTables\ReportDailyDataTable;
use App\DataTables\ReportPeriodDataTable;
use App\Enum\PlanType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function reportActivation(ActivationHistoryDataTable $dataTable)
    {
        return $dataTable->render('admin.report.activation');
    }

    public function reportDaily(ReportDailyDataTable $dataTable)
    {
        return $dataTable->render('admin.report.daily');
    }

    public function reportPeriod(ReportPeriodDataTable $dataTable, Request $request)
    {
        $transactionTypes = [...['all' => 'All'], ...array_column(PlanType::cases(), 'value', 'value')];
        $defaultFrom = $request->from ?? now()->startOfMonth()->format('Y-m-d');
        $defaultTo = $request->to ?? now()->endOfMonth()->format('Y-m-d');
        $defaultType = $request->type ?? 'all';

        return $dataTable->render('admin.report.period', compact('transactionTypes', 'defaultFrom', 'defaultTo', 'defaultType'));
    }
}
