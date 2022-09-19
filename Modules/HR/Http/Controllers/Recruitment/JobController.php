<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\HrJobDomain as EntitiesHrJobDomain;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\Round;
use Modules\HR\Http\Requests\Recruitment\JobRequest;
use Modules\HR\Http\Requests\Recruitment\JobDomainRequest;
use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;
use Modules\User\Entities\User;
use Illuminate\Support\Str;
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
            }])
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

    public function storeDesignation(JobDesignationRequest $request)
    {
        $jobDesignation = new HrJobDesignation();
        $jobDesignation->designation = $request['name'];
        $jobDesignation->slug = Str::slug($request['name']);
        $jobDesignation->save();

        return redirect()->back();
    }
}
