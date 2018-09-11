<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\PaymentRequest;
use App\Models\Finance\Invoice;
use App\Models\Finance\Payment;
use App\Models\Finance\PaymentModes\Cash;
use App\Models\Finance\PaymentModes\Cheque;
use App\Models\Finance\PaymentModes\WireTransfer;

class PaymentController extends Controller
{
    public function index()
    {
        return view('finance.payments.index')->with([
            'payments' => Payment::paginate(config('constants.pagination_size')),
        ]);
    }

    public function create()
    {
        return view('finance.payments.create')->with([
            'unpaidInvoices' => Invoice::getUnpaidInvoices(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Finance\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
    	$validated = $request->validated();

        $modes = config('constants.finance.payments.modes');
        switch ($validated['mode']) {
        	default:
            case 'cash':
                $mode = Cash::create();
                break;

            case 'wire-transfer':
                $wireTransfer = [];
                if (isset($validated['wire_transfer_via'])) {
                    $wireTransfer['via'] = $validated['wire_transfer_via'];
                }
                $mode = WireTransfer::create($wireTransfer);
                break;

            case 'cheque':
                $cheque = ['status' => $validated['cheque_status']];
                switch ($validated['cheque_status']) {
                    case 'received':
                        $dateField = 'received_on';
                        break;

                    case 'cleared':
                        $dateField = 'cleared_on';
                        break;

                    case 'bounced':
                        $dateField = 'bounced_on';
                        break;
                }
                $cheque[$dateField] = DateHelper::formatDateToSave($validated["cheque_$dateField"]);
                $mode = Cheque::create($cheque);
                break;
        }

        $payment = Payment::create([
        	'invoice_id' => $validated['invoice_id'],
        	'paid_at' => $validated['paid_at'],
        	'currency' => $validated['currency'],
        	'amount' => $validated['amount'],
        	'bank_charges' => $validated['bank_charges'],
        	'bank_service_tax_forex' => $validated['bank_service_tax_forex'],
        	'tds' => $validated['tds'],
        	'conversion_rate' => $validated['conversion_rate'],
        	'mode_id' => $mode->id,
        	'mode_type' => $modes[$mode->type],
        ]);

        return $payment;
    }

    public function edit(Payment $payment)
    {
        $payment->load('invoice');
        return view('finance.payments.edit')->with([
            'payment' => $payment,
            'unpaidInvoices' => Invoice::getUnpaidInvoices(),
        ]);
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();

        $modes = config('constants.finance.payments.modes');
        switch ($validated['mode']) {
            default:
                break;

            case 'cheque':
                // delete previous payment mode if it was not cheque.
                // create a new cheque in that case.

                $cheque = ['status' => $validated['cheque_status']];
                switch ($validated['cheque_status']) {
                    case 'received':
                        $dateField = 'received_on';
                        break;

                    case 'cleared':
                        $dateField = 'cleared_on';
                        break;

                    case 'bounced':
                        $dateField = 'bounced_on';
                        break;
                }
                $cheque[$dateField] = DateHelper::formatDateToSave($validated["cheque_$dateField"]);
                $payment->mode->update($cheque);
                break;
        }

        $payment = $payment->update([
            'invoice_id' => $validated['invoice_id'],
            'paid_at' => $validated['paid_at'],
            'currency' => $validated['currency'],
            'amount' => $validated['amount'],
            'bank_charges' => $validated['bank_charges'],
            'bank_service_tax_forex' => $validated['bank_service_tax_forex'],
            'tds' => $validated['tds'],
            'conversion_rate' => $validated['conversion_rate'],
            'mode_id' => $mode->id,
            'mode_type' => $modes[$mode->type],
        ]);

        return $payment;
    }
}
