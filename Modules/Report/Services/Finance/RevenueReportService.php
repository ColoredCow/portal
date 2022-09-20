<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Invoice\Services\CurrencyService;
use Modules\Invoice\Services\InvoiceService;
use Modules\Revenue\Entities\RevenueProceed;

class RevenueReportService
{
    protected $invoiceService;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
    }

    public function getAllParticulars(int $startYear, int $endYear): array
    {
        $particulars = config('report.finance.profit_and_loss.particulars.revenue');
        $results = [];
        foreach ($particulars as $key => $particular) {
            $results[] = $this->getParticularReport($key, $particular, $startYear, $endYear);
        }

        return $results;
    }

    public function getParticularReport(String $particularSlug, array $particular, int $startYear, int $endYear): array
    {
        $startDate = Carbon::parse($startYear . '-04-01')->startOfDay();
        $endDate = Carbon::parse($endYear . '-03-31')->endOfDay();
        $particular['amounts'] = $this->{'getParticularAmountFor' . Str::studly($particularSlug)}($particular, $startDate, $endDate);

        return $particular;
    }

    private function getParticularAmountForDomestic(array $particular, Object $startDate, Object $endDate): array
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'indian');
        $totalAmount = 0;
        $results = [];

        foreach ($invoices as $invoice) {
            $dateKey = $invoice->sent_on->format('m-y');
            $totalAmount += $invoice->amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $invoice->amount;
        }

        $results['total'] = $totalAmount;

        return ['total' => 0];
    }

    private function getParticularAmountForExport(array $particular, Object $startDate, Object $endDate): array
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'non-indian');
        $totalAmount = 0;
        $results = [];

        // ToDo:: We need to change this logic and get the exchange rate for every month.
        $exchangeRates = app(CurrencyService::class)->getCurrentRatesInINR();

        foreach ($invoices as $invoice) {
            $amount = $invoice->amount * $exchangeRates;
            $dateKey = $invoice->sent_on->format('m-y');
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }

        $results['total'] = $totalAmount;

        return ['total' => 0];
    }

    // ToDo:: Defining all the required particular functions below.
    // We need to add the definition in each function to get the amount for each particular.

    private function getParticularAmountForCommissionReceived(array $particular, Object $startDate, Object $endDate): array
    {
        $revenues = RevenueProceed::where('category', 'commission_received')->where('recieved_at', '>', $startDate)->where('recieved_at', '<', $endDate)->get();
        $totalAmount = 0;
        $results = [];

        foreach ($revenues as $revenue) {
            $amount = $revenue-> amount;
            $year =  substr($revenue->year, - 2);
            $month = sprintf("%02d", $revenue->month);
            $dateKey = $month . '-'. $year;
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }

    private function getParticularAmountForCashBack(array $particular, Object $startDate, Object $endDate): array
    {
        $revenues = RevenueProceed::where('category', 'cash_back')->where('recieved_at', '>', $startDate)->where('recieved_at', '<', $endDate)->get();
        $totalAmount = 0;
        $results = [];

        foreach ($revenues as $revenue) {
            $amount = $revenue-> amount;
            $year =  substr($revenue->year, - 2);
            $month = sprintf("%02d", $revenue->month);
            $dateKey = $month . '-'. $year;
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }

    private function getParticularAmountForDiscountReceived(array $particular, Object $startDate, Object $endDate): array
    {
        $revenues = RevenueProceed::where('category', 'discount_received')->where('recieved_at', '>', $startDate)->where('recieved_at', '<', $endDate)->get();
        $totalAmount = 0;
        $results = [];

        foreach ($revenues as $revenue) {
            $amount = $revenue-> amount;
            $year =  substr($revenue->year, - 2);
            $month = sprintf("%02d", $revenue->month);
            $dateKey = $month . '-'. $year;      
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }

    private function getParticularAmountForInterestOnFd(array $particular, Object $startDate, Object $endDate): array
    {
        $revenues = RevenueProceed::where('category', 'interest_on_fd')->where('recieved_at', '>', $startDate)->where('recieved_at', '<', $endDate)->get();
        $totalAmount = 0;
        $results = [];

        foreach ($revenues as $revenue) {
            $amount = $revenue-> amount;
            $year =  substr($revenue->year, - 2);
            $month = sprintf("%02d", $revenue->month);
            $dateKey = $month . '-'. $year;
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }

    private function getParticularAmountForForeignExchangeLoss(array $particular, Object $startDate, Object $endDate): array
    {
        $revenues = RevenueProceed::where('category', 'foreign_exchange_loss')->where('recieved_at', '>', $startDate)->where('recieved_at', '<', $endDate)->get();
        $totalAmount = 0;
        $results = [];

        foreach ($revenues as $revenue) {
            $amount = $revenue-> amount;
            $year =  substr($revenue->year, - 2);
            $month = sprintf("%02d", $revenue->month);
            $dateKey = $month . '-'. $year;
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }
}
