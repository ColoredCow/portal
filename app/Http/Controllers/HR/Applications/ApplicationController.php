<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\Controller;
use App\Models\HR\Application;
use App\Models\HR\Round;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Models\HR\Job;
use App\Http\Requests\HR\ApplicationRequest;

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
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $this->getApplicationType(),
            'job' => request()->get('hr_job_id')
        ];

        $applications = Application::with('applicant', 'job')
            ->applyFilter($filters)
            ->latest()
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

        $attr = [
            'applicant' => $application->applicant,
            'application' => $application,
            'rounds' => Round::all(),
            // 'timeline' => $application->applicant->timeline(),
            'timeline' => [],
            'interviewers' => User::interviewers()->get(),
            'applicantOpenApplications' => $application->applicant->openApplications(),
            'applicationFormDetails' => $application->applicationMeta()->formData()->first(),
        ];

        if ($application->job->type == 'job') {
            $attr['suggestInternship'] = $application->applicant->suggestInternship();
            $attr['internships'] = Job::isInternship()->latest()->get();
        }
        return view('hr.application.edit')->with($attr);
    }

    /**
     * Update the specified resource
     *
     * @param ApplicationRequest $request
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApplicationRequest $request, int $id)
    {
        $validated = $request->validated();

        $application = Application::find($id);
        if (!$application) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        switch($validated['action']) {
            case 'change-job':
                $application->changeJob($validated);
                // send mail

                return redirect()->route('applications.internship.edit', $id)->with('status', 'Application successfully moved to internship!');
                break;
        }

        return redirect()->back();
    }
}
