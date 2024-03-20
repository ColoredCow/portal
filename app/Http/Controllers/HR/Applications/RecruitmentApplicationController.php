<?php

namespace App\Http\Controllers\HR\Applications;

use Illuminate\Support\Facades\Request;
use Modules\HR\Entities\Application;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class RecruitmentApplicationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = request()->filter;

        switch ($filter) {
            case 'last-week':
                $startDate = Carbon::now()->startOfWeek()->subWeek();
                $endDate = Carbon::now()->endOfWeek()->subWeek();
                break;
            case 'last-month':
                $startDate = Carbon::now()->startOfMonth()->subMonth();
                $endDate = Carbon::now()->endOfMonth()->subMonth();
                break;
            case 'last-quarter':
                $startDate = Carbon::now()->startOfQuarter()->subQuarter();
                $endDate = Carbon::now()->endOfQuarter()->subQuarter();
                break;
        }

        $rejectedApplicationCount = Application::where('status', 'rejected')
            ->whereDate('updated_at', '>=', $startDate)
            ->whereDate('updated_at', '<=', $endDate)
            ->count();

        $receivedApplicationCount = Application::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();


        return [
            "total_received_applications" => $receivedApplicationCount,
            "total_rejected_applications" => $rejectedApplicationCount,
            "total_introductory_call_applications" => 30,
            "total_new_applications" => 50,
            "filter" => request()->filter
        ];
    }
}
