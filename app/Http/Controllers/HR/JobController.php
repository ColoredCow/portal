<?php

namespace App\Http\Controllers\HR;

use App\Models\HR\Job;
use Modules\User\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\JobRequest;

class JobController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HR\JobRequest  $request
     * @return \App\Models\HR\Job
     */
    public function store(JobRequest $request)
    {
        $validated = $request->validated();

        return Job::create([
            'title' => $validated['title'],
            'posted_by' => $validated['by'],
            'link' => $validated['link'],
            'type' => $validated['type'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Job  $opportunity
     * @return void
     */
    public function show(Job $opportunity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Job  $opportunity
     * @return \Illuminate\View\View
     */
    public function edit(Job $opportunity)
    {
        return view('hr.job.edit')->with([
            'job' => $opportunity,
            'interviewers' => User::interviewers()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\JobRequest  $request
     * @param  \App\Models\HR\Job  $opportunity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(JobRequest $request, Job $opportunity)
    {
        $validated = $request->validated();
        $opportunity->_update([
            'facebook_post' => $validated['facebook_post'],
            'instagram_post' => $validated['instagram_post'],
            'twitter_post' => $validated['twitter_post'],
            'linkedin_post' => $validated['linkedin_post'],
            'rounds' => $validated['rounds'],
            'description' => $validated['description'],
        ]);

        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);
        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Job  $opportunity
     * @return void
     */
    public function destroy(Job $opportunity)
    {
        //
    }
}
