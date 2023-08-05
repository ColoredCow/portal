<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\PaymentRequest;
use App\Models\Finance\Invoice;
use App\Models\Finance\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('finance.payments.index')->with([
            'payments' => Payment::latest()->paginate(config('constants.pagination_size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('finance.payments.create')->with([
            'unpaidInvoices' => Invoice::unpaid()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
        $validated = $request->validated();

        $mode = self::handleMode($validated);
        $args = self::prepareAttributes($validated, $mode);
        $payment = Payment::create($args);

        return redirect()->route('payments.edit', $payment)->with('status', 'Payment created succesfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Payment  $payment
     *
     * @return \Illuminate\View\View
     */
    public function edit(Payment $payment)
    {
        $payment->load('invoice', 'mode');

        return view('finance.payments.edit')->with([
            'payment' => $payment,
            'unpaidInvoices' => Invoice::unpaid()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Finance\PaymentRequest  $request
     * @param  \App\Models\Finance\Payment  $payment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();

        $mode = self::handleMode($validated, $payment);
        $args = self::prepareAttributes($validated, $mode);
        $payment->update($args);

        return redirect()->back()->with('status', 'Payment updated succesfully!');
    }

    /**
     * Prepare attributes to store or update the resource.
     *
     * @param  array  $validated
     * @param  mixed $mode      WireTransfer, Cash or Cheque
     *
     * @return array
     */
    protected static function prepareAttributes(array $validated, $mode)
    {
        $modes = config('constants.finance.payments.modes');
        $args = [
            'invoice_id' => $validated['invoice_id'],
            'paid_at' => $validated['paid_at'],
            'currency' => $validated['currency'],
            'amount' => $validated['amount'],
            'mode_id' => $mode->id,
            'mode_type' => $modes[$mode->type],
        ];
        $countryTransactionDetails = [];
        if ($validated['currency'] != 'INR') {
            $countryTransactionDetails = [
                'bank_charges' => $validated['bank_charges'],
                'conversion_rate_diff' => $validated['conversion_rate_diff'],
                'bank_service_tax_forex' => $validated['bank_service_tax_forex'],
            ];
        } else {
            $countryTransactionDetails = [
                'tds' => $validated['tds'],
            ];
        }

        return array_merge($args, $countryTransactionDetails);
    }

    /**
     * Handles the payment mode of the resource.
     *
     * @param  array  $validated
     * @param  Payment $payment
     *
     * @return mixed            Cash, WireTransfer or Cheque
     */
    protected static function handleMode(array $validated, ?Payment $payment = null)
    {
        $attr = [];
        switch ($validated['mode']) {
            case 'wire-transfer':
                if (isset($validated['wire_transfer_via'])) {
                    $attr['via'] = $validated['wire_transfer_via'];
                }
                break;

            case 'cheque':
                $attr['status'] = $validated['cheque_status'];
                $dateField = $validated['cheque_status'] . '_on';
                $attr[$dateField] = DateHelper::formatDateToSave($validated["cheque_{$dateField}"]);
                break;
        }

        $model = config('constants.finance.payments.modes.' . $validated['mode']);

        // If the payment has not been created yet, create and
        // return the mode so that the payment can be created.
        if (is_null($payment)) {
            return $model::create($attr);
        }

        $payment->load('mode');

        // If the new payment mode is same as the previous one, update the mode.
        // Else, delete the previous mode and create a new one.
        if ($payment->mode->type == $validated['mode']) {
            $payment->mode->update($attr);

            return $payment->mode;
        }

        $payment->mode->delete();

        return $model::create($attr);
    }
}
