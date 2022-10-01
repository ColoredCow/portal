<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Invoice\Services\CurrencyService;
use Modules\Invoice\Services\InvoiceService;
use Modules\Revenue\Entities\RevenueProceed;
use Modules\Invoice\Entities\CurrencyAvgRate;

class RevenueReportService
{
    protected $invoiceService;

    protected $avgCurrencyRates;

    protected $defaultCurrencyRates;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
        $this->defaultCurrencyRates = app(CurrencyService::class)->getCurrentRatesInINR();
    }

    private function getAvgCurrencyRates($startDate, $endDate)
    {
        $results = [];

        $currencyAvgRates = CurrencyAvgRate::where('captured_for', '>=', $startDate)
            ->where('captured_for', '<=', $endDate)
            ->get();

        foreach ($currencyAvgRates as $currencyAvgRate) {
            $key = $currencyAvgRate->captured_for->format('m-Y');
            $currency = $currencyAvgRate->currency;
            $results[$key][$currency] = $currencyAvgRate->avg_rate;
        }

        return $results;
    }

    public function getAllParticulars(int $startYear, int $endYear): array
    {
        $this->avgCurrencyRates = $this->getAvgCurrencyRates($startYear, $endYear);
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

        return $results;
    }

    private function getParticularAmountForExport(array $particular, Object $startDate, Object $endDate): array
    {
        $totalAmount = 0;
        $results = [];
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'non-indian');

        foreach ($invoices as $invoice) {
            $dateKey = $invoice->sent_on->format('m-y');
            $exchangeRate = $this->avgCurrencyRates[$dateKey][$invoice->currency] ?? $this->defaultCurrencyRates;
            $amount = ($invoice->amount) * ($exchangeRate);
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }

    private function getParticularAmountForCommissionReceived(array $particular, Object $startDate, Object $endDate): array
    {
        return $this->getAmountsForRevenueProceeds(Str::snake($particular['name']), $startDate, $endDate);
    }

    private function getParticularAmountForCashBack(array $particular, Object $startDate, Object $endDate): array
    {
        return $this->getAmountsForRevenueProceeds(Str::snake($particular['name']), $startDate, $endDate);
    }

    private function getParticularAmountForDiscountReceived(array $particular, Object $startDate, Object $endDate): array
    {
        return $this->getAmountsForRevenueProceeds(Str::snake($particular['name']), $startDate, $endDate);
    }

    private function getParticularAmountForInterestOnFd(array $particular, Object $startDate, Object $endDate): array
    {
        return $this->getAmountsForRevenueProceeds(Str::snake($particular['name']), $startDate, $endDate);
    }

    private function getParticularAmountForForeignExchangeLoss(array $particular, Object $startDate, Object $endDate): array
    {
        return $this->getAmountsForRevenueProceeds(Str::snake($particular['name']), $startDate, $endDate);
    }

    private function getAmountsForRevenueProceeds($category, $startDate, $endDate)
    {
        $revenues = RevenueProceed::where('category', $category)
            ->where('received_at', '>=', $startDate)
            ->where('received_at', '<=', $endDate)
            ->get();

        $totalAmount = 0;
        $results = [];

        $exchangeRate = 1; // For INR

        foreach ($revenues as $revenue) {
            $amount = $revenue->amount;
            $year = substr($revenue->year, -2);
            $month = sprintf('%02d', $revenue->month);
            $dateKey = $month . '-' . $year;

            if (strtolower($revenue->currency) != 'inr') {
                $exchangeRate = $this->avgCurrencyRates[$dateKey][$revenue->currency] ?? $this->defaultCurrencyRates;
            }

            $amount = $amount * $exchangeRate;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
            $totalAmount += $amount;
        }

        $results['total'] = $totalAmount;

        return $results;
    }
}
