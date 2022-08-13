<?php

namespace Modules\HR\Http\Controllers\Universities;

use Illuminate\Routing\Controller;
use Modules\HR\Entities\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('reports', University::class);

        return view('hr::universities.reports');
    }

    public function show(University $report)
    {
        $datas = DB::table('hr_applications')
    ->select(['hr_jobs.title', 'hr_applicants.college', DB::raw('count(hr_applications.id) as total_applications')])
    ->join('hr_applicants', 'hr_applicants.id', '=', 'hr_applications.hr_applicant_id')
    ->join('hr_jobs', 'hr_jobs.id', '=', 'hr_applications.hr_job_id')
    ->where('hr_applicants.hr_university_id', '=', $report->id)
    ->groupby('hr_jobs.id')
    ->get();

        $jobTitle = [];
        $applicationsCount = [];

        foreach ($datas as $data) {
            $jobTitle[] = $data->title;
            $applicationsCount[] = $data->total_applications;
        }

        $universityDataChart = [
        'jobTitle' => $jobTitle,
        'applications' => $applicationsCount,
    ];

        return view('hr::universities.reports')->with([
            'university' => $report,
            'universityDataChart' => json_encode($universityDataChart)
        ]);
    }
}
