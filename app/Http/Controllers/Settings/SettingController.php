<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\ContentHelper;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    
    public function index()
    {
        $this->authorize('view', Setting::class);

        return view('settings.index');
    }

    public function ndaTemplates()
    {
    }

    public function invoiceTemplates()
    {
        $attr['settings'] = Setting::where('module', 'invoice')->get()->keyBy('setting_key');

        return view('settings.invoice.index', $attr);
    }

    public function teaminteraction(Request $request)
    {
       // dd($request->all());
        $subject = Setting::where('module', 'hr')->where('setting_key', 'hr_team_interaction_round_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'hr_team_interaction_round_body')->first();
        $body->setting_value = str_replace("|*OFFICE LOCATION*|", $request->location, $body->setting_value);
        $body->setting_value = str_replace("|*DATE SELECTED*|",$request->date, $body->setting_value) ;
        $body->setting_value = str_replace("|*TIME RANGE*|",date('h:i a' , strtotime($request->starttime)) ."-". date('h:i a' , strtotime($request->endtime)), $body->setting_value);
        $body->setting_value = str_replace("|*APPLICANT NAME*|",$request->applicantName, $body->setting_value) ;
       //dd(date('d M Y' , strtotime($request->date)));
        //$body->setting_value = str_replace("|*endtime*|",$request->endtime, $body->setting_value);
        //Setting::update([])
        $body->save();
       // dd(Str::contains($body->setting_value, '|*OFFICE LOCATION*|'));
      // Str::contains($myString, 'itsolutionstuff.com');
        return response()->json([
            'subject'=> $subject->setting_value,
            'body' => $body->setting_value,
        ]);
    }

    public function updateInvoiceTemplates(SettingRequest $request)
    {
        $validated = $request->validated();
        foreach ($validated['setting_key'] as $key => $value) {
            Setting::updateOrCreate(
                ['module' => 'invoice', 'setting_key' => $key],
                ['setting_value' => $value ? ContentHelper::editorFormat($value) : null]
            );
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }
}
