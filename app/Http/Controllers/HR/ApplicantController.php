<?php

namespace App\Http\Controllers\HR;

use App\Events\HR\ApplicantCreated;
use App\Events\HR\ApplicantUpdated;
use App\Http\Controllers\Controller;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicantReview;
use App\Models\HR\ApplicantRound;
use App\Models\HR\Job;
use App\Models\HR\Round;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.applicant.index')->with([
            'applicants' => Applicant::with('job')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $job = Job::where('title', $request->input('job_title'))->first();

        return Applicant::_create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'resume' => $request->input('resume'),
            'hr_job_id' => $job->id,
            'status' => config('constants.hr.round.statuses.new'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applicant = Applicant::with('job')->find($id);

        return view('hr.applicant.edit')->with([
            'job' => Job::with('rounds')->find($applicant->job->id),
            'applicant' => $applicant,
            'rounds' => Round::all(),
            'applicant_rounds' => ApplicantRound::with('applicantReviews')->where('hr_applicant_id', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $round_status = $request->input('round_status');

        $status = ($round_status === config('constants.hr.round.statuses.rejected')) ? $round_status : config('constants.hr.round.statuses.in-progress');
        $applicant = Applicant::find($id);
        $applicant->_update([
            'status' => $status
        ]);

        return redirect("/hr/applicants/$id/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
