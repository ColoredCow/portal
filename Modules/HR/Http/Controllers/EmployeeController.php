<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\HrJobDomain;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\JobRequisition;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendHiringMail;

class EmployeeController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->authorizeResource(Employee::class);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();

        return view('hr.employees.index', $this->service->index($filters));
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', ['employee' => $employee]);
    }

    public function reports()
    {
        $this->authorize('reports');

        return view('hr.employees.reports');
    }
    public function basicDetails(Employee $employee)
    {
        return view('hr.employees.basic-details', ['employee' => $employee]);
    }

    public function showFTEdata(request $request)
    {
        $domainId = $request->domain_id;
        if (!empty($domainId)) {
        $employees = Employee::where('domain_id', $domainId)->get();
        }   else {
            return redirect()->back()->with;
        }
        $DomainName = HrJobDomain::all();
        $jobName = Job::all();

        return view('hr.employees.fte-handler')->with([
            'DomainName' => $DomainName,
            'employees' => $employees,
            'jobName' => $jobName
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
        Mail::send(new SendHiringMail($jobHiring));

        return redirect()->back();
    }
}
