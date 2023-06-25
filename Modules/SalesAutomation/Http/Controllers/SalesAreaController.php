<?php

namespace Modules\SalesAutomation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SalesAutomation\Entities\SalesArea;
use Modules\SalesAutomation\Services\SalesAreaService;

class SalesAreaController extends Controller
{
    protected $service;

    public function __construct(SalesAreaService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $filters = request()->has('filters') ? request()->get('filters') : [];
        $data = $this->service->index($filters);

        return view('salesautomation::sales-area.index')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $salesArea = $this->service->store($request->all());

        return redirect()->route('sales-area.index')->with('status', 'Sales Area added successfully!');
    }

    /**
     * Show the specified resource.
     * @param SalesArea $salesArea
     */
    public function show(SalesArea $salesArea)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param SalesArea $salesArea
     */
    public function edit(SalesArea $salesArea)
    {
        return view('salesautomation::sales-area.edit', compact('salesArea'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param SalesArea $salesArea
     */
    public function update(Request $request, SalesArea $salesArea)
    {
        $this->service->update($request->all(), $salesArea);

        return redirect()->route('sales-area.index')->with('status', 'Sales Area updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param SalesArea $salesArea
     */
    public function destroy(SalesArea $salesArea)
    {
        $this->service->destroy($salesArea);

        return redirect()->route('sales-area.index')->with('status', 'Sales Area deleted successfully!');
    }
}
