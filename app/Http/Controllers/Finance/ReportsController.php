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
        $startDate = new Carbon('first day of last month');
        $endDate = new Carbon('last day of last month');
        // $request = request();
        // if ($request->get('start') && $request->get('end'))
        // {
        //     $startDate = $request->get('start');
        //     $endDate = $request->get('end');
            // dd(Invoice::filterByDates($startDate, $endDate)->count());
        // dd(Invoice::filterByDates($startDate, $endDate)->count());
            $invoices = Invoice::filterByDates($startDate, $endDate);
            return view('finance.reports.index')->with([
                'invoices' => $invoices,
                'report' => self::getReportDetails($invoices)
            ]);
        // }

        return view('finance.reports.index')->with([
            'invoices' => Invoice::all()->count()
        ]);
    }

    public static function getReportDetails($invoices)
    {
        $report = [];
        $report['tds'] = 0;
        $report['gst'] = 0;
        foreach ($invoices as $invoice) {
            $report['gst'] += $invoice->gst;
            if (!isset($report['sentAmount'][$invoice->currency_paid_amount])) {
                $report['sentAmount'][$invoice->currency_paid_amount] = 0;
            }
            $report['sentAmount'][$invoice->currency_paid_amount] += $invoice->sent_amount;

            if ($invoice->status == 'paid')
            {
                $report['tds'] += $invoice->tds;
                if (!isset($report['paidAmount'][$invoice->currency_paid_amount])) {
                    $report['paidAmount'][$invoice->currency_paid_amount] = 0;
                }
                $report['paidAmount'][$invoice->currency_paid_amount] += $invoice->paid_amount;
            }
        }

        return $report;
    }
}
