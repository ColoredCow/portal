<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\HRRequisitionHiredBatch;
use Modules\HR\Entities\HRRequisitionHiredBatchMembers;
use Modules\HR\Entities\JobRequisition;
use Modules\HR\Jobs\SendHiringMailJob;
use Modules\HR\Services\RequisitionService;

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
            'user_id' => 'required|integer',
        ]);

        JobRequisition::create([
            'domain_id' => $jobrequisition['domain'],
            'job_id' => $jobrequisition['job'],
            'requested_by' => $jobrequisition['user_id'],
        ]);

        $jobHiring = null;
        SendHiringMailJob::dispatch($jobHiring);

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
