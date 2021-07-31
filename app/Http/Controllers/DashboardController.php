<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sql;
use Carbon\Carbon;

class DashboardController extends Controller
{
    function index(){

  
         $table = Sql::where('created_at', '>=',Carbon::today()->subDay(7))->orderBy('created_at', 'ASC')->get();
    
         $record = Sql::select(\DB::raw("DAY(created_at) as day"),\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"))
         ->where('created_at', '>', Carbon::today()->subDay(20))
         ->groupBy('day_name','day')
         ->orderBy('day')
         ->get();
      
         $data = [];
     
         foreach($record as $row) {
            $data['label'][] = $row->day_name;
            $data['data'][] = (int) $row->count;
          }
     
        $data['chart_data'] = json_encode($data);
        return view('graph', $data,compact('table'));      
    
   }
   function searchBydate(Request $req)
   {
        $table = Sql::where('created_at', '>=', Carbon::now()->subDays(7))->orderBy('created_at', 'ASC')->get();

        $record = Sql::select(\DB::raw("DAY(created_at) as day"),\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"))
         ->where('created_at', '>=',$req->from )
         ->where('created_at', '>=',$req->to )
         ->groupBy('day_name','day')
         ->orderBy('day')
         ->get();
      
         $data = [];
     
         foreach($record as $row) {
            $data['label'][] = $row->day_name;
            $data['data'][] = (int) $row->count;
          }
     
        $data['chart_data'] = json_encode($data);
        return view('graph', $data,compact('table'));
   }
           
}
