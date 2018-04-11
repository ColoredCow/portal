<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRequest;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicantRound;
use App\Models\HR\Job;
use App\Models\HR\Round;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.applicant.index')->with([
            'applicants' => Applicant::with('job')->orderBy('id', 'desc')->get(),
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
            'phone' => $validated['phone'] ?? null,
            'resume' => $validated['resume'],
            'college' => $validated['college'] ?? null,
            'graduation_year' => $validated['graduation_year'] ?? null,
            'course' => $validated['course'] ?? null,
            'hr_job_id' => $job->id,
            'status' => config('constants.hr.round.status.new'),
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
        return view('hr.applicant.edit')->with([
            'job' => Job::with('rounds')->find($applicant->job->id),
            'applicant' => $applicant,
            'rounds' => Round::all(),
            'applicant_rounds' => ApplicantRound::with('applicantReviews')->where('hr_applicant_id', $applicant->id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @param  \App\Models\HR\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicantRequest $request, Applicant $applicant)
    {
        $validated = $request->validated();
        $round_status = $validated['round_status'];
        $status = ($round_status === config('constants.hr.round.status.rejected')) ? $round_status : config('constants.hr.round.status.in-progress');
        $applicant->_update([
            'status' => $status
        ]);
        return redirect("/hr/applicants/$applicant->id/edit");
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
