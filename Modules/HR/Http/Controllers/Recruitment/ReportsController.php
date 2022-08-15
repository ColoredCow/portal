<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Applicant;
use Carbon\Carbon;
use Google\Service\Blogger\Resource\Posts;
use Illuminate\Support\Str;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Round;
use Modules\HR\Entities\HRRejectionReason;

class ReportsController extends Controller
{
    /**
     * Display the employee reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.recruitment.reportcard');
    }

    public function searchBydate(Request $req)
    {
        $req->report_start_date = $req->report_start_date ?? carbon::now()->startOfMonth() == $req->report_end_date = $req->report_end_date ?? Carbon::today();

        $todayCount = Applicant::whereDate('created_at', '=', Carbon::today())
        ->count();

        $record = Applicant::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month_created_at'),
            \DB::raw('DATE(created_at) as date_created_at'),
        )
            ->wheredate('created_at', '>=', $req->report_start_date)
            ->wheredate('created_at', '<=', $req->report_end_date)
            ->groupBy('date_created_at', 'month_created_at')
            ->orderBy('date_created_at', 'ASC')
            ->get();
        $data = [];
        $verifiedApplicationCount = $this->getVerifiedApplicationsCount();
        foreach ($record as $row) {
            $data['label'][] = (new Carbon($row->date_created_at))->format('M d');
            $data['data'][] = (int) $row->count;
            $verifiedApplications = Application::where('is_verified', 1)->whereDate('created_at', '=', date(new Carbon($row->date_created_at)))->count();
            $data['afterBody'][] = $verifiedApplications;
        }
        $data['chartData'] = json_encode($data);

        return view('hr.recruitment.reports')->with([
        'chartData' => $data['chartData'],
        'todayCount' => $todayCount,
        'verifiedApplicationsCount' => $verifiedApplicationCount]);
    }

    private function getVerifiedApplicationsCount()
    {
        $from = config('hr.verified_application_date.start_date');
        $currentDate = Carbon::today(config('constants.timezone.indian'));

        return Application::whereBetween('created_at', [$from, $currentDate])
            ->where('is_verified', 1)->count();
    }

    public function showReportCard()
    {
        $todayCount = Applicant::whereDate('created_at', now())
        ->count();
        $record = Applicant::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month_created_at'),
            \DB::raw('DATE(created_at) as date_created_at')
        )
        ->where('created_at', '>', Carbon::now()->subDays(23))
        ->groupBy('date_created_at', 'month_created_at')
        ->orderBy('date_created_at', 'ASC')
        ->get();

        $data = [];
        $verifiedApplicationCount = $this->getVerifiedApplicationsCount();

        foreach ($record as $row) {
            $data['data'][] = (int) $row->count;
            $data['label'][] = (new Carbon($row->date_created_at))->format('M d');
            $verifiedApplications = Application::where('is_verified', 1)->whereDate('created_at', '=', date(new Carbon($row->date_created_at)))->count();
            $data['afterBody'][] = $verifiedApplications;
        }

        $data['chartData'] = json_encode($data);

        return view('hr.recruitment.reports')->with([
            'chartData' => $data['chartData'],
            'todayCount' => $todayCount, 'verifiedApplicationsCount' => $verifiedApplicationCount,
        ]);
    }
    public function jobWiseApplicationsGraph(Request $request)
    {
        $filters = $request->all();
        $jobs = [];
        $jobs = Job::all();
        $jobsTitle = $jobs->pluck('title');
        $applicationCount = [];
        $totalApplicationCount = 0;
        foreach ($jobs as $job) {
            if (! empty($filters)) {
                $count = Application::whereBetween('created_at', $filters)->where('hr_job_id', $job->id)->count();
            } else {
                $count = Application::where('hr_job_id', $job->id)->count();
            }
            $totalApplicationCount += $count;
            $applicationCount[] = $count;
        }
        $chartData = [
            'jobsTitle' => $jobsTitle,
            'application' => $applicationCount,
        ];

        return view('hr.recruitment.job-Wise-Applications-Graph')->with([
            'totalCount' => $totalApplicationCount,
            'chartData' => json_encode($chartData)
        ]);
    }
    public function showResult(Request $request)
    {
        $filters = $request->all();
        $data = HRRejectionReason::select(\DB ::raw('reason_title as label'), \DB::Raw('COUNT(id) as count'))
            ->groupBy('reason_title');

        $reasonsList = $data->pluck('label')->toArray();
        foreach ($reasonsList as $index => $reason) {
            $reasonsList[$index] =  Str::of($reason)->replace('-', ' ');
        }

        $applicationCountArray = $data->pluck('count')->toArray();
        $rounds = Round::select('name as title', 'id')->get();
        $count = [];
        foreach ($rounds as $round) {
            $count[] = ApplicationRound::where('hr_round_id', $round->id)
            ->where('round_status', 'rejected')
            ->count();
        }

        $round = $rounds->pluck('title');
        $chartData = [
            'totalapplication'=> $round,
            'count' => $count,
        ];

        $chartBarData = [
            'reason' => $reasonsList,
            'Applicationcounts' => $applicationCountArray,
        ];

        return view('hr.recruitment.rejected-applications')->with([
            'count'=>$count,
            'Applicationcounts' => $applicationCountArray,
            'chartData' => json_encode($chartData),
            'chartBarData' => json_encode($chartBarData)
        ]);
    }
}
