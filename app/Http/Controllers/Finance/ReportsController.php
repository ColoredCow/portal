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

        if ($request->get('show') && $request->get('show') == 'default') {
            $startDate = new Carbon('first day of last month');
            $endDate = new Carbon('last day of last month');
            $formattedStartDate = $startDate->format(config('constants.date_format'));
            $formattedEndDate = $endDate->format(config('constants.date_format'));
            $invoices = Invoice::filterByDates($formattedStartDate, $formattedEndDate);
            $attr = [
                'invoices' => $invoices,
                'report' => self::getReportDetails($invoices),
                'startDate' => $formattedStartDate,
                'endDate' => $formattedEndDate,
                'showingResultsFor' => $startDate->format('F Y'),
            ];
        } else if ($request->get('start') && $request->get('end')) {
            $startDate = $request->get('start');
            $endDate = $request->get('end');
            $invoices = Invoice::filterByDates($startDate, $endDate);
            $showingResultsFor = (new Carbon($startDate))->format('F d, Y') . ' - ' . (new Carbon($endDate))->format('F d, Y');
            $attr = [
                'invoices' => $invoices,
                'report' => self::getReportDetails($invoices),
                'startDate' => $startDate,
                'endDate' => $endDate,
                'showingResultsFor' => $showingResultsFor,
            ];
        } else {
            $invoices = Invoice::all();
            $attr = [
                'invoices' => $invoices,
                'report' => self::getReportDetails($invoices),
                'showingResultsFor' => '',
            ];
        }

        return view('finance.reports.index')->with($attr);
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
            $report['paidAmount'][$currency] = [
                'converted' => 0,
                'default' => 0
            ];
            $report['transactionCharge'][$currency] = 0;
            $report['transactionTax'][$currency] = 0;
        }
        $report['totalPaidAmount'] = 0;
        foreach ($invoices as $invoice) {
            $report['gst'] += $invoice->gst;
            $report['sentAmount'][$invoice->currency_sent_amount] += $invoice->sent_amount;

            if ($invoice->status == 'paid') {

                $paidAmount = $invoice->paid_amount;
                $report['paidAmount'][$invoice->currency_paid_amount]['default'] += $paidAmount;
                if ($invoice->currency_paid_amount != 'INR') {
                    $conversionRate = $invoice->conversion_rate ?? 1;
                    $paidAmount = $invoice->paid_amount * $conversionRate;
                    $report['paidAmount'][$invoice->currency_paid_amount]['converted'] += $paidAmount;
                }
                $report['totalPaidAmount'] += $paidAmount;

                $report['tds'] += $invoice->tds;
                $report['transactionCharge'][$invoice->currency_transaction_charge] += $invoice->transaction_charge;
                $report['transactionTax'][$invoice->currency_transaction_tax] += $invoice->transaction_tax;
            }
        }

        foreach ($report['sentAmount'] as $currency => $sentAmount) {
            if ($currency == 'INR') {
                $report['dueAmount'][$currency] = $sentAmount - $report['paidAmount'][$currency]['default'] - $report['tds'] - $report['transactionCharge'][$currency];
            } else {
                $report['dueAmount'][$currency] = $sentAmount - $report['paidAmount'][$currency]['default'] - $report['transactionCharge'][$currency];
            }
        }

        return $report;
    }
}
