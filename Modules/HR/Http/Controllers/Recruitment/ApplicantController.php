<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use App\Imports\ApplicationImport;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Modules\HR\Events\Recruitment\ApplicantEmailVerified;
use Modules\HR\Http\Requests\Recruitment\ApplicantRequest;
use Modules\User\Entities\User;
use Modules\HR\Http\Requests\ApplicantMetaRequest;

class ApplicantController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(ApplicationServiceContract $service)
    {
        $this->service = $service;
        $this->authorizeResource(Applicant::class, null, [
            'except' => ['store', 'show', 'create'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hrJobs = Job::whereIn('type', ['job', 'internship'])->orderBy('title')->get();

        $verifyMail = Setting::where('module', 'hr')->get()->keyBy('setting_key');

        return view('hr.application.create', ['hrJobs' => $hrJobs], ['verifyMail' => $verifyMail]);
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
            'hr_university_id' => request()->university_id,
        ]);

        return response()->json([
            'status' => $status,
        ]);
    }

    public function show($applicationId)
    {
        $application = Application::find($applicationId);
        $interviewers = User::interviewers()->orderBy('name')->get();

        return view('hr.application.details', ['application' => $application, 'applicant' => $application->applicant, 'applicationRound' => $application->applicationRounds, 'interviewers' => $interviewers, 'timeline' => $application->applicant->timeline(), 'applicationFormDetails' => $application->applicationMeta()->formData()->first()]);
    }

    public function applicantEmailVerification($applicantEmail, $applicationId)
    {
        $application = Application::find($applicationId);
        $application->update(['is_verified' => true]);
        event(new ApplicantEmailVerified($application));

        return view('hr.application.verification')->with(['application' => $application, 'email' => decrypt($applicantEmail)]);
    }

    public function viewForm($id)
    {
        $hr_applicant_id = $id;

        return view('hr.application.approved-applicants-details')->with(['hr_applicant_id' => $hr_applicant_id]);
    }

    public function storeApprovedApplicantDetails(ApplicantMetaRequest $request)
    {
        $this->service->store($request);

        return redirect()->back()->with('status','Thanks for submitting the Details');
    }
}
