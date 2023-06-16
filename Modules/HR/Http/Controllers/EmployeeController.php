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
use Modules\Project\Entities\ProjectTeamMember;
use Modules\HR\Entities\IndividualAssessment;

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
        $this->authorize('list', Employee::class);
        $search = request()->query('employeename') ?: '';
        $employeeData = Employee::with('employees');
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();
        $name = request('name');
        $employeeData = Employee::where('staff_type', $name)
            ->leftJoin('project_team_members', 'employees.user_id', '=', 'project_team_members.team_member_id')
            ->selectRaw('employees.*, team_member_id, count(team_member_id) as project_count')
            ->whereNull('project_team_members.ended_on')
            ->groupBy('employees.user_id')
            ->orderby('project_count', 'desc')
            ->get();
        if ($search != '') {
            $employeeData = Employee::where('name', 'LIKE', "%$search%")
                ->leftJoin('project_team_members', 'employees.user_id', '=', 'project_team_members.team_member_id')
                ->selectRaw('employees.*, team_member_id, count(team_member_id) as project_count')
                ->get();
        }

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
        $domainIndex = '';

        return view('hr.employees.basic-details', ['domainIndex' => $domainIndex, 'employee' => $employee, 'domains' => $domains, 'designations' => $designations]);
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

    public function employeeWorkHistory(Employee $employee)
    {
        $employeesDetails = ProjectTeamMember::where('team_member_id', $employee->user_id)->get()->unique('project_id');

        return view('hr.employees.employee-work-history', compact('employeesDetails'));
    }

    public function reviewDetails(Employee $employee)
    {
        $employees = Employee::all();
        return view('hr.employees.review-details', ['employee' => $employee, 'employees' => $employees]);
    }

    public function saveReviewStatus(Request $request)
    {
        $assessmentId = $request->input('assessment_id');
        $type = $request->input('type');
        $status = $request->input('status');

        // Update or create the individual assessment entry
        IndividualAssessment::updateOrCreate(
            ['assessment_id' => $assessmentId, 'type' => $type],
            ['status' => $status]
        );

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Review saved successfully.');
    }
}
