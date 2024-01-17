<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RouterDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Network\RouterRequest;
use App\Models\Router;
use App\Support\Mikrotik;

class AdminNetworkController extends Controller
{
    /**
     * Display a listing of the routers.
     */
    public function router(RouterDataTable $dataTable)
    {
        return $dataTable->render('admin.network.router');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createRouter()
    {
        $mode = 'add';

        return view('admin.network.router-form', compact('mode'));
    }

    public function editRouter(Router $router)
    {
        $mode = 'edit';

        return view('admin.network.router-form', compact('mode', 'router'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeRouter(RouterRequest $request)
    {
        try {
            Mikrotik::getClient($request->ip_address, $request->username, $request->password);
            Router::create($request->all());

            return redirect(route('admin:network.router.index'))->with('success', __('success.router.created'));
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

    /**
     * Update the specified resource in storage.
     */
    public function updateRouter(Router $router, RouterRequest $request)
    {
        try {
            Mikrotik::getClient($request->ip_address, $request->username, $request->password);
            $router->update($request->all());

            return redirect(route('admin:network.router.index'))->with('success', __('success.router.updated'));
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

        return redirect()->back()->with('success', __('success.router.deleted'));
    }
}
