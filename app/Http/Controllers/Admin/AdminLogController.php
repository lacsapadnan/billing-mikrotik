<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminLogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Support\Facades\Config;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(AdminLogDataTable $dataTable)
    {
        $appName = Config::get('CompanyName');

        return $dataTable->render('admin.log.list', compact('appName'));
    }

    public function clean(Request $request)
    {
        $validated = $request->validate([
            'days' => ['required', 'numeric'],
        ]);

        Log::whereDate('date', '<', now()->subDays($validated['days']))->delete();

        return redirect()->route('admin:log.index')->with('success', 'Deleted logs older than '.$validated['days'].' days');
    }
}
