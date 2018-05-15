<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Application;
use App\Models\HR\Round;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $applications = Application::with('applicant')->paginate(config('constants.pagination_size'));
        $applications = Application::all();

        return view('hr.application.index')->with([
            'applications' => $applications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $job = Job::where('title', $validated['job_title'])->first();

        return Application::_create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'resume' => $validated['resume'],
            'phone' => isset($validated['phone']) ? $validated['phone'] : null,
            'college' => isset($validated['college']) ? $validated['college'] : null,
            'graduation_year' => isset($validated['graduation_year']) ? $validated['graduation_year'] : null,
            'course' => isset($validated['course']) ? $validated['course'] : null,
            'linkedin' => isset($validated['linkedin']) ? $validated['linkedin'] : null,
            'reason_for_eligibility' => isset($validated['reason_for_eligibility']) ? $validated['reason_for_eligibility'] : null,
            'hr_job_id' => $job->id,
            'status' => config('constants.hr.status.new.label'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        // $application->load(['job.rounds', 'applicant', 'applicant.applicantRounds', 'applicant.applicantRounds.applicantReviews']);

        // return view('hr.applicant.edit')->with([
        //     'applicant' => $application->applicant,
        //     'application' => $application,
        //     'rounds' => Round::all(),
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
