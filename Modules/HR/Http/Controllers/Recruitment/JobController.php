<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\HrJobDomain as EntitiesHrJobDomain;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;
use Modules\HR\Http\Requests\Recruitment\JobDomainRequest;
use Modules\HR\Http\Requests\Recruitment\JobRequest;
use Modules\User\Entities\User;
use Request;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Job::class, null, [
            'except' => ['store', 'edit', 'update'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Job::class);

        $jobs = Job::with([
            'applications' => function ($query) {
                $query->isOpen()->get();
            }
        ])
            ->latest()
            ->appends(Request::except('page'));

        request()->is('*recruitment/opportunities*') ? $jobs->typeRecruitment() : $jobs->typeVolunteer();
        $jobs->paginate(config('constants.pagination_size'));

        return view('hr.job.index')->with([
            'jobs' => $jobs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hr.job.create')->with([
            'rounds' => Round::all(),
            'interviewers' => User::interviewers()->get(),
            'domains' => EntitiesHrJobDomain::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  JobRequest  $request
     */
    public function store(JobRequest $request)
    {
        $validated = $request->validated();

        $opportunity = Job::create([
            'title' => $validated['title'],
            'domain' => $validated['domain'],
            'description' => $validated['description'] ?? null, // null needed for backward compatibility
            'type' => $validated['type'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'resources_required' => $validated['resources_required'],
        ]);
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);

        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\HR\Entities\Job  $opportunity
     * @return \Illuminate\View\View
     */
    public function edit(Job $opportunity)
    {
        $opportunity->load('postedBy');

        return view('hr.job.edit')->with([
            'job' => $opportunity,
            'interviewers' => User::interviewers()->get(),
            'jobs' => EntitiesHrJobDomain::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  JobRequest  $request
     * @param  Job  $opportunity
     */
    public function update(JobRequest $request, Job $opportunity)
    {
        $validated = $request->validated();
        $opportunity->_update($validated);

        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);

        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\HR\Entities\Job  $opportunity
     */
    public function destroy(Job $opportunity)
    {
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities') : route('recruitment.opportunities');
        $opportunity->delete();

        return redirect($route)->with('status', "Successfully deleted $opportunity->title!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Modules\HR\Http\Requests\Recruitment\JobDomainRequest  $request
     */
    public function storeJobdomain(JobDomainRequest $request)
    {
        $hrJobDomains = new EntitiesHrJobDomain();
        $hrJobDomains->domain = $request['name'];
        $hrJobDomains->slug = Str::slug($request['name']);
        $hrJobDomains->save();

        return redirect()->back();
    }

    public function storeResponse(HttpRequest $request)
    {
        $application = Application::findOrFail($request->id);
        $application->update(['is_desired_resume' => true]);

        ApplicationMeta::updateOrCreate(
            ['hr_application_id' => $application->id],
            [
                'key' => 'reasons_for_desired_resume',
                'value' => $request->get('body')
            ]
        );
    }

    public function editResponse(HttpRequest $request)
    {
        $application = Application::findOrFail($request->id);
        $application->update(['is_desired_resume' => false]);

        ApplicationMeta::where(
            'hr_application_id',
            $application->id
        )
            ->update(['value' => $request->get('body')]);

        $applicationData = DB::table('hr_applications')
            ->select(['hr_applications.resume', 'hr_application_meta.value', 'hr_jobs.title', 'hr_applicants.name', 'hr_jobs.id'])
            ->join('hr_application_meta', 'hr_applications.id', '=', 'hr_application_meta.hr_application_id')
            ->join('hr_jobs', 'hr_applications.hr_job_id', '=', 'hr_jobs.id')
            ->join('hr_applicants', 'hr_applicants.id', '=', 'hr_applications.hr_applicant_id')
            ->where('hr_applications.hr_job_id', '=', $request->id)
            ->where('hr_application_meta.key', '=', 'reasons_for_desired_resume')
            ->get();

        return view('hr.application.resume-table')->with([
            'applicationData' => $applicationData,
        ]);
    }

    public function unflagResponse(HttpRequest $request)
    {
        $application = Application::findOrFail($request->id);
        $application->update(['is_desired_resume' => false]);

        return redirect()->back();
    }

    public function showTable(HttpRequest $request)
    {
        $applicationData = DB::table('hr_applications')
            ->select(['hr_applications.resume', 'hr_application_meta.value', 'hr_jobs.title', 'hr_applicants.name', 'hr_jobs.id'])
            ->join('hr_application_meta', 'hr_applications.id', '=', 'hr_application_meta.hr_application_id')
            ->join('hr_jobs', 'hr_applications.hr_job_id', '=', 'hr_jobs.id')
            ->join('hr_applicants', 'hr_applicants.id', '=', 'hr_applications.hr_applicant_id')
            ->where('hr_applications.hr_job_id', '=', $request->id)
            ->where('hr_application_meta.key', '=', 'reasons_for_desired_resume')
            ->get();

        return view('hr.application.resume-table')->with([
            'applicationData' => $applicationData,
        ]);
    }
}
