<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display the financial reports
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $request = request();
        if ($request->get('start') && $request->get('end'))
        {
            $startDate = $request->get('start');
            $endDate = $request->get('end');
            $invoices = Invoice::filterByDates($startDate, $endDate);
            return view('finance.reports.index')->with([
                'invoices' => $invoices,
                'report' => self::getReportDetails($invoices),
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        }

        $invoices = Invoice::all();
        return view('finance.reports.index')->with([
            'invoices' => $invoices,
            'report' => self::getReportDetails($invoices),
        ]);
    }

    /**
     * Get an details of the report in the passed invoices to be printed
     *
     * @param  \Illuminate\Database\Eloquent\Collection $invoices
     * @return array
     */
    public static function getReportDetails($invoices)
    {
        $report = [];
        $report['tds'] = 0;
        $report['gst'] = 0;
        foreach (config('constants.currency') as $currency => $currencyMeta) {
            $report['sentAmount'][$currency] = 0;
            $report['paidAmount'][$currency] = 0;
            $report['transactionCharge'][$currency] = 0;
            $report['transactionTax'][$currency] = 0;
        }
        foreach ($invoices as $invoice) {
            $report['gst'] += $invoice->gst;
            $report['sentAmount'][$invoice->currency_sent_amount] += $invoice->sent_amount;

            if ($invoice->status == 'paid')
            {
                $report['tds'] += $invoice->tds;

                $report['paidAmount'][$invoice->currency_paid_amount] += $invoice->paid_amount;
                $report['transactionCharge'][$invoice->currency_transaction_charge] += $invoice->transaction_charge;
                $report['transactionTax'][$invoice->currency_transaction_tax] += $invoice->transaction_tax;
            }
        }

        foreach ($report['sentAmount'] as $currency => $sentAmount)
        {
            if ($currency == 'INR') {
                $report['dueAmount'][$currency] = $sentAmount - $report['paidAmount'][$currency] - $report['tds'] - $report['transactionCharge'][$currency] - $report['transactionTax'][$currency];
            } else {
                $report['dueAmount'][$currency] = $sentAmount - $report['paidAmount'][$currency] - $report['transactionCharge'][$currency] - $report['transactionTax'][$currency];
            }
        }

        return $report;
    }
}
