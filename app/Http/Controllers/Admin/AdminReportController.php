<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ActivationHistoryDataTable;
use App\DataTables\ReportDailyDataTable;
use App\Http\Controllers\Controller;

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
}
