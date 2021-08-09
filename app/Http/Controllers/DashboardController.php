<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Applicant;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayCount = Applicant::whereDate('created_at', '=', now())
    ->count();  

        $record = Applicant::select(\DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as month"), \DB::raw("DATE(created_at) as date"))
    ->where('created_at', '>', Carbon::today()->subDay(7))
    ->groupBY('date')
    ->orderBy('date', 'ASC')
    ->get();
       
        $data = [];
    
        foreach ($record as $row) {
            $data['data'][] = (int) $row->count;
            $data['label'][] = $row->date;
        }
    
        $data['chart_data'] = json_encode($data);
        return view('graph', $data, compact('todayCount'));      
    }
  
    public function searchBydate(Request $req)
    {
        $todayCount = Applicant::whereDate('created_at', '=', now())
    ->count();

        $record = Applicant::select(\DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as month"), \DB::raw("DATE(created_at) as date"))
    ->where('created_at', '>=', $req->from )
    ->where('created_at', '<=', $req->to )
    ->groupBy('date')
    ->orderBy('date', 'ASC')
    ->get();
    
        $data = [];
    
        foreach ($record as $row) {
            $data['label'][] = $row->date;
            $data['data'][] = (int) $row->count;
        }
    
        $data['chart_data'] = json_encode($data);
        return view('graph', $data, compact('todayCount'));
    }
           
}
