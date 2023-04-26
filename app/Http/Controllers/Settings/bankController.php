<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\BankDetails; 
use Illuminate\Http\Request;
use App\Helpers\ContentHelper;

class bankController extends Controller
{
    public function index()
    {
        $view = 'settings.bank-details';

        return view($view);
    }

    public function update(Request $request)
    {
        foreach ($request['key'] as $key => $value) {
            $bankDetail = BankDetails::create(['key' => $key, 'value' => $value ? ContentHelper::editorFormat($value) : null]);
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }
}
