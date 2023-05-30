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
use Modules\HR\Entities\ApplicantMeta;
use Modules\HR\Services\ApplicantService;

class ApplicantController extends Controller
{
    use AuthorizesRequests;

    protected $service;

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
        $job_title = Job::where('opportunity_id', $validated['opportunity_id'])->get();
        $subscriptionLists = $job_title->first()->title;

        try {
            $this->service->addSubscriberToCampaigns($validated, $subscriptionLists);
        } catch (\Exception $e) {
            return redirect(route('applications.job.index'))->with('error', 'Error occurred while sending data to Campaign');
        }

        $this->service->saveApplication($validated);
        return redirect(route('applications.job.index'));
    }

    // public function addSubscriberToCampaigns($parameters, $subscriptionLists)
    // {
    //     $name = $parameters['first_name'] . ' ' . $parameters['last_name'];

    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type'=>'application/json'
    //         // Add more headers if needed
    //     ])
    //     ->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZjc5MWEwYjgyYjdjMDk2MGQ1ZWJiM2I4ZTllMjFhMDkwZDE0ZGYyOGQ3MDFiNjcwYjU5NjBlYzUzOTNmZTk3ZjlmNmQzYWZkMWIzYTc4NzkiLCJpYXQiOjE2ODUxOTA2MzguNDExOTc3LCJuYmYiOjE2ODUxOTA2MzguNDExOTg0LCJleHAiOjE3MTY4MTMwMzguMjMxNjE0LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.n2d73JJFxTIygS224jHfWlM_QCUBYNkGVWxukeZGXpS2iTwV5DPtGIJrAkIkeBSPW8d36WaX6ywTS6crPsfHzOHyJ95VrOKi0csn26S5uxRUMlsF7ceOEqAk7WAysNuL6c7npMJsosxr9YcpmFHc1AYAmWIzlwB_LWLcQ-Ez1MZonqoS59Y7D2oqQ-TiG5Abnok3KlwYNlDMXGuzH5-kVjbjyUqm2luevCls1E_e6YXZrK4ObTEQVDOcP61I49IzWNWUk0f4jWGqq8XEZOsvGW8QfaqxrxEib2Z8vnPvBbFGua5x93M7F2ADrq-jSMFdIdLlCgq0E0nYxCLVPEHvjg1X1UvoT9dcskv904WoY0yZPYFNxdvlvZYDy8fYeJPOhj2AagiMzI0ILtomim1JISNK7ij4uJEwr5sZSE3HybyDxdM3Wyrf-qt8L6PD7I5zAMrosQePxQILMBMCF9KPP3vQYCdlaIiuff9oC7BcmSKnEajGtVDp1LNCGizeydjsLqG9G3NXglW01TBGuK_WRSG9g4OdH6itjAUWoz0bM5k0Y8Dzf9U7bCJSeUnz1QV4D2MCSHyAgEkpIyKL-MuKwRDW2X41_TVIWxi-3q8VZ3u1AxRVshWf9e47Lsm6c4yaPDQ69HNFeO6w6mxbvPwYHV6MgEtqOyg_V2zKrjNMHLw')
    //     ->post('http://127.0.0.1:8000/api/v1/addSubscriber', [
    //         'name' => $name,
    //         'email' =>  $parameters['email'],
    //         'phone' => $parameters['phone'],
    //         'subscription_lists' => [$subscriptionLists],
    //     ]);

    //     $jsonData = $response->json();
    // }

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
}
