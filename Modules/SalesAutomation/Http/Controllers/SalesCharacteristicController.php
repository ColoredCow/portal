<?php

namespace Modules\SalesAutomation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SalesAutomation\Entities\SalesCharacteristic;
use Modules\SalesAutomation\Services\SalesCharacteristicService;

class SalesCharacteristicController extends Controller
{
    protected $service;

    public function __construct(SalesCharacteristicService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $filters = request()->has('filters') ? request()->get('filters') : [];
        $data = $this->service->index($filters);

        return view('salesautomation::sales-characteristic.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('salesautomation::sales-characteristic.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect()->route('sales-characteristic.index')->with('status', 'Sales Characteristic added successfully!');
    }

    /**
     * Show the specified resource.
     *
     * @param SalesCharacteristic $salesCharacteristic
     */
    public function show(SalesCharacteristic $salesCharacteristic)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SalesCharacteristic $salesCharacteristic
     *
     * @return Renderable
     */
    public function edit(SalesCharacteristic $salesCharacteristic)
    {
        return view('salesautomation::sales-characteristic.edit', compact('salesCharacteristic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SalesCharacteristic $salesCharacteristic
     */
    public function update(Request $request, SalesCharacteristic $salesCharacteristic)
    {
        $this->service->update($request->all(), $salesCharacteristic);

        return redirect()->route('sales-characteristic.index')->with('status', 'Sales Characteristic updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SalesCharacteristic $salesCharacteristic
     */
    public function destroy(SalesCharacteristic $salesCharacteristic)
    {
        $this->service->destroy($salesCharacteristic);

        return redirect()->route('sales-characteristic.index')->with('status', 'Sales Characteristic deleted successfully!');
    }
}
