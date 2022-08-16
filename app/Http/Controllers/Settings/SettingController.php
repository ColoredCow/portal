<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\ContentHelper;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;

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

    public function updateInvoiceTemplates(SettingRequest $request)
    {
        foreach ($validated['setting_key'] as $key => $value) {
            Setting::updateOrCreate(
                ['module' => 'invoice', 'setting_key' => $key],
                ['setting_value' => $value ? ContentHelper::editorFormat($value) : null]
            );
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }

    public function organizationData()
    {
        return view('settings.organization.organization');
    }

    public function createOrganization(Request $request)
    {
        $org = Organization::create([
            'name' => $request->name,
            'address' => $request->address,
            'annual_sales' => $request->annual_sales,
            'members' => $request->members,
            'industry' => $request->industry,
            'email' => $request->email,
            'billing_details' => $request->billing_details,
            'website' => $request->website,
        ]);

        return back();
    }
}
