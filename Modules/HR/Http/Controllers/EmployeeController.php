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
use Modules\User\Entities\User;
//use vendor\spatie\laravel-permission\src\Models\Role;
use Spatie\Permission\Models\Role;

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

    public function filterEmployee(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();
        $users = Role::where('name', 'employee')->first()->users()->get();
        $data = [];
        foreach ($users as $user) {
            $data[] = $user->id;
        }
        $employees = Employee::whereIn('user_id', $data)->get();
        return view('hr.employees.index', $this->service->index($filters))->with([
            'employees' => $employees
        ]);
    }

    public function filterIntern(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();
        $users = Role::where('name', 'intern')->first()->users()->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = $user->id;
        }

        return view('hr.employees.index', $this->service->index($filters))->with([
            'employees' => $users
        ]);
    }

    public function filterContractor(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();
        $users = Role::where('name', 'contractor')->first()->users()->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = $user->id;
        }

        return view('hr.employees.index', $this->service->index($filters))->with([
            'employees' => $users
        ]);
    }

    public function filterSupportStaff(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();
        $users = Role::where('name', 'support-staff')->first()->users()->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = $user->id;
        }

        return view('hr.employees.index', $this->service->index($filters))->with([
            'employees' => $users
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
        $domainId = $request->domain_id;
        $employees = Employee::where('domain_id', $domainId)->get();
        $domainName = HrJobDomain::all();
        $jobName = Job::all();

        return view('hr.employees.fte-handler')->with([
            'domainName' => $domainName,
            'employees' => $employees,
            'jobName' => $jobName
        ]);
    }
}
