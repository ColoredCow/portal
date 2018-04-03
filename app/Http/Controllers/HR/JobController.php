<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\JobRequest;
use App\Models\HR\Job;
use App\Models\HR\Round;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.job.index')->with([
            'jobs' => Job::with('applicants')->orderBy('id', 'desc')->get(),
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(JobRequest $request)
    {
        $validated = $request->validated();

        $job = Job::create([
            'title' => $validated['title'],
            'posted_by' => $validated['by'],
            'link' => $validated['link'],
        ]);

        $job->rounds()->attach(Round::all()->pluck('id')->toArray()); // should be in Job model event listener

        return json_encode(true); // need to change
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Job  $job
     * @return void
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Job  $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        return view('hr.job.edit')->with([
            'job' => $job,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\JobRequest  $request
     * @param  \App\Models\HR\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(JobRequest $request, Job $job)
    {
        $validated = $request->validated();

        $job->update([
            'facebook_post' => $validated['facebook_post'],
            'instagram_post' => $validated['instagram_post'],
            'twitter_post' => $validated['twitter_post'],
            'linkedin_post' => $validated['linkedin_post'],
        ]);
        $job->rounds()->sync($validated['rounds'], false); // should be in model

        return redirect("/hr/jobs/$job->id/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Job  $job
     * @return void
     */
    public function destroy(Job $job)
    {
        //
    }
}
