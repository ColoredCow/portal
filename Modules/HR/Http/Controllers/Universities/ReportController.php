<?php

namespace Modules\HR\Http\Controllers\Universities;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\University;

class ReportController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('reports', University::class);

        return view('hr::universities.reports');
    }

    public function jobWiseApplicationsData(University $university)
    {
        $data = DB::table('hr_applications')
            ->select(['hr_jobs.title', 'hr_applicants.college', DB::raw('count(hr_applications.id) as total_applications')])
            ->join('hr_applicants', 'hr_applicants.id', '=', 'hr_applications.hr_applicant_id')
            ->join('hr_jobs', 'hr_jobs.id', '=', 'hr_applications.hr_job_id')
            ->where('hr_applicants.hr_university_id', '=', $university->id)
            ->groupby('hr_jobs.id')
            ->get();

        $jobTitle = $data->pluck('title');
        $jobTitle->all();

        $applicationsCount = $data->pluck('total_applications');
        $applicationsCount->all();

        $universityDataChart = [
            'jobTitle' => $jobTitle,
            'applications' => $applicationsCount,
        ];

        return view('hr::universities.reports')->with([
            'university' => $university,
            'universityDataChart' => json_encode($universityDataChart),
        ]);
    }
}
