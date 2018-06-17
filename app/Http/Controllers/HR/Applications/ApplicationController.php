<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicationRequest;
use App\Mail\HR\Application\JobChanged;
use App\Mail\HR\Application\RoundNotConducted;
use App\Models\HR\Application;
use App\Models\HR\ApplicationMeta;
use App\Models\HR\Evaluation\Parameter;
use App\Models\HR\Job;
use App\Models\Setting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

abstract class ApplicationController extends Controller
{
    abstract public function getApplicationType();

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

        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
        ];

        if ($this->getApplicationType() == 'job') {
            $attr['openJobsCount'] = Job::count();
            $attr['openApplicationsCount'] = Application::applyFilter([
                'job-type' => 'job',
                'job' => request()->get('hr_job_id')
            ])
            ->isOpen()
            ->get()
            ->count();
        }

        return view('hr.application.index')->with($attr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::findOrFail($id);
        
        $application->load(['job', 'job.rounds',  'job.rounds.evaluationParameters',  'job.rounds.evaluationParameters.options', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.evaluations', 'applicationRounds.round', 'applicationMeta']);

        $attr = [
            'applicant' => $application->applicant,
            'evaluations' => self::evaluation($id),
            'application' => $application,
            'timeline' => $application->applicant->timeline(),
            'interviewers' => User::interviewers()->get(),
            'applicantOpenApplications' => $application->applicant->openApplications(),
            'applicationFormDetails' => $application->applicationMeta()->formData()->first(),
            'settings' => [
                'noShow' => Setting::getNoShowEmail()
            ]
        ];

        if ($application->job->type == 'job') {
            $attr['hasGraduated'] = $application->applicant->hasGraduated();
            $attr['internships'] = Job::isInternship()->latest()->get();
        }
        return view('hr.application.edit')->with($attr);
    }


    public function evaluation($id)
    {
        $parameter_list = Parameter::parameterList();

        $application = Application::find($id)->load(['evaluations', 'evaluations.evaluationOption']);

        $application_evaluation = $application->evaluations;

        $evaluation_data = array();

        foreach ($parameter_list as $segment_id => $segment) {
            $segment_evaluation_array = array();
            foreach ($segment as $evaluation_parameter) {
                $segment_evaluation_array['name'] = $evaluation_parameter['segment']['name'];
                $segment_evaluation_array['id'] = $segment_id;
                
                $parameter_array = array();
                $parameter_array['name'] = $evaluation_parameter['name'];

                $filled_evaluation = $application_evaluation->where('evaluation_id', $evaluation_parameter['id']);
                if ($filled_evaluation->isNotEmpty()) {
                    $filled_evaluation = $filled_evaluation->first()->toArray();
                    $parameter_array['filled'] = true;
                    $parameter_array['evaluation_comment'] = $filled_evaluation['comment'] ?: '-';
                    $parameter_array['evaluation_option'] = $filled_evaluation['evaluation_option']['value'] ?: '-';
                } else {
                    $parameter_array['filled'] = false;
                    foreach ($evaluation_parameter['options'] as $option) {
                        $parameter_array['options'][] = $option['value'];
                    }
                }

                $segment_evaluation_array['parameters'][] = $parameter_array;

            }
            $evaluation_data[] = $segment_evaluation_array;
        }

        return $evaluation_data;
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
        $application = Application::findOrFail($id);
        $application->load('applicant');

        switch ($validated['action']) {
            case config('constants.hr.application-meta.keys.change-job'):
                $changeJobMeta = $application->changeJob($validated);
                Mail::send(new JobChanged($application, $changeJobMeta));
                return redirect()->route('applications.internship.edit', $id)->with('status', 'Application updated successfully!');
                break;
            case config('constants.hr.application-meta.keys.no-show'):
                $roundNotConductedMeta = ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => $validated['action'],
                    'value' => json_encode([
                        'round' => $validated['application_round_id'],
                        'reason' => $validated['no_show_reason'],
                        'user' => Auth::id(),
                        'mail_subject' => $validated['no_show_mail_subject'],
                        'mail_body' => $validated['no_show_mail_body'],
                    ]),
                ]);
                Mail::send(new RoundNotConducted($application, $roundNotConductedMeta));
                return redirect()->back()->with('status', 'Application updated successfully!');
                break;
        }

        return redirect()->back()->with('No changes were done to the application. Please make sure your are submitting valid data.');
    }
}
