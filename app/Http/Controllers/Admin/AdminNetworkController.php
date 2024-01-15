<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RouterDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Network\RouterRequest;
use App\Models\Router;
use App\Support\Mikrotik;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     */
    public function storeRouter(RouterRequest $request)
    {
        try {

            Mikrotik::getClient($request->ip_address, $request->username, $request->password);
            Router::create($request->all());
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
    public function updateRouter(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
