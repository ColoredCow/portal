<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use App\Imports\ApplicationImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Job;
use Modules\HR\Http\Requests\Recruitment\ApplicantRequest;

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
}
