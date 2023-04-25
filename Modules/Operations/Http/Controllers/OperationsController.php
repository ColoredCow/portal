<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\Operations\Services\OperationService;
use Modules\Operations\Entities\OfficeLocation;
use Illuminate\Http\Request;

class OperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centres = OfficeLocation::with('centre_head')->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('operations::office-location.index', compact('users', 'centres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OperationService $service)
    {
        $data = $request->all();
        $service->store($data);

        return redirect()->route('office-location.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $centre = OfficeLocation::find($id);
        $users = User::orderBy('name', 'asc')->get();

        return view('operations::office-location.edit', compact('centre', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, OperationService $service)
    {
        $data = $request->all();
        $centre = $service->update($data, $id);

        return redirect()->route('office-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, OperationService $service)
    {
        $service->delete($id);

        return redirect()->route('office-location.index');
    }
}
