<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Client\Entities\Client;
use Modules\Invoice\Services\CurrencyService;
use Modules\Invoice\Services\InvoiceService;
use Modules\Revenue\Entities\RevenueProceed;
use Modules\Invoice\Entities\CurrencyAvgRate;
use Modules\Invoice\Entities\Invoice;

class RevenueReportService
{
    protected $invoiceService;

    protected $avgCurrencyRates;

    protected $defaultCurrencyRates;

    protected $dataKeyFormat = 'm-y';

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
        $this->defaultCurrencyRates = app(CurrencyService::class)->getCurrentRatesInINR();
    }

    private function getAvgCurrencyRates($startDate, $endDate)
    {
        $results = [];

        $currencyAvgRates = CurrencyAvgRate::whereDate('captured_for', '>=', $startDate)
            ->whereDate('captured_for', '<=', $endDate)
            ->get();
        foreach ($currencyAvgRates as $currencyAvgRate) {
            $key = $currencyAvgRate->captured_for->format($this->dataKeyFormat);
            $currency = strtolower($currencyAvgRate->currency);
            $results[$key][$currency] = $currencyAvgRate->avg_rate;
        }

        return $results;
    }

    public function getAllParticulars(int $startYear, int $endYear): array
    {
        $particulars = config('report.finance.profit_and_loss.particulars.revenue');
        $startDate = Carbon::parse($startYear . '-04-01')->startOfDay();
        $endDate = Carbon::parse($endYear . '-03-31')->endOfDay();
        $this->avgCurrencyRates = $this->getAvgCurrencyRates($startDate, $endDate);

        $results = [];
        foreach ($particulars as $key => $particular) {
            $results[] = $this->getParticularReport($key, $particular, $startDate, $endDate);
        }

        return $results;
    }

    public function getParticularReport(String $particularSlug, array $particular, Object $startDate, Object $endDate): array
    {
        $particular['amounts'] = $this->{'getParticularAmountFor' . Str::studly($particularSlug)}($particular, $startDate, $endDate);

        return $particular;
    }

    private function getParticularAmountForDomestic(array $particular, Object $startDate, Object $endDate): array
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'indian');
        $totalAmount = 0;
        $results = [];

        foreach ($invoices as $invoice) {
            $dateKey = $invoice->sent_on->format($this->dataKeyFormat);
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
            $dateKey = $invoice->sent_on->format($this->dataKeyFormat);
            $exchangeRate = $this->avgCurrencyRates[$dateKey][strtolower($invoice->currency)] ?? $this->defaultCurrencyRates;
            $amount = ($invoice->amount) * ($exchangeRate);
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
            $totalAmount += $amount;
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

    private function getParticularAmountForStripeIndia(array $particular, Object $startDate, Object $endDate): array
    {
        return $this->getAmountsForRevenueProceeds(Str::snake($particular['name']), $startDate, $endDate);
    }

    private function getParticularAmountForStripeInternational(array $particular, Object $startDate, Object $endDate): array
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
                $exchangeRate = $this->avgCurrencyRates[$dateKey][strtolower($revenue->currency)] ?? $this->defaultCurrencyRates;
            }

            $amount = $amount * $exchangeRate;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
            $totalAmount += $amount;
        }

        $results['total'] = $totalAmount;

        return $results;
    }

    public function getClientWiseRevenue($filters)
    {
        $currentPeriodInvoiceDetails = Invoice::with('client')
            ->whereBetween('sent_on', [$filters['current_period_start_date'], $filters['current_period_end_date']])
            ->get();
        $previousPeriodInvoiceDetails = Invoice::with('client')
            ->whereBetween('sent_on', [$filters['previous_period_start_date'], $filters['previous_period_end_date']])
            ->get();
        $data['current_period_total_amount'] = 0;
        $data['previous_period_total_amount'] = 0;
        $data['clients_name'] = Client::status('active')->pluck('name')->toArray();;
        $numberOfActiveClients = count($data['clients_name']);

        for ($index = 0; $index < $numberOfActiveClients; $index++) {
            $data['current_period_client_data'][$index] = 0;
            $data['previous_period_client_data'][$index] = 0;
        }

        foreach ($currentPeriodInvoiceDetails as $invoice) {
            $data['current_period_total_amount'] += round($invoice->total_amount_in_inr, 2);
            $data['current_period_client_data'][array_search($invoice->client->name, $data['clients_name'], )] += round($invoice->total_amount_in_inr, 2);
        }

        foreach ($previousPeriodInvoiceDetails as $invoice) {
            $data['previous_period_total_amount'] += round($invoice->total_amount_in_inr, 2);
            $data['previous_period_client_data'][array_search($invoice->client->name, $data['clients_name'])] += round($invoice->total_amount_in_inr, 2);
        }

        return $data;
    }
}
