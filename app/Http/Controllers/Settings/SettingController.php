<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\ContentHelper;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use App\Helpers\RoleHelper;

class SettingController extends Controller
{
    public function index()
    {
        $this->authorize('view', Setting::class);
        $hasAnyRole = RoleHelper::hasAnyRole(auth()->user(), ['super-admin', 'admin', 'finance-manager']);

        return view('settings.index', compact('hasAnyRole'));
    }

    public function ndaTemplates()
    {
    }

    public function invoiceTemplates()
    {
        $attr['settings'] = Setting::where('module', 'invoice')->get()->keyBy('setting_key');

        return view('settings.invoice.index', $attr);
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

    public function showBankDetails()
    {
        $this->authorize('viewBankDetails', Setting::class);
        return view('settings.bank-details');
    }
}
