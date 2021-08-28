<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Entities\PaymentConfiguration;

class PaymentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentConfig = PaymentConfiguration::formatAll();

        return view('payment::settings.index', ['paymentConfig' => $paymentConfig]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return view('payment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('payment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $setting => $value) {
            $dataToUpdate = [];
            $dataToFind = ['slug' => $setting];
            $dataToUpdate['label'] = Str::title($setting);
            $dataToUpdate['value'] = $value;
            $salaryConfiguration = PaymentConfiguration::updateOrCreate($dataToFind, $dataToUpdate);
        }

        return redirect(route('payment-setting.index'));
    }
}
