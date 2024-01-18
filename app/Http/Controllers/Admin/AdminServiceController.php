<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BandwidthDataTable;
use App\DataTables\HotspotDataTable;
use App\Enum\PlanTypeBp;
use App\Enum\RateUnit;
use App\Enum\ValidityUnit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\BandwidthRequest;
use App\Models\Bandwidth;
use App\Models\Router;

class AdminServiceController extends Controller
{
    public function bandwidth(BandwidthDataTable $dataTable)
    {
        return $dataTable->render('admin.service.bandwidth.list');
    }

    public function createBandwidth()
    {
        $mode = 'add';
        $rateUnits = array_column(RateUnit::cases(), 'value', 'value');

        return view('admin.service.bandwidth.form', compact('rateUnits', 'mode'));
    }

    public function editBandwidth(Bandwidth $bandwidth)
    {
        $mode = 'edit';
        $rateUnits = array_column(RateUnit::cases(), 'value', 'value');

        return view('admin.service.bandwidth.form', compact('rateUnits', 'mode', 'bandwidth'));
    }

    public function storeBandwidth(BandwidthRequest $request)
    {
        Bandwidth::create($request->all());

        return redirect()->to(route('admin:service.bandwidth.index'))->with('success', __('success.created'));
    }

    public function updateBandwidth(Bandwidth $bandwidth, BandwidthRequest $request)
    {
        $bandwidth->update($request->all());

        return redirect()->to(route('admin:service.bandwidth.index'))->with('success', __('success.updated'));
    }

    public function hotspot(HotspotDataTable $dataTable)
    {
        return $dataTable->render('admin.service.hotspot.list');
    }
    public function createHotspot()
    {
        $mode = 'add';
        $planTypes = array_column(PlanTypeBp::cases(), 'value', 'value');
        $defaultPlanType = PlanTypeBp::UNLIMITED->value;
        $bandwidths = Bandwidth::pluck('name_bw', 'id');
        $defaultBandwidth = Bandwidth::first()?->id;
        $validityUnits = array_column(ValidityUnit::cases(), 'value', 'value');
        $defaultValidityUnit = ValidityUnit::MINS->value;
        $routers = Router::pluck('name', 'id');
        $defaultRouter = Router::first()?->id;
        return view('admin.service.hotspot.form', compact(
            'mode',
            'planTypes',
            'defaultPlanType',
            'bandwidths',
            'defaultBandwidth',
            'validityUnits',
            'defaultValidityUnit',
            'routers',
            'defaultRouter',
        ));
    }
}
