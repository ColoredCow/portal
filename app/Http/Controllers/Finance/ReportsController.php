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
        if ($request->get('start') && $request->get('end')) {
            $startDate = $request->get('start');
            $endDate = $request->get('end');
            $invoices = Invoice::getSentAndReceivedInvoicesByDate($startDate, $endDate);
            $arrangedInvoices = self::arrangeInvoices($invoices, $startDate, $endDate);
            $attr = [
                'sentInvoices' => $arrangedInvoices['sent'],
                'paidInvoices' => $arrangedInvoices['paid'],
                'report' => self::getReportDetails($arrangedInvoices['sent'], $arrangedInvoices['paid']),
                'startDate' => $startDate,
                'endDate' => $endDate,
                'displayStartDate' => (new Carbon($startDate))->format('F d, Y'),
                'displayEndDate' => (new Carbon($endDate))->format('F d, Y'),
            ];
        } else {
            $invoices = Invoice::all();
            $attr = [
                'sentInvoices' => $invoices,
                'paidInvoices' => $invoices,
                'report' => self::getReportDetails($invoices, $invoices),
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
    public static function getReportDetails($sentInvoices, $paidInvoices)
    {
        $report = [];
        foreach (config('constants.currency') as $currency => $currencyMeta) {
            $report['sentAmount'][$currency] = 0;
            $report['paidAmount'][$currency] = [
                'converted' => 0,
                'default' => 0
            ];
            $report['transactionCharge'][$currency] = 0;
            $report['transactionTax'][$currency] = 0;
            $report['dueAmount'][$currency] = 0;
        }

        $report['gst'] = 0;
        foreach ($sentInvoices as $invoice) {
            $report['gst'] += $invoice->gst;
            $report['sentAmount'][$invoice->currency_sent_amount] += $invoice->sent_amount;
        }

        $report['tds'] = 0;
        $report['totalPaidAmount'] = 0;
        foreach ($paidInvoices as $invoice) {
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
            $report['dueAmount'][$invoice->currency_due_amount] += $invoice->due_amount;
        }

        return $report;
    }

    public static function arrangeInvoices($invoices, $start, $end)
    {
        $arrangedInvoices = [];
        foreach ($invoices as $invoice) {
            $sent =  $start <= $invoice->sent_on && $invoice->sent_on <= $end ? true : false;
            $paid = $invoice->status == 'paid' && $start <= $invoice->paid_on && $invoice->paid_on <= $end ? true : false;

            if ($sent) {
                $arrangedInvoices['sent'][] = $invoice;
            }
            if ($paid) {
                $arrangedInvoices['paid'][] = $invoice;
            }
        }
        return $arrangedInvoices;
    }
}
