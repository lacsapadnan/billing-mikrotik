<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BandwidthDataTable;
use App\DataTables\HotspotDataTable;
use App\DataTables\PppoeDataTable;
use App\Enum\DataUnit;
use App\Enum\LimitType;
use App\Enum\PlanTypeBp;
use App\Enum\RateUnit;
use App\Enum\TimeUnit;
use App\Enum\ValidityUnit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\BandwidthRequest;
use App\Http\Requests\Admin\Service\HotspotRequest;
use App\Http\Requests\Admin\Service\PppoeRequest;
use App\Models\Bandwidth;
use App\Models\Plan;
use App\Models\Pool;
use App\Models\Router;
use App\Support\Facades\Log;
use App\Support\Mikrotik;

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
        Log::put('Create Bandwidth '.$request->name_bw, auth()->user());

        return redirect()->to(route('admin:service.bandwidth.index'))->with('success', __('success.created'));
    }

    public function updateBandwidth(Bandwidth $bandwidth, BandwidthRequest $request)
    {
        $bandwidth->update($request->all());
        Log::put('Update Bandwidth '.$bandwidth->name_bw, auth()->user());

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
        $limitTypes = array_map(fn ($row) => str_replace('_', ' ', $row), array_column(LimitType::cases(), 'value', 'value'));
        $defaultLimitType = LimitType::TIME_LIMIT->value;
        $timeUnits = array_column(TimeUnit::cases(), 'value', 'value');
        $dataUnits = array_column(DataUnit::cases(), 'value', 'value');
        $defaultTimeUnit = TimeUnit::HRS->value;
        $defaultDataUnit = DataUnit::MB->value;

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
            'limitTypes',
            'defaultLimitType',
            'timeUnits',
            'defaultTimeUnit',
            'dataUnits',
            'defaultDataUnit'
        ));
    }

    public function storeHotspot(HotspotRequest $request)
    {
        if ($request->is_radius) {
            // TODO: buat Radius class
        } else {
            $mikrotik = Router::find($request->router_id);
            $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
            Mikrotik::addHotspotPlan($client, $request->name, $request->shared_users, $request->rate);
            if (! empty($request->pool_expired_id)) {
                $poolExpired = Pool::find($request->pool_expired_id);
                Mikrotik::setHotspotExpiredPlan($client, 'EXPIRED LNUXBILL '.$poolExpired->pool_name, $poolExpired->pool_name);
            }
        }
        Plan::create($request->all());
        Log::put('Create Hotspot Plan '.$request->name, auth()->user());

        return redirect()->to(route('admin:service.hotspot.index'))->with('success', __('success.created'));
    }

    public function editHotspot(Plan $hotspot)
    {

        $mode = 'edit';
        $planTypes = array_column(PlanTypeBp::cases(), 'value', 'value');
        $defaultPlanType = PlanTypeBp::UNLIMITED->value;
        $bandwidths = Bandwidth::pluck('name_bw', 'id');
        $defaultBandwidth = Bandwidth::first()?->id;
        $validityUnits = array_column(ValidityUnit::cases(), 'value', 'value');
        $defaultValidityUnit = ValidityUnit::MINS->value;
        $routers = Router::pluck('name', 'id');
        $defaultRouter = Router::first()?->id;
        $limitTypes = array_map(fn ($row) => str_replace('_', ' ', $row), array_column(LimitType::cases(), 'value', 'value'));
        $defaultLimitType = LimitType::TIME_LIMIT->value;
        $timeUnits = array_column(TimeUnit::cases(), 'value', 'value');
        $dataUnits = array_column(DataUnit::cases(), 'value', 'value');
        $defaultTimeUnit = TimeUnit::HRS->value;
        $defaultDataUnit = DataUnit::MB->value;

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
            'limitTypes',
            'defaultLimitType',
            'timeUnits',
            'defaultTimeUnit',
            'dataUnits',
            'defaultDataUnit',
            'hotspot',
        ));
    }

    public function updateHotspot(Plan $hotspot, HotspotRequest $request)
    {
        if ($request->is_radius) {
            // TODO: buat Radius class
        } else {
            $mikrotik = Router::find($request->router_id);
            $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
            Mikrotik::setHotspotPlan($client, $request->name, $request->shared_users, $request->rate);
            if (! empty($request->pool_expired_id)) {
                $poolExpired = Pool::find($request->pool_expired_id);
                Mikrotik::setHotspotExpiredPlan($client, 'EXPIRED LNUXBILL '.$poolExpired->pool_name, $poolExpired->pool_name);
            }
        }
        $hotspot->update($request->all());
        Log::put('Update Hotspot Plan '.$hotspot->name, auth()->user());

        return redirect()->to(route('admin:service.hotspot.index'))->with('success', __('success.updated'));
    }

    public function destroyHotspot(Plan $hotspot)
    {
        if ($hotspot->is_radius) {
            // TODO: handle delete radius plan
        } else {
            try {
                $mikrotik = $hotspot->router;
                $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
                Mikrotik::removeHotspotPlan($client, $hotspot->name);
            } catch (\Throwable $th) {
                // ignore, it means router has already been deleted
            }
        }
        $hotspot->delete();
        Log::put('Delete Hotspot Plan '.$hotspot->name, auth()->user());

        return redirect()->to(route('admin:service.hotspot.index'))->with('success', __('success.deleted'));
    }

    public function pppoe(PppoeDataTable $dataTable)
    {
        return $dataTable->render('admin.service.pppoe.list');
    }

    public function createPppoe()
    {
        $mode = 'add';
        $bandwidths = Bandwidth::pluck('name_bw', 'id');
        $defaultBandwidth = Bandwidth::first()?->id;
        $validityUnits = array_column(ValidityUnit::cases(), 'value', 'value');
        $defaultValidityUnit = ValidityUnit::MINS->value;
        $routers = Router::pluck('name', 'id');
        $defaultRouter = Router::first()?->id;

        return view('admin.service.pppoe.form', compact(
            'mode',
            'bandwidths',
            'defaultBandwidth',
            'validityUnits',
            'defaultValidityUnit',
            'routers',
            'defaultRouter',
        ));
    }

    public function storePppoe(PppoeRequest $request)
    {
        if ($request->is_radius) {
            // TODO: buat Radius class
        } else {
            $mikrotik = Router::find($request->router_id);
            $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
            $pool = Pool::find($request->pool_id);
            Mikrotik::addPpoePlan($client, $request->name, $pool->pool_name, $request->rate);
            if (! empty($request->pool_expired_id)) {
                $poolExpired = Pool::find($request->pool_expired_id);
                Mikrotik::setPpoePlan($client, 'EXPIRED LNUXBILL '.$poolExpired->pool_name, $poolExpired->pool_name, '512K/512K');
            }
        }
        Plan::create($request->all());
        Log::put('Create PPPoE Plan '.$request->name, auth()->user());

        return redirect()->to(route('admin:service.pppoe.index'))->with('success', __('success.created'));
    }

    public function editPppoe(Plan $pppoe)
    {

        $mode = 'edit';
        $bandwidths = Bandwidth::pluck('name_bw', 'id');
        $defaultBandwidth = Bandwidth::first()?->id;
        $validityUnits = array_column(ValidityUnit::cases(), 'value', 'value');
        $defaultValidityUnit = ValidityUnit::MINS->value;
        $routers = Router::pluck('name', 'id');
        $defaultRouter = Router::first()?->id;

        return view('admin.service.pppoe.form', compact(
            'mode',
            'bandwidths',
            'defaultBandwidth',
            'validityUnits',
            'defaultValidityUnit',
            'routers',
            'defaultRouter',
            'pppoe',
        ));
    }

    public function updatePppoe(Plan $pppoe, PppoeRequest $request)
    {
        if ($request->is_radius) {
            // TODO: buat Radius class
        } else {
            $mikrotik = Router::find($request->router_id);
            $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
            Mikrotik::setPpoePlan($client, $request->name, $request->shared_users, $request->rate);
            if (! empty($request->pool_expired_id)) {
                $poolExpired = Pool::find($request->pool_expired_id);
                Mikrotik::setPpoePlan($client, 'EXPIRED LNUXBILL '.$poolExpired->pool_name, $poolExpired->pool_name, '512K/512K');
            }
        }
        $pppoe->update($request->all());
        Log::put('Update PPPoE Plan '.$pppoe->name, auth()->user());

        return redirect()->to(route('admin:service.pppoe.index'))->with('success', __('success.updated'));
    }

    public function destroyPppoe(Plan $pppoe)
    {
        if ($pppoe->is_radius) {
            // TODO: handle delete radius plan
        } else {
            try {
                $mikrotik = $pppoe->router;
                $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
                Mikrotik::removePpoePlan($client, $pppoe->name);
            } catch (\Throwable $th) {
                // ignore, it means router has already been deleted
            }
        }
        $pppoe->delete();
        Log::put('Delete PPPoE Plan '.$pppoe->name, auth()->user());

        return redirect()->to(route('admin:service.pppoe.index'))->with('success', __('success.deleted'));
    }
}
