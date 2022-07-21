<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Applicant;
use Carbon\Carbon;
use Modules\HR\Entities\Application;

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
			\DB::raw('MONTHNAME(created_at) as month_created_at'),
			\DB::raw('DATE(created_at) as date_created_at')
		)
			->where('created_at', '>', Carbon::now()->subDays(30))
			->groupBy('date_created_at', 'month_created_at')
			->orderBy('date_created_at', 'ASC')
			->get();
		$record_1 = Application::select(
			\DB::raw('DATE(created_at) as date_created_at'),
			\DB::raw('ifnull(COUNT(is_verified), 0) as c')
		)
			->where('is_verified', 1)
			->groupBy('date_created_at')
			->orderBy('date_created_at', 'ASC')
			->get();
		$data = [];
		foreach ($record as $row) {
			$data['data'][] = (int) $row->count;
			$data['label'][] = (new Carbon($row->date_created_at))->format('M d');
		}
		foreach ($record_1 as $value) {
			$data['afterBody'][] = (int) $value->c;
		}
		$data['chartData'] = json_encode($data);

		return view('hr.recruitment.reports', $data, compact('todayCount'));
	}

	public function searchBydate(Request $req)
	{
		$todayCount = Applicant::whereDate('created_at', '=', Carbon::today())
			->count();

		$record = Applicant::select(
			\DB::raw('COUNT(*) as count'),
			\DB::raw('MONTHNAME(created_at) as month_created_at'),
			\DB::raw('DATE(created_at) as date_created_at')
		)
			->where('created_at', '>=', $req->report_start_date)
			->where('created_at', '<=', $req->report_end_date)
			->groupBy('date_created_at', 'month_created_at')
			->orderBy('date_created_at', 'ASC')
			->get();

		$record_1 = Application::select(
			\DB::raw('ifnull(COUNT(is_verified), 0) as c'),
			\DB::raw('DATE(created_at) as date_created_at')
		)
			->where('is_verified', 1)
			->groupBy('date_created_at')
			->get();

		$data = [];

		foreach ($record as $row) {
			$data['label'][] = (new Carbon($row->date_created_at))->format('M d');
			$data['data'][] = (int) $row->count;
		}
		foreach ($record_1 as $value) {
			$data['afterBody'][] = (int) $value->c;
		}
		$data['chartData'] = json_encode($data);

		return view('hr.recruitment.reports', $data, compact('todayCount'));
	}
}
