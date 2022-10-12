<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\HrJobDomain;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

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
        $name = request('name');
        $employeeData = Employee::whereHas('user.roles', function ($query) use ($name) {
            $query->where('name', $name);
        })->get();

        return view('hr.employees.index', $this->service->index($filters))->with([
            'employees' => $employeeData,
        ]);
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
        $domains = HrJobDomain::select('id', 'domain')->get()->toArray();
        $designations = HrJobDesignation::select('id', 'designation')->get()->toArray();

        return view('hr.employees.basic-details', ['employee' => $employee, 'domains'=>$domains, 'designations' => $designations]);
    }

    public function showFTEdata(request $request)
    {
        $designationArrays = DB::table('hr_job_designation')->select('id')->where('domain_id', $request->domain_id)->get();
        foreach ($designationArrays as $designationArray) {
            $employees = Employee::where('designation_id', $designationArray->id)->get();
        };
        $domainName = HrJobDomain::all();
        $jobName = Job::all();

        return view('hr.employees.fte-handler')->with([
            'domainName' => $domainName,
            'employees' => $employees,
            'jobName' => $jobName
        ]);
    }
}
