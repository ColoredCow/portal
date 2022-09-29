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

    public function findVolunteerApplicant()
    {
        $jobs = Job::where('type', 'volunteer')->get('id');

        $data = array();
        foreach ($jobs as $job) {
            $data[] = $job->id;
        }
        $todayCount = Application::whereDate('created_at', now())->whereIn('hr_job_id', $data)
            ->count();
        $record = Application::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month_created_at'),
            \DB::raw('DATE(created_at) as date_created_at')
        )
            ->where('created_at', '>', Carbon::now()->subDays(23))
            ->whereIn('hr_job_id', $data)
            ->groupBy('date_created_at', 'month_created_at')
            ->orderBy('date_created_at', 'ASC')
            ->get();

        $data = [];
        foreach ($record as $row) {
            $data['label'][] = (new Carbon($row->date_created_at))->format('M d');
            $data['data'][] = (int) $row->count;
            $verifiedApplications = Application::where('is_verified', 1)->whereDate('created_at', '=', date(new Carbon($row->date_created_at)))->count();
            $data['afterBody'][] = $verifiedApplications;
        }
        $data['chartData'] = json_encode($data);

        return view('hr.volunteers.reportresult')->with([
            'chartData' => $data['chartData'],
            'todayCount' => $todayCount
        ]);
    }
}
