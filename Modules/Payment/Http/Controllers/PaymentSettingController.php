<?php
namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $setting => $value) {
            $dataToUpdate = [];
            $dataToFind = ['slug' => $setting];
            $dataToUpdate['label'] = Str::title($setting);
            $dataToUpdate['value'] = $value;
            PaymentConfiguration::updateOrCreate($dataToFind, $dataToUpdate);
        }

        return redirect(route('payment-setting.index'));
    }
}
