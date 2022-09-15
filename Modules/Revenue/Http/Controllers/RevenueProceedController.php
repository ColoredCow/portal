<?php

namespace Modules\Revenue\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Revenue\Services\RevenueProceedService;
use Illuminate\Routing\Controller;

class RevenueProceedController extends Controller
{
    protected $service;

    public function __construct(RevenueProceedService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $revenueProceedData = $this->service->index();

        return view('revenue::index')->with('revenueProceeds', $revenueProceedData);
    }

    public function store(Request $request)
    {
        $this->service->store($request);

        return redirect()->route('revenue.proceeds.index')->with('status', 'Revenue created successfully!!');
    }

    public function show($id)
    {
        return view('revenue::index');
    }

    public function update(Request $request, $id)
    {
        $this->service->update($request, $id);

        return redirect()->route('revenue.proceeds.index')->with('status', 'Revenue updated successfully!!');
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return redirect()->route('revenue.proceeds.index')->with('status', 'Revenue deleted successfully!!');
    }
}
