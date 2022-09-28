<?php

namespace App\Http\Controllers\HR\Volunteers;

use Modules\HR\Entities\Job;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Applicant;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    /**
     * Display the employee reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.volunteers.reports');
    }
    
    private function getVerifiedApplicationsCount()
    {
        $from = config('hr.verified_application_date.start_date');
        $currentDate = Carbon::today(config('constants.timezone.indian'));

        return Application::whereBetween('created_at', [$from, $currentDate])
            ->where('is_verified', 1)->count();
    }
}
