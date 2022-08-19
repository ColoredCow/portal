<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\ContentHelper;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Organization;
use App\Http\Requests\OrganizationRequest;

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
        $validated = $request->validated();
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

    public function createOrganization(OrganizationRequest $request)
    {
        $validatedData = $request->validated();
        $org = Organization::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'annual_sales' => $validatedData['annual_sales'],
            'members' => $validatedData['members'],
            'industry' => $validatedData['industry'],
            'email' => $validatedData['email'],
            'billing_details' => $validatedData['billing_details'],
            'website' => $validatedData['website'],
        ]);

        return back()->with('message', 'Organization Details Added Successfully');
    }
}
