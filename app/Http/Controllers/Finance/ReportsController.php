<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
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
        $this->authorize('view', ReportsController::class);

        return view('finance.reports.index')->with(self::getReportAttributes());
    }

    /**
     * Get a complete list attributes and their values to be displayed on the reports page
     * @return array
     */
    public static function getReportAttributes()
    {
        $request = request();

        $startDate = null;
        $endDate = null;
        $showingResultsFor = '';
        $attr = [];

        switch ($request->get('type')) {
            case 'monthly':
                if ($request->get('month') && $request->get('year')) {
                    $date = $request->get('year') . '-' . $request->get('month') . '-01';
                    $startDate = new Carbon($date);
                    $endDate = $startDate->copy()->endOfMonth();
                } else {
                    $startDate = new Carbon('first day of this month');
                    $endDate = new Carbon('today');
                }
                $showingResultsFor = $startDate->format('F Y');
                $startDate = $startDate->format(config('constants.date_format'));
                $endDate = $endDate->format(config('constants.date_format'));
                $attr['monthsList'] = DateHelper::getPreviousMonths(config('constants.finance.reports.list-previous-months'));
                break;

            case 'dates':
                if ($request->get('start') && $request->get('end')) {
                    $startDate = $request->get('start');
                    $endDate = $request->get('end');
                    $showingResultsFor = (new Carbon($startDate))->format(config('constants.full_display_date_format')) . ' - ' . (new Carbon($endDate))->format(config('constants.full_display_date_format'));
                }
                break;
        }

        $attr['showingResultsFor'] = $showingResultsFor;

        if ($startDate && $endDate) {
            $invoices = Invoice::filterByDates($startDate, $endDate);
            $attr['startDate'] = $startDate;
            $attr['endDate'] = $endDate;
        } else {
            $invoices = Invoice::all();
        }

        $arrangedInvoices = self::arrangeInvoices($invoices, $startDate, $endDate);
        $attr['sentInvoices'] = $arrangedInvoices['sent'];
        $attr['paidInvoices'] = $arrangedInvoices['paid'];

        $attr['report'] = self::getCumulativeAmounts($arrangedInvoices['sent'], $arrangedInvoices['paid']);
        $unpaidInvoices = Invoice::filterByEndDateAndStatus($endDate);
        foreach (config('constants.currency') as $currency => $currencyMeta) {
            $attr['totalReceivables'][$currency] = 0;
        }
        foreach ($unpaidInvoices as $invoice) {
            $attr['totalReceivables'][$invoice->currency_sent_amount] += $invoice->sent_amount;
        }

        return $attr;
    }

    /**
     * Get financial calcucations based on sent and paid invoices to be shown in the reports
     * @param  \Illuminate\Database\Eloquent\Collection $sentInvoices
     * @param  \Illuminate\Database\Eloquent\Collection $paidInvoices
     * @return array
     */
    public static function getCumulativeAmounts($sentInvoices, $paidInvoices)
    {
        $report = [];
        foreach (config('constants.currency') as $currency => $currencyMeta) {
            $report['sentAmount'][$currency] = 0;
            $report['paidAmount'][$currency] = [
                'converted' => 0,
                'default' => 0,
            ];
            $report['transactionCharge'][$currency] = 0;
            $report['transactionTax'][$currency] = 0;
            $report['dueAmount'][$currency] = 0;
            $report['receivable'][$currency] = 0;
        }

        $report['gst'] = 0;
        foreach ($sentInvoices as $invoice) {
            $report['gst'] += $invoice->gst;
            $report['sentAmount'][$invoice->currency_sent_amount] += $invoice->sent_amount;

            if ($invoice->status != 'paid') {
                $report['receivable'][$invoice->currency_sent_amount] += $invoice->sent_amount;
            }
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

    /**
     * arrange invoices based on their start and end date
     *
     * @param  \Illuminate\Database\Eloquent\Collection $invoices
     * @param  string $start    Start date
     * @param  string $end      End date
     * @return array
     */
    public static function arrangeInvoices($invoices, $start = null, $end = null)
    {
        $arrangedInvoices = [
            'sent' => [],
            'paid' => [],
        ];
        if ($start && $end) {
            foreach ($invoices as $invoice) {
                $sent = $start <= $invoice->sent_on && $invoice->sent_on <= $end ? true : false;
                $paid = $invoice->status == 'paid' && $start <= $invoice->paid_on && $invoice->paid_on <= $end ? true : false;

                if ($sent) {
                    $arrangedInvoices['sent'][] = $invoice;
                }
                if ($paid) {
                    $arrangedInvoices['paid'][] = $invoice;
                }
            }
        } else {
            foreach ($invoices as $invoice) {
                $arrangedInvoices['sent'][] = $invoice;
                $paid = $invoice->status == 'paid' ? true : false;

                if ($paid) {
                    $arrangedInvoices['paid'][] = $invoice;
                }
            }
        }
        return $arrangedInvoices;
    }
}
