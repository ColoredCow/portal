<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Services\RequisitionService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\JobRequisition;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\BatchMembers;
use Modules\HR\Emails\SendHiringMail;
use Modules\HR\Entities\Batches;
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

    public function index(JobRequisition $jobRequisition)
    {
        // $batchId = EmployeeBatches::all();
        // dd($jobRequisition);

        // dd($batchId);
        $requisitions = $this->service->index();
        $employees = Employee::all();
        foreach ($requisitions as $requisition) {
            return view('hr.requisition.index')->with([
                'requisitions' => $requisitions,
                'employees' => $employees,
                'member' => $requisition,
            ]);
        }
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
        // $batchId = Batches::all();
        // $batchId = Batches::whereRaw('batch_id = id')->get();
        
        
        $batchMembers = $request->get('teamMembers');
        $batchId = $request->get('batchId');


        Batches::create([
            'id' => $batchId,
        ]);
        
        foreach($batchMembers as $batchMember){
            BatchMembers::create([
                'batch_id' => $batchId,
                'employee_id' => $batchMember,
            ]);
        };

        $a = DB::table('job_requisition')->where('id','=',$batchId )->update(['batch_table_id','=',$batchId ]);
        // $a->update(['batch_table_id','=',$batchId ]);
        dd($a);

        
    

        return redirect()->back();
    }

    public function showCompletedRequisition()
    {
        $requisitions = $this->service->showCompletedRequisition();

        // dd($requisitions);
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