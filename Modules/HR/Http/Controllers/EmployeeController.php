<?php

namespace Modules\HR\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\EmployeeAssessmetReviewMail;
use Modules\HR\Entities\Assessment;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Modules\HR\Entities\IndividualAssessment;
use Modules\HR\Entities\Job;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\User\Entities\User;

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
            ->applyFilters($filters)
            ->leftJoin('project_team_members', 'employees.user_id', '=', 'project_team_members.team_member_id')
            ->selectRaw('employees.*, team_member_id, count(team_member_id) as project_count')
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
            'jobName' => $jobName,
        ]);
    }

    public function employeeWorkHistory(Employee $employee)
    {
        $employeesDetails = ProjectTeamMember::where('team_member_id', $employee->user_id)->get()->unique('project_id');

        return view('hr.employees.employee-work-history', compact('employeesDetails'));
    }

    public function sendMail($id, Request $request)
    {
        $links = [
            'self_review_link' => $request->self_review_link,
            'hr_review_link' => $request->hr_review_link,
            'mentor_review_link' => $request->mentor_review_link,
            'manager_review_link' => $request->manager_review_link,
        ];

        $employee = Employee::where('user_id', $id)->first();
        $employeeIds = [$employee->id, $employee->hr_id, $employee->mentor_id, $employee->manager_id];
        $userIds = Employee::whereIn('id', $employeeIds)->orderByRaw('FIELD(id, ' . implode(',', $employeeIds) . ')')->pluck('user_id')->toArray();
        $userData = User::whereIn('id', $userIds)->orderByRaw('FIELD(id, ' . implode(',', $userIds) . ')')->get();
        $sendEmailto = [
            'selfMail' => ! empty($userData[0]) ? $userData[0] : null,
            'hrMail' => ! empty($userData[1]) ? $userData[1] : null,
            'mentorMail' => ! empty($userData[2]) ? $userData[2] : null,
            'managerMail' => ! empty($userData[3]) ? $userData[3] : null,
        ];

        foreach ($sendEmailto as $key => $user) {
            if (! is_null($user)) {
                Mail::send(new EmployeeAssessmetReviewMail($key, $user, $employee, $links));
            }
        }

        return redirect()->back()->with('success', 'Mail sent successfully');
    }

    public function reviewDetails(Employee $employee)
    {
        $assessments = Assessment::where('reviewee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $employees = Employee::all();

        return view('hr.employees.review-details', ['employee' => $employee, 'employees' => $employees, 'assessments' => $assessments]);
    }

    public function createIndividualAssessment(Request $request)
    {
        $reviewStatuses = [
            'self' => $request->self,
            'mentor' => $request->mentor,
            'hr' => $request->hr,
            'manager' => $request->manager,
        ];
        $assessmentId = $request->assessmentId;
        $reviewStatus = $reviewStatuses[$request->review_type] ?? '';

        $individualAssessment = IndividualAssessment::firstOrNew([
            'assessment_id' => $assessmentId,
            'type' => $request->review_type,
        ]);

        $individualAssessment->fill([
            'reviewer_id' => $request->reviewer_id,
            'status' => $reviewStatus,
        ])->save();

        return redirect()->back()->with('success', $individualAssessment->wasRecentlyCreated ? 'Review saved successfully.' : 'Review status updated successfully.');
    }

    public function updateEmployeeReviewers(Request $request, Employee $employee)
    {
        // Update the employee reviewers data
        $employee->update([
            'hr_id' => $request->hr_id,
            'mentor_id' => $request->mentor_id,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->back();
    }
}
