<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Applicant;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display the employee reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $todayCount = Applicant::whereDate('created_at', '=', now())
            ->count();
        $record = Applicant::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month'),
            \DB::raw('DATE(created_at) as date')
        )
            ->where('created_at', '>', Carbon::now()->subDays(7))
            ->groupBY('date')
            ->orderBy('date', 'ASC')
            ->get();

        $data = [];

        foreach ($record as $row) {
            $data['data'][] = (int) $row->count;
            $data['label'][] = $row->date;
        }

        $data['chart_data'] = json_encode($data);

        return view('hr.recruitment.reports', $data, compact('todayCount'));
    }

    public function searchBydate(Request $req)
    {
        $todayCount = Applicant::whereDate('created_at', '=', Carbon::today())
            ->count();

        $record = Applicant::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month'),
            \DB::raw('DATE(created_at) as date')
        )
            ->where('created_at', '>=', $req->from)
            ->where('created_at', '<=', $req->to)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $data = [];

        foreach ($record as $row) {
            $data['label'][] = $row->date;
            $data['data'][] = (int) $row->count;
        }

        $data['chart_data'] = json_encode($data);

        return view('hr.recruitment.reports', $data, compact('todayCount'));
    }
}
