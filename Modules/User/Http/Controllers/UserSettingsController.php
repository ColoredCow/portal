<?php
namespace Modules\User\Http\Controllers;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Modules\HR\Entities\MaximumSlot;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserSettingsController extends ModuleBaseController 
{     
  public function index()
  {         
    return view('user::user-settings.index');
  }           
  
  public function storeData(Request $request)     
  {         
    DB::table('user_meta')->insert([             
      'user_id' => Auth::user()->id,             
      'max_appointments_per_day'=>$request->max_appointments_per_day,             
    ]);
    
    return redirect('/user/user-settings/hr')->with('status', 'Saved Successfully!');      
  }
  
