<?php
namespace Modules\Salary\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Salary\Entities\SalaryConfiguration;
use Modules\Salary\Http\Requests\SalarySettingRequest;

class SalarySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaryConfig = SalaryConfiguration::formatAll();

        return view('salary::settings.index', ['salaryConfig' => $salaryConfig]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SalarySettingRequest $request
     */
    public function update(SalarySettingRequest $request)
    {
        $validated = $request->validated();
        foreach ($validated as $setting => $value) {
            $dataToUpdate = [];
            $dataToFind = ['slug' => $setting];
            $dataToUpdate['label'] = config('salary.settings.labels.' . $setting);
            if (is_array($value)) {
                $dataToUpdate['percentage_rate'] = $value['rate'];
                $dataToUpdate['percentage_applied_on'] = config('salary.settings.percentage_applies_on.' . $setting);
            } else {
                $dataToUpdate['fixed_amount'] = $value;
            }
            SalaryConfiguration::updateOrCreate($dataToFind, $dataToUpdate);
        }

        return redirect(route('salary.settings'))->with('success', 'Salary settings saved successfully!');
    }
}
