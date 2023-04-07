<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use App\Models\Setting;
use Illuminate\Http\Request;
use Modules\HR\Entities\Job;
use Modules\User\Entities\User;
use App\Imports\ApplicationImport;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Applicant;
use Maatwebsite\Excel\Facades\Excel;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicantMeta;
use Modules\HR\Services\ResumeService;
use Modules\HR\Services\ApplicantService;
use Modules\HR\Http\Requests\ApplicantMetaRequest;
use Modules\HR\Contracts\ApplicationServiceContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Events\Recruitment\ApplicantEmailVerified;
use Modules\HR\Http\Requests\Recruitment\ApplicantRequest;

class ApplicantController extends Controller
{
    use AuthorizesRequests;

    protected $service;
    protected $applicantService;

    public function __construct(ApplicationServiceContract $service, ApplicantService $applicantService)
    {
        $this->service = $service;
        $this->applicantService = $applicantService;
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

    public function viewForm($id, $email)
    {
        $hrApplicantEmail = $email;
        $hrApplicantId = $id;
        $applicant = ApplicantMeta::where('hr_applicant_id', $id)->get()->keyBy('key');

        return view('hr.application.approved-applicants-details')->with(['hrApplicantId' => $hrApplicantId, 'hrApplicantEmail' => $hrApplicantEmail, 'applicant' => $applicant]);
    }

    public function storeApprovedApplicantDetails(ApplicantMetaRequest $request)
    {
        $hrApplicantId = $request->get('hr_applicant_id');
        $hrApplicantEmail = $request->get('hr_applicant_email');
        $this->applicantService->storeApplicantOnboardingDetails($request);

        return redirect()->route('hr.applicant.applicant-onboarding-form', [$hrApplicantId, $hrApplicantEmail]);
    }

    public function formSubmit($id, $email)
    {
        $hrApplicantId = $id;
        $hrApplicantEmail = $email;

        return view('hr.application.details-submitted')->with(['hrApplicantId'=>$hrApplicantId, 'hrApplicantEmail'=> $hrApplicantEmail]);
    }

    public function showOnboardingFormDetails($id)
    {
        $applicantMeta = ApplicantMeta::where('hr_applicant_id', $id)->get()->keyBy('key');
        $applicant = Applicant::where('id', $id)->get();

        return view('hr.application.verify-details', ['applicantMeta'=> $applicantMeta, 'applicant'=> $applicant]);
    }

    public function getOpenAIEvaluation(Request $request)
    {
        if (! config('services.open_ai.active')) {
            return '';
        }

        $application = Application::find($request->application_id);

        $values = $request->values ?? ['Creating opportunities', 'Vulnerability', 'Lead by example'];

        if ($request->type == 'summery') {
            $data = ResumeService::getTextFromPDF($application->resume, $request->type);

            return $data['choices'][0]['text'];
        }

        if ($request->type == 'value_summery') {
            $data = ResumeService::getTextFromPDF($application->resume, $request->type, $values);

            return $data['choices'][0]['text'];
        }

        return 'Something is not right.';
    }
}
