<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Invoice\Services\CurrencyService;
use Modules\Invoice\Services\InvoiceService;
use Modules\Invoice\Entities\CurrencyAvgRate;
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

        return $results;
    }

    private function getParticularAmountForExport(array $particular, Object $startDate, Object $endDate): array
    {
        $invoices = $this->invoiceService->getInvoicesBetweenDates($startDate, $endDate, 'non-indian');
        $totalAmount = 0;
        $results = [];

        // ToDo:: We need to change this logic and get the exchange rate for every month.
        $exchangeRates = CurrencyAvgRate::select('avg_rate', 'captured_for')->groupBy('captured_for')->get()->toArray();
        foreach ($exchangeRates as $exchangeRate) {
            if ($exchangeRate['avg_rate']) {
                $exchangeDollor =  $exchangeRate['avg_rate'];
            } else {
                $exchangeDollor = app(CurrencyService::class)->getCurrentRatesInINR();
            }
        }
        foreach ($invoices as $invoice) {
            $amount = ($invoice->amount) * ($exchangeDollor);
            $dateKey = $invoice->sent_on->format('m-y');
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }

        $results['total'] = $totalAmount;

        return $results;
    }

    // ToDo:: Defining all the required particular functions below.
    // We need to add the definition in each function to get the amount for each particular.

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

        foreach ($revenues as $revenue) {
            $amount = $revenue->amount;
            $year = substr($revenue->year, -2);
            $month = sprintf('%02d', $revenue->month);
            $dateKey = $month . '-' . $year;
            $totalAmount += $amount;
            $results[$dateKey] = ($results[$dateKey] ?? 0) + $amount;
        }
        $results['total'] = $totalAmount;

        return $results;
    }
}
