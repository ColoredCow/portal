<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\operations\Services\OperationService;
use Modules\operations\Entities\OfficeLocation;
use Illuminate\Http\Request;

class OperationsController extends Controller
{
    protected $service;
    public function __construct(OperationService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centre = OfficeLocation::all();
        
        $users = User::orderBy('name', 'asc')->get();

        return view('operations::office-location.index', compact('users','centre'));
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
     * Show the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
    }
}
