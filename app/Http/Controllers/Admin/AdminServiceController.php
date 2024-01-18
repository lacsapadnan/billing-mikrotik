<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BandwidthDataTable;
use App\Enum\RateUnit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\BandwidthRequest;
use App\Models\Bandwidth;

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
}
