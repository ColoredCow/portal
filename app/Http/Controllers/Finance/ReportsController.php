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

    public static function getReportDetails($invoices)
    {
        $report = [];
        $report['tds'] = 0;
        $report['gst'] = 0;
        foreach ($invoices as $invoice) {
            $report['gst'] += $invoice->gst;
            if (!isset($report['sentAmount'][$invoice->currency_sent_amount])) {
                $report['sentAmount'][$invoice->currency_sent_amount] = 0;
                $report['paidAmount'][$invoice->currency_sent_amount] = 0;
            }
            $report['sentAmount'][$invoice->currency_sent_amount] += $invoice->sent_amount;

            if ($invoice->status == 'paid')
            {
                $report['tds'] += $invoice->tds;
                $report['paidAmount'][$invoice->currency_paid_amount] += $invoice->paid_amount;
            }
        }

        foreach ($report['sentAmount'] as $currency => $sentAmount)
        {
            if ($currency == 'INR') {
                $report['dueAmount'][$currency] = $sentAmount - $report['paidAmount'][$currency] - $report['tds'];
            } else {
                $report['dueAmount'][$currency] = $sentAmount - $report['paidAmount'][$currency];
            }
        }

        return $report;
    }
}
