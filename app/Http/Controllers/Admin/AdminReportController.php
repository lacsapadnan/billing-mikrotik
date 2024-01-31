<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ActivationHistoryDataTable;
use App\Http\Controllers\Controller;

class AdminReportController extends Controller
{
    public function reportActivation(ActivationHistoryDataTable $dataTable)
    {
        return $dataTable->render('admin.report.activation');
    }
}
