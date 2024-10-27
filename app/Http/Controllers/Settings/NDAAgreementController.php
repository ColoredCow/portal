<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Modules\HR\Entities\Round;

class NDAAgreementController extends Controller
{
    public function index()
    {
        $attr = [];
        $this->authorize('view', Setting::class);
        $attr['settings'] = Setting::where('module', 'agreement-nda')->get()->keyBy('setting_key');
        $attr['rounds'] = Round::all();
        $attr['roundMailTypes'] = [
            config('constants.hr.status.confirmed'),
            config('constants.hr.status.rejected'),
        ];

        return view('settings.agreement.nda.index')->with($attr);
    }
}
