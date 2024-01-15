<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RouterDataTable;
use App\Http\Controllers\Controller;
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
    public function storeRouter(Request $request)
    {
        //
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
