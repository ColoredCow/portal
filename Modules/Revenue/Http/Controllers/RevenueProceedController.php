<?php

namespace Modules\Revenue\Http\Controllers;

use Modules\Revenue\Entities\RevenueProceed;
use Illuminate\Http\Request;
use Modules\Revenue\services\RevenueProceedService;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class RevenueProceedController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(RevenueProceedService $service)
    {
        $this->authorizeResource(RevenueProceed::class);
        $this->service = $service;
    }
    public function index()
    {
        $revenueData = $this->service->index();

        return view('revenue::index')->with('revenues',$revenueData);
    }

    public function store(Request $request)
    {
       $this->service->store($request);
        return redirect()->route('revenue.proceeds.index')->with('status', "Revenue created successfully!!");
    }

    public function show($id)
    {
        return view('revenue::index');
    }

    public function update(Request $request, $id)
    {
        $this->service->update($request, $id);

        return redirect()->route('revenue.proceeds.index')->with('status', "Revenue updated successfully!!");
    }

    public function delete($id)
    {
        $this->service->delete($id);

       return redirect()->route('revenue.proceeds.index')->with('status',"Revenue deleted successfully!!");
    }
}
