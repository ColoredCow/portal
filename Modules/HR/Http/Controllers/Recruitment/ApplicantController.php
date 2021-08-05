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
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @return void
     */
    public function index(ApplicantRequest $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $hrJobs = Job::whereIn('type', ['job', 'internship'])->orderBy('title')->get();

        return view('hr.application.create', ['hrJobs' => $hrJobs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @return \Illuminate\Http\Response
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
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        $job = Job::find($request->job_id);
        Excel::import(new ApplicationImport($job), request()->file('excel_file'));

        return redirect(route('applications.job.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return void
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\ApplicantRequest  $request
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return void
     */
    public function update(ApplicantRequest $request, Applicant $applicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return void
     */
    public function destroy(Applicant $applicant)
    {
        //
    }

    /**
     * To update applicant university.
     *
     * @param Applicant $applicant
     * @param Request $request
     * @return Response
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
