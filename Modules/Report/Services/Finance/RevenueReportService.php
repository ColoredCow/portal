<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Invoice\Services\CurrencyService;
use Modules\Invoice\Services\InvoiceService;


class RevenueReportService
{
    protected $invoiceService;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
    }

    public function getAllParticulars($startYear, $endYear)
    {
        $particulars =  config('report.finance.profit_and_loss.particulars.revenue');
        $results = [];
        foreach ($particulars as $key => $particular) {
            $results[] = $this->getParticularReport($key, $particular, $startYear, $endYear);
        }
        return $results;
    }


    public function getParticularReport($particularSlug, $particular, $startYear, $endYear)
    {
        $startDate =  Carbon::parse($startYear . '-04-01')->startOfDay();
        $endDate = Carbon::parse($endYear . '-03-31')->endOfDay();
        $particular['amounts'] = $this->{"getParticularAmountFor" . Str::studly($particularSlug)}($particular, $startDate, $endDate);
        return $particular;
    }

    private function getParticularAmountForDomestic($particular, $startDate, $endDate)
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'indian');
        $totalAmount = 0;
        $results = [];

        foreach ($invoices as $invoice) {
            $dateKey =  $invoice->sent_on->format('m-y');
            $totalAmount += $invoice->amount;
            $results[$dateKey] =  ($results[$dateKey] ?? 0) + $invoice->amount;
        }

        $results['total'] = $totalAmount;
        return $results;
    }


    private function getParticularAmountForExport($particular, $startDate, $endDate)
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'non-indian');
        $totalAmount = 0;
        $results = [];

        // ToDo:: We need to change this logic and get the exchange rate for every month.
        $exchangeRates = app(CurrencyService::class)->getCurrentRatesInINR();

        foreach ($invoices as $invoice) {
            $amount = $invoice->amount * $exchangeRates;
            $dateKey =  $invoice->sent_on->format('m-y');
            $totalAmount += $amount;
            $results[$dateKey] =  ($results[$dateKey] ?? 0) + $amount;
        }

        $results['total'] = $totalAmount;
        return $results;
    }

    private function getParticularAmountForCommissionReceived($particular, $startDate, $endDate)
    {
        return 0;
    }

    private function getParticularAmountForCashBack($particular, $startDate, $endDate)
    {
        return 0;
    }

    private function getParticularAmountForDiscountReceived($particular, $startDate, $endDate)
    {
        return 0;
    }

    private function getParticularAmountForInterestOnFd($particular, $startDate, $endDate)
    {
        return 0;
    }

    private function getParticularAmountForForeignExchangeLoss($particular, $startDate, $endDate)
    {
        return 0;
    }
}
