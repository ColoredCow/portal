<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\Controller;
use App\Models\HR\Application;
use App\Models\HR\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

abstract class ApplicationController extends Controller
{
    abstract function getApplicationType();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = [
            'status' => request()->get('status'),
            'job-type' => $this->getApplicationType()
        ];

        $applications = Application::with('applicant', 'job')
            ->applyFilter($filters)
            ->orderBy('id', 'desc')
            ->paginate(config('constants.pagination_size'))
            ->appends(Input::except('page'));

        return view('hr.application.index')->with([
            'applications' => $applications,
            'status' => request()->get('status'),
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

        $application->load(['job', 'job.rounds', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.round', 'applicationMeta']);

        return view('hr.application.edit')->with([
            'applicant' => $application->applicant,
            'application' => $application,
            'rounds' => Round::all(),
            'applicantOpenApplications' => $application->applicant->openApplications(),
        ]);
    }
}
