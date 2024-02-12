<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PoolDataTable;
use App\DataTables\RouterDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Network\PoolRequest;
use App\Http\Requests\Admin\Network\RouterRequest;
use App\Models\Plan;
use App\Models\Pool;
use App\Models\Router;
use App\Support\Facades\Log;
use App\Support\Lang;
use App\Support\Mikrotik;
use Illuminate\Http\Request;

class AdminNetworkController extends Controller
{
    public function router(RouterDataTable $dataTable)
    {
        return $dataTable->render('admin.network.router');
    }

    public function pool(PoolDataTable $dataTable)
    {
        return $dataTable->render('admin.network.pool');
    }

    public function createRouter()
    {
        $mode = 'add';

        return view('admin.network.router-form', compact('mode'));
    }

    public function createPool()
    {
        $mode = 'add';
        $routers = Router::pluck('name', 'id');
        $defaultRouterId = Router::first()?->id;

        return view('admin.network.pool-form', compact('mode', 'routers', 'defaultRouterId'));
    }

    public function editRouter(Router $router)
    {
        $mode = 'edit';

        return view('admin.network.router-form', compact('mode', 'router'));
    }

    public function editPool(Pool $pool)
    {
        $mode = 'edit';
        $routers = Router::pluck('name', 'id');
        $defaultRouterId = Router::first()?->id;

        return view('admin.network.pool-form', compact('mode', 'pool', 'routers', 'defaultRouterId'));
    }

    public function storeRouter(RouterRequest $request)
    {
        try {
            Mikrotik::getClient($request->ip_address, $request->username, $request->password);
            Router::create($request->all());
            Log::put('Create Router '.$request->name, auth()->user());

            return redirect(route('admin:network.router.index'))->with('success', __('success.created'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function storePool(PoolRequest $request)
    {
        try {
            if ($request->pool_name != 'radius') {
                $router = Router::findOrFail($request->router_id);
                $client = Mikrotik::getClient($router->ip_address, $router->username, $router->password);
                Mikrotik::addPool($client, $request->pool_name, $request->range_ip);
            }
            Pool::create($request->all());
            Log::put('Create Pool '.$request->pool_name, auth()->user());

            return redirect(route('admin:network.pool.index'))->with('success', __('success.created'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function updateRouter(Router $router, RouterRequest $request)
    {
        try {
            Mikrotik::getClient($request->ip_address, $request->username, $request->password);
            $router->update($request->all());

            Log::put('Update Router '.$router->name, auth()->user());

            return redirect(route('admin:network.router.index'))->with('success', __('success.updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function updatePool(Pool $pool, PoolRequest $request)
    {
        try {
            if ($request->pool_name != 'radius') {
                $router = Router::findOrFail($request->router_id);
                $client = Mikrotik::getClient($router->ip_address, $router->username, $router->password);
                Mikrotik::setPool($client, $request->pool_name, $request->range_ip);
            }
            $pool->update($request->all());
            Log::put('Update Pool '.$pool->pool_name, auth()->user());

            return redirect(route('admin:network.pool.index'))->with('success', __('success.updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyRouter(Router $router)
    {
        $router->delete();

        Log::put('Delete Router '.$router->name, auth()->user());

        return redirect()->back()->with('success', __('success.deleted'));
    }

    public function destroyPool(Pool $pool)
    {
        $router = $pool->router;
        if ($router->name != 'radius') {
            try {
                $client = Mikrotik::getClient($router->ip_address, $router->username, $router->password);
                Mikrotik::removePool($client, $pool->pool_name);
            } catch (\Exception $e) {
                //pass
            }
        }
        $pool->delete();

        Log::put('Delete Pool '.$router->pool_name, auth()->user());

        return redirect()->back()->with('success', __('success.deleted'));
    }

    public function poolOption(Request $request)
    {
        $pools = Pool::when($request->has('router_id'), fn ($query) => $query->where('router_id', $request->router_id))->pluck('pool_name', 'id');

        return response()->json($pools);
    }

    public function routerOption(Request $request)
    {
        $routers = Router::when($request->has('plan_type'), fn ($query) => $query->whereRelation('plans', 'type', $request->plan_type))
            ->pluck('name', 'id');

        return response()->json($routers);
    }

    public function planOption(Request $request)
    {
        $plans = Plan::when($request->has('plan_type'), fn ($query) => $query->where('type', $request->plan_type))
            ->when($request->has('router_id'), fn ($query) => $query->where('router_id', $request->router_id))
            ->get()
            ->mapWithKeys(fn ($plan) => [$plan->id => $plan->name.' - '.Lang::moneyFormat($plan->price)]);

        return response()->json($plans);
    }
}
