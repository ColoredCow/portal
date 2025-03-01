<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Client\Entities\Client;
use Modules\Invoice\Entities\CurrencyAvgRate;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Services\CurrencyService;
use Modules\Invoice\Services\InvoiceService;

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

    public function getParticularReport(string $particularSlug, array $particular, object $startDate, object $endDate): array
    {
        $particular['amounts'] = $this->{'getParticularAmountFor' . Str::studly($particularSlug)}($particular, $startDate, $endDate);

        return $particular;
    }

    public static function getRevenueGroupedByClient($filters)
    {
        $currentPeriodInvoiceDetails = Invoice::with('client')
            ->whereBetween('sent_on', [$filters['current_period_start_date'], $filters['current_period_end_date']])
            ->get();
        $previousPeriodInvoiceDetails = Invoice::with('client')
            ->whereBetween('sent_on', [$filters['previous_period_start_date'], $filters['previous_period_end_date']])
            ->get();
        $data = [];
        $data['current_period_total_amount'] = 0;
        $data['previous_period_total_amount'] = 0;
        $data['clients_name'] = Client::pluck('name')->toArray();
        $numberOfClients = count($data['clients_name']);
        for ($index = 0; $index < $numberOfClients; $index++) {
            $data['current_period_client_data'][$index] = 0;
            $data['previous_period_client_data'][$index] = 0;
        }

        foreach ($currentPeriodInvoiceDetails as $invoice) {
            $data['current_period_total_amount'] += round($invoice->total_amount_in_inr, 2);
            $data['current_period_client_data'][array_search($invoice->client->name, $data['clients_name'])] += round($invoice->total_amount_in_inr, 2);
        }

        foreach ($previousPeriodInvoiceDetails as $invoice) {
            $data['previous_period_total_amount'] += round($invoice->total_amount_in_inr, 2);
            $data['previous_period_client_data'][array_search($invoice->client->name, $data['clients_name'])] += round($invoice->total_amount_in_inr, 2);
        }
        for ($index = 0; $index < $numberOfClients; $index++) {
            if ($data['current_period_client_data'][$index] == 0 && $data['previous_period_client_data'][$index] == 0) {
                unset($data['current_period_client_data'][$index]);
                unset($data['previous_period_client_data'][$index]);
                unset($data['clients_name'][$index]);
            }
        }

        // As unset() also delete the index therefore again setting the value for re-indexing
        $data['current_period_client_data'] = array_values($data['current_period_client_data']);
        $data['previous_period_client_data'] = array_values($data['previous_period_client_data']);
        $data['clients_name'] = array_values($data['clients_name']);

        return $data;
    }

    public static function getRevenueReportDataForClient($filters, $client)
    {
        $amountMonthWise = [];
        $totalAmount = 0;
        $clientDepartments = $client->linkedAsDepartment;
        $clientPartners = $client->linkedAsPartner;

        $clientInvoiceDetails = self::getInvoicesForClient($client, $filters);

        foreach ($clientInvoiceDetails as $invoice) {
            $data = self::handleInvoiceDataForClient($invoice, $amountMonthWise);
            $totalAmount += $data['invoiceAmount'];
            $amountMonthWise = $data['amountMonthWise'];
        }

        foreach ($clientDepartments as $department) {
            $departmentInvoiceDetails = self::getInvoicesForClient($department, $filters);

            foreach ($departmentInvoiceDetails as $invoice) {
                $data = self::handleInvoiceDataForClient($invoice, $amountMonthWise);
                $totalAmount += $data['invoiceAmount'];
                $amountMonthWise = $data['amountMonthWise'];
            }
        }

        foreach ($clientPartners as $partner) {
            $partnerInvoiceDetails = self::getInvoicesForClient($partner, $filters);

            foreach ($partnerInvoiceDetails as $invoice) {
                $data = self::handleInvoiceDataForClient($invoice, $amountMonthWise);
                $totalAmount += $data['invoiceAmount'];
                $amountMonthWise = $data['amountMonthWise'];
            }
        }
        $averageAmount = $totalAmount / count($amountMonthWise);

        return [
            'months' => array_keys($amountMonthWise),
            'amount' => array_values($amountMonthWise),
            'total_amount' => round($totalAmount, 2),
            'average_amount' => round($averageAmount, 2),
        ];
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

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    private function getParticularAmountForDomestic(array $particular, object $startDate, object $endDate): array
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'indian');
        $totalAmount = 0;
        $results = [];

        foreach ($invoices as $invoice) {
            $dateKey = $invoice->sent_on->format($this->dataKeyFormat);
            $totalAmount += (int) $invoice->amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + (int) $invoice->amount;
        }

        $results['total'] = $totalAmount;

        return $results;
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    private function getParticularAmountForExport(array $particular, object $startDate, object $endDate): array
    {
        $totalAmount = 0;
        $results = [];
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'non-indian');

        foreach ($invoices as $invoice) {
            $dateKey = $invoice->sent_on->format($this->dataKeyFormat);
            $exchangeRate = $this->avgCurrencyRates[$dateKey][strtolower($invoice->currency)] ?? $this->defaultCurrencyRates;
            $amount = (float) ($invoice->amount) * (float) ($exchangeRate);
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
            $totalAmount += $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }

    private static function handleInvoiceDataForClient($invoice, $amountMonthWise)
    {
        $invoiceAmount = round($invoice->total_amount_in_inr, 2);
        $amountMonthWise[$invoice->sent_on->format('M-Y')] = ($amountMonthWise[$invoice->sent_on->format('M-Y')] ?? 0) + $invoiceAmount;

        return [
            'invoiceAmount' => $invoiceAmount,
            'amountMonthWise' => $amountMonthWise,
        ];
    }

    private static function getInvoicesForClient($client, $filters)
    {
        return Invoice::where('client_id', $client->id)
            ->whereBetween('sent_on', [$filters['start_date'], $filters['end_date']])
            ->orderby('sent_on')
            ->get();
    }
}
