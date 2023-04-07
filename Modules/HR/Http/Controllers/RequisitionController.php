<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Services\RequisitionService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\JobRequisition;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\HRRequisitionHiredBatchMembers;
use Modules\HR\Emails\SendHiringMail;
use Modules\HR\Entities\HRRequisitionHiredBatch;
use Illuminate\Support\Facades\DB;

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
        $batchMember = $requisitions->first();
        $employees = Employee::all();

        return view('hr.requisition.index')->with([
            'requisitions' => $requisitions,
            'employees' => $employees,
            'member' => $batchMember,
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

    public function storeBatchDetails(Request $request)
    {
        $batchMembers = $request->get('teamMembers');
        $batchId = $request->get('batchId');

        HRRequisitionHiredBatch::create([
            'batch_id' => $batchId,
        ]);

        foreach ($batchMembers as $batchMember) {
            HRRequisitionHiredBatchMembers::create([
                'batch_id' => $batchId,
                'employee_id' => $batchMember,
            ]);
        }

        DB::table('job_requisition')->where('id', $batchId)->update(['hired_batch_id' => $batchId]);

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
