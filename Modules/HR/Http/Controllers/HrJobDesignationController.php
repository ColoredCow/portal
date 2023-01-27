<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Services\HrJobDesignationService;
use Modules\HR\Entities\HrJobDesignation;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class HrJobDesignationController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(HrJobDesignationService $service)
    {
        $this->authorizeResource(HrJobDesignation::class);
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $this->authorize(HrJobDesignation::class);

        return view('hr.designations.index', $this->service->index($request));
    }

    public function storeDesignation(JobDesignationRequest $request)
    {
        $this->service->storeDesignation($request);

        return redirect()->back();
    }

    public function edit($id)
    {
        $this->service->edit($id);

        return redirect()->back();
    }

    public function destroy(HrJobDesignation $request, $id)
    {
        $this->service->destroy($request, $id);

        return redirect()->back();
    }
}
