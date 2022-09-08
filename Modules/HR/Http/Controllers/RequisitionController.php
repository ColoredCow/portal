<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Services\RequisitionService;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\JobRequisition;

class RequisitionController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(RequisitionService $service)
    {
        $this->authorizeResource(JobRequisition::class);
        $this->service = $service;
    }

    public function index()
    {
        $requisitions = $this->service->index();

        return view('hr.requisition.index')->with([
            'requisitions' => $requisitions,
        ]);
    }

    public function showCompletedRequisition()
    {
        $requisitions = $this->service->showCompletedRequisition();

        return view('hr.requisition.complete')->with([
            'requisitions' => $requisitions,
        ]);
    }

    public function storePending(JobRequisition $jobRequisition)
    {
        $jobRequisition->status = 'pending';
        $jobRequisition->save();

        return redirect()->back();
    }

    public function store(JobRequisition $jobRequisition)
    {
        $jobRequisition->status = 'completed';
        $jobRequisition->save();

        return redirect()->back();
    }
}
