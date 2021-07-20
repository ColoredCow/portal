<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sql;
use Carbon\Carbon;

class DashboardController extends Controller
{
    function index(){

        $date = Carbon::now()->subDays(7);
  
        $all = Sql::where('created_at', '>=', $date)->orderBy('created_at', 'ASC')->get();
    
        $user=DB::table('hr_applicants')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as number'))
        ->groupBy('date')
        ->get();
       
       return view('graph',compact('user','all'));
   }        
    }
