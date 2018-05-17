<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\Controller;
use App\Models\HR\Application;
use App\Models\HR\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ApplicationController extends Controller
{
    protected $application_type = 'All';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $application_filter = 'get' . $this->application_type . 'Application';
        
        $applications = Application::with('applicant', 'job')
            ->{$application_filter}()
            ->orderBy('id', 'desc')
            ->paginate(config('constants.pagination_size'));

        return view('hr.application.index')->with([
            'applications' => Application::filterByStatus(request()->get('status'))->appends(Input::except('page')),
            'status' => request()->get('status'),
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
     * Show the form for editing the specified resource.
     *
     * @param  String  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::find($id);

        if (!$application) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        $application->load(['job.rounds', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.round']);

        return view('hr.application.edit')->with([
            'applicant' => $application->applicant,
            'application' => $application,
            'rounds' => Round::all(),
            'applicantOpenApplications' => $application->applicant->openApplications(),
        ]);
    }
}
