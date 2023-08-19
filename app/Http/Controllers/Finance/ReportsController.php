<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Finance\Invoice;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display the financial reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', self::class);

        return view('finance.reports.index')->with(self::getReportAttributes());
    }

    /**
     * Get a complete list attributes and their values to be displayed on the reports page.
     *
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
            default:
            case 'monthly':
                if ($request->get('month') && $request->get('year')) {
                    $date = $request->get('year') . '-' . $request->get('month') . '-01';
                    $startDate = new Carbon($date);
                    $endDate = $startDate->copy()->endOfMonth();
                } else {
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::today();
                }
                $showingResultsFor = $startDate->format('M Y');
                $attr['monthsList'] = DateHelper::getPreviousMonths(config('constants.finance.reports.list-previous-months'));
                break;

            case 'dates':
                if ($request->get('start') && $request->get('end')) {
                    $startDate = new Carbon($request->get('start'));
                    $endDate = new Carbon($request->get('end'));
                    $showingResultsFor = $startDate->format(config('constants.full_display_date_format')) . ' - ' . $endDate->format(config('constants.full_display_date_format'));
                }
                break;
        }

        $attr['showingResultsFor'] = $showingResultsFor;

        if ($startDate && $endDate) {
            $invoices = Invoice::filterByDates($startDate, $endDate);
            $attr['startDate'] = $startDate->format(config('constants.date_format'));
            $attr['endDate'] = $endDate->format(config('constants.date_format'));
        } else {
            $invoices = Invoice::all();
        }

        $arrangedInvoices = self::arrangeInvoices($invoices, $startDate, $endDate);

        $attr['sentInvoices'] = $arrangedInvoices['sent'];
        $attr['paidInvoices'] = $arrangedInvoices['paid'];

        $attr['report'] = self::getCumulativeAmounts($arrangedInvoices['sent'], $arrangedInvoices['paid']);

        return $attr;
    }

    /**
     * Get financial calcucations based on sent and paid invoices to be shown in the reports.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $sentInvoices
     * @param  \Illuminate\Database\Eloquent\Collection $paidInvoices
     *
     * @return array
     */
    public static function getCumulativeAmounts($sentInvoices, $paidInvoices)
    {
        $report = [
            'gst' => 0,
            'tds' => 0,
            'totalPaidAmount' => 0,
            'totalPayments' => 0,
            'bankServiceTaxForex' => 0,
        ];
        foreach (config('constants.currency') as $currency => $currencyMeta) {
            $report['sentAmount'][$currency] = 0;
            $report['paidAmount'][$currency] = [
                'converted' => 0,
                'default' => 0,
            ];
            $report['bankCharges'][$currency] = 0;
            $report['dueAmount'][$currency] = 0;
            $report['receivable'][$currency] = 0;
            $report['totalReceivables'][$currency] = 0;
        }

        foreach ($sentInvoices as $invoice) {
            $report['gst'] += $invoice->gst;
            $report['sentAmount'][$invoice->currency] += $invoice->amount;

            if (! $invoice->payments->count()) {
                $report['receivable'][$invoice->currency] += $invoice->amount;
            }
        }

        foreach ($paidInvoices as $invoice) {
            $report['totalPayments'] += $invoice->payments->count();
            foreach ($invoice->payments as $payment) {
                $paidAmount = $payment->amount;
                $report['paidAmount'][$payment->currency]['default'] += $paidAmount;

                if ($payment->currency != 'INR') {
                    $conversionRate = $payment->conversion_rate_diff ?? 1;
                    $paidAmount = $payment->amount * $conversionRate;
                    $report['paidAmount'][$payment->currency]['converted'] += $paidAmount;
                }

                $report['totalPaidAmount'] += $paidAmount;
                $report['tds'] += $payment->tds;

                $report['bankCharges'][$payment->currency] += $payment->bank_charges;
                $report['bankServiceTaxForex'] += $payment->bank_service_tax_forex;
                // $report['dueAmount'][$invoice->currency_due_amount] += $invoice->due_amount;
            }
        }

        return $report;
    }

    /**
     * arrange invoices based on their start and end date.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $invoices
     * @param  Carbon $start    Start date
     * @param  Carbon $end      End date
     *
     * @return array
     */
    public static function arrangeInvoices($invoices, ?Carbon $start = null, ?Carbon $end = null)
    {
        $arrangedInvoices = [
            'sent' => [],
            'paid' => [],
        ];
        if ($start && $end) {
            foreach ($invoices as $invoice) {
                if ($start <= $invoice->sent_on && $invoice->sent_on <= $end) {
                    $arrangedInvoices['sent'][] = $invoice;
                }
                if ($invoice->payments->count()) {
                    foreach ($invoice->payments as $payment) {
                        if ($start <= $payment->paid_at && $payment->paid_at <= $end) {
                            $arrangedInvoices['paid'][] = $invoice;
                            break;
                        }
                    }
                }
            }
        } else {
            foreach ($invoices as $invoice) {
                $arrangedInvoices['sent'][] = $invoice;
                if ($invoice->payments->count()) {
                    $arrangedInvoices['paid'][] = $invoice;
                }
            }
        }

        return $arrangedInvoices;
    }
}
