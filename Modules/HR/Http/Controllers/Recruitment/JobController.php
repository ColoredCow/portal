<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;
use Modules\HR\Http\Requests\Recruitment\JobRequest;
use Modules\User\Entities\User;

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
     *
     * @return void
     */
    public function create()
    {
        return view('hr.job.create')->with([
            'rounds' => Round::all(),
            'interviewers' => User::interviewers()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HR\JobRequest  $request
     * @return \Modules\HR\Entities\Job
     */
    public function store(JobRequest $request)
    {
        $validated = $request->validated();

        $opportunity = Job::create([
            'title' => $validated['title'],
            'domain' => $validated['domain'],
            'description' => $validated['description'] ?? null, // null needed for backward compatibility
            'type' => $validated['type'],
            'posted_by' => $validated['by'] ?? null,
            'link' => $validated['link'] ?? null,
        ]);
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);

        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\HR\Entities\Job  $opportunity
     * @return void
     */
    public function show(Job $opportunity)
    {
        //
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\JobRequest  $request
     * @param  \Modules\HR\Entities\Job  $opportunity
     * @return \Illuminate\Http\RedirectResponse
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
     * @return void
     */
    public function destroy(Job $opportunity)
    {
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities') : route('recruitment.opportunities');
        $opportunity->delete();

        return redirect($route)->with('status', "Successfully deleted $opportunity->title!");
    }
}
