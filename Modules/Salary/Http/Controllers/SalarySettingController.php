<?php

namespace Modules\Salary\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Salary\Entities\SalaryConfiguration;

class SalarySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $salaryConfig = SalaryConfiguration::formatAll();

        return view('salary::settings.index', ['salaryConfig' => $salaryConfig]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('salary::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('salary::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('salary::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $setting => $value) {
            $dataToUpdate = [];
            $dataToFind = ['slug' => $setting];
            $dataToUpdate['label'] = Str::title($setting);
            if (is_array($value)) {
                $dataToUpdate['percentage_rate'] = $value['rate'];
                $dataToUpdate['percentage_applied_on'] = 'gross_salary';
            } else {
                $dataToUpdate['fixed_amount'] = $value;
            }
            $salaryConfiguration = SalaryConfiguration::updateOrCreate($dataToFind, $dataToUpdate);
        }

        return redirect(route('salary-settings.index'));
    }

}
