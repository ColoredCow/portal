<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Services\RequisitionService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\JobRequisition;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendHiringMail;

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

    public function store(Request $request)
    {
        $jobrequisition = $request->validate([
            'domain' => 'required|integer',
            'job' => 'required|integer',
        ]);

        JobRequisition::create([
            'domain_id' => $jobrequisition['domain'],
            'job_id' => $jobrequisition['job']
        ]);

        $jobHiring = null;
        Mail::send(new sendHiringMail($jobHiring));

        return redirect()->back();
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

    public function storecompleted(JobRequisition $jobRequisition)
    {
        $jobRequisition->status = 'completed';
        $jobRequisition->save();

        return redirect()->back();
    }
}
