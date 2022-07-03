<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use App\Imports\ApplicationImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Job;
use Modules\HR\Http\Requests\Recruitment\ApplicantRequest;
use Modules\HR\Entities\Application;
use Modules\User\Entities\User;
use Modules\HR\Entities\University;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Applicant\OnHold;
use Modules\HR\Events\Recruitment\ApplicantEmailVerified;

class ApplicantController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(ApplicationServiceContract $service)
    {
        $this->service = $service;
        $this->authorizeResource(Applicant::class, null, [
            'except' => ['store'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hrJobs = Job::whereIn('type', ['job', 'internship'])->orderBy('title')->get();

        return view('hr.application.create', ['hrJobs' => $hrJobs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ApplicantRequest  $request
     */
    public function store(ApplicantRequest $request)
    {
        $validated = $request->validated();
        $this->service->saveApplication($validated);

        return redirect(route('applications.job.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     */
    public function importExcel(Request $request)
    {
        $job = Job::find($request->job_id);
        Excel::import(new ApplicationImport($job), request()->file('excel_file'));

        return redirect(route('applications.job.index'));
    }

    /**
     * To update applicant university.
     *
     * @param Applicant $applicant
     * @param Request $request
     */
    public function updateUniversity(Applicant $applicant, Request $request)
    {
        $status = $applicant->update([
            'hr_university_id' => request()->university_id
        ]);

        return response()->json([
            'status' => $status,
        ]);
    }

    public function show($applicationID)
    {
        $application = Application::find($applicationID);
        $interviewers = User::interviewers()->orderBy('name')->get();

        return view('hr.application.details', ['application' => $application, 'applicant' => $application->applicant, 'applicationRound' => $application->applicationRounds, 'interviewers' => $interviewers, 'timeline' => $application->applicant->timeline(), 'applicationFormDetails' => $application->applicationMeta()->formData()->first()]);
    }

    public function ApplicationOnHold($applicationID)
    {
        $application = Application::find($applicationID);
        $applicant = $application->applicant;

        $subject = Setting::where('module', 'hr')->where('setting_key', 'application_on_hold_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'application_on_hold_body')->first();
        $job_title = Job::find($application->hr_job_id)->title;
        $body->setting_value = str_replace(config('constants.hr.template-variables.applicant-name'), $applicant->name, $body->setting_value);
        $body->setting_value = str_replace(config('constants.hr.template-variables.job-title'), $job_title, $body->setting_value);

        Mail::to($applicant->email, $applicant->name)
            ->send(new OnHold($subject->setting_value, $body->setting_value));

        $application->onHold();

        return redirect()->route('applications.job.index')->with('status', 'Your application is put on hold successfully!');
    }
    public function applicantEmailVerification($applicantEmail, $applicationID)
    {
        $application = Application::find($applicationID);
        event(new ApplicantEmailVerified($application));

        return view('hr.application.verification')->with(['application' => $application, 'email' => decrypt($applicantEmail)]);
    }
}
