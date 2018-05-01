<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRequest;
use App\Models\HR\Applicant;
use App\Models\HR\Job;
use App\Models\HR\Round;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *@param  \App\Http\Requests\HR\ApplicantRequest  $request
     * 
     * @return \Illuminate\View\View
     */
    public function index(ApplicantRequest $request)
    {  
        $validated = $request->validated();
        $hrJobID = (isset($validated['hr_job_id'])) ? $validated['hr_job_id'] : null;
        
        $applicants = Applicant::with('job')
                        ->where(function($query) use ($hrJobID ) {
                            ($hrJobID) ? $query->where('hr_job_id', $hrJobID) : null;
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.pagination_size'));

        return view('hr.applicant.index')->with([
            'applicants' => $applicants,
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
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicantRequest $request)
    {
        $validated = $request->validated();
        $job = Job::where('title', $validated['job_title'])->first();

        return Applicant::_create([
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Applicant $applicant)
    {
        $applicant->load(['job', 'job.rounds', 'applicantRounds', 'applicantRounds.applicantReviews']);

        return view('hr.applicant.edit')->with([
            'job' => $applicant->job,
            'applicant' => $applicant,
            'rounds' => Round::all(),
        ]);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        //
    }
}
