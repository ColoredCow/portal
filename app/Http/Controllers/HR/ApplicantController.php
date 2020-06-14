<?php

namespace App\Http\Controllers\HR;

use App\Models\HR\Job;
use App\Models\HR\Applicant;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRequest;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Applicant::class, null, [
            'except' => ['store'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @return void
     */
    public function index(ApplicantRequest $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $hrJobs = Job::whereIn('type', ['job', 'internship'])->orderBy('title')->get();
        return view('hr.application.create', ['hrJobs' => $hrJobs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicantRequest $request)
    {
        $validated = $request->validated();
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        Applicant::_create($validated);
        return redirect(route('applications.job.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Applicant  $applicant
     * @return void
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @param  \App\Models\HR\Applicant  $applicant
     * @return void
     */
    public function update(ApplicantRequest $request, Applicant $applicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Applicant  $applicant
     * @return void
     */
    public function destroy(Applicant $applicant)
    {
        //
    }
}
