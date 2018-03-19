<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Applicant;
use App\Models\HR\Job;
use Illuminate\Http\Request;

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

        $job = Job::where('title', $jobTitle)->first();
        $applicant->hr_job_id = $job->id;

        return json_encode($applicant->save());
        // $user = session('oauthuser');
        // if (!$user) {
        //     return redirect('logout');
        // }
        // return view('hr.applicant.create')->with([
        //     'user' => $user
        // ]);
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
        $user = session('oauthuser');
        if (!$user) {
            return redirect('logout');
        }
        return view('hr.applicant.show')->with([
            'user' => $user,
            'applicant' => Applicant::with('job')->find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
