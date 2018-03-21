<?php

namespace App\Http\Controllers\HR;

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
        $user = session('oauthuser');
        if (!$user) {
            return redirect('logout');
        }
        return view('hr.applicant.index')->with([
            'user' => $user,
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
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $resume = $request->input('resume');
        $jobTitle = $request->input('job_title');

        $applicant = new Applicant();
        $applicant->name = $name;
        $applicant->email = $email;
        $applicant->phone = $phone;
        $applicant->resume = $resume;
        $applicant->status = 'new';

        $job = Job::where('title', $jobTitle)->first();
        $applicant->hr_job_id = $job->id;
        $applicant->save();

        $applicant_round = new ApplicantRound;
        $applicant_round->hr_applicant_id = $applicant->id;
        $applicant_round->hr_round_id = $job->rounds->first()->id;
        $applicant_round->scheduled_date = Carbon::now()->addDay();
        // update with $job->posted_by
        $applicant_round->scheduled_person_id = 1;

        $applicant_round->save();

        return json_encode(true);
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
        $user = session('oauthuser');
        if (!$user) {
            return redirect('logout');
        }

        return view('hr.applicant.edit')->with([
            'user' => $user,
            'applicant' => Applicant::with('job')->find($id),
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
        $reviews = $request->input('reviews');
        $round_id = $request->input('round_id');
        $round_status = $request->input('round_status');

        $applicant_round = ApplicantRound::where('hr_applicant_id', $id)->first();

        foreach ($reviews as $review_key => $review_value) {
            $applicant_reviews = ApplicantReview::updateOrCreate(
                [
                    'hr_applicant_round_id' => $applicant_round->id
                ],
                [
                    'review_key' => $review_key,
                    'review_value' => $review_value,
                ]
            );
        }

        $applicant_round->conducted_person_id = Auth::user()->id;
        $applicant_round->conducted_date = Carbon::now();
        $applicant_round->round_status = $round_status;
        $applicant_round->save();

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
