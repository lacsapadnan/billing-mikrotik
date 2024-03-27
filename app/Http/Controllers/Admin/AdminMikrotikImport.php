<?php

namespace App\Http\Controllers\Admin;

use App\Enum\PlanType;
use App\Http\Controllers\Controller;
use App\Models\Router;
use App\Support\Mikrotik;
use Illuminate\Http\Request;

class AdminMikrotikImport extends Controller
{
    public function create()
    {

        $serviceTypes = array_column(PlanType::cases(), 'value', 'value');
        $routers = Router::where('enabled', true)->pluck('name', 'id');

        return view('admin.setting.import-mikrotik.create', compact('serviceTypes', 'routers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'router_id' => 'required',
            'plan_type' => 'required',
        ]);
        $router = Router::find($validated['router_id']);
        $results = Mikrotik::{'import'.$request->plan_type}($router);

        return view('admin.setting.import-mikrotik.result', compact('results'));
    }
}
