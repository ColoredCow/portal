<?php

namespace App\Http\Controllers\HR\Applications;

use Modules\HR\Entities\Application;
use Illuminate\Support\Facades\Request;
use Modules\HR\Http\Controllers\Recruitment\ApplicationController;
use Modules\HR\Services\ApplicationService;

class VolunteerApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'volunteer';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = [
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $this->getApplicationType(),
            'job' => request()->get('hr_job_id'),
            'name' => request()->get('search'),
        ];
        $applications = Application::with(['applicant', 'job'])
            ->applyFilter($filters)
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Request::except('page'));

        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
        ];

        return view('hr.application.volunteer.index')->with($attr);
    }
    public function findVolunteerApplicant()
    {
        $todaycount = (new ApplicationService())->TodayVolunteerCount();
        $chartData = (new ApplicationService())->getVolunteerChartData();
        return view('hr.volunteers.daily-volunteer-application-report')
            ->with([
                'chartData' => $chartData,
                'todayCount' => $todaycount
            ]);
    }
}
