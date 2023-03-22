<?php

namespace Modules\Report\Services\Finance;

use Modules\Client\Entities\Client;
use Modules\Invoice\Entities\Invoice;
use Carbon\Carbon;

class ClientRevenueReportService
{
    protected $dataKeyFormat = 'm-y';

    public function clientWiseRevenue(array $filters): array
    {
        $year = $filters['year'];
        $startYear = $year - 1;
        $endYear = $year;
        $startDate = Carbon::parse($startYear . '-04-01')->startOfDay();
        $endDate = Carbon::parse($endYear . '-03-31')->endOfDay();
        $reportData = $this->generateReportData($startDate, $endDate);

        return $reportData;
    }

    public function generateReportData($startDate, $endDate)
    {
        $clients = Client::orderBy('name')->get();
        $reportData = [];
        foreach ($clients as $client) {
            foreach ($client->projects as $project) {
                $projectId = $project->id;
                $results = $this->getInvoicesForProjectBetweenDates($startDate, $endDate, $projectId);
                
                $clientData = [
                    'client' => $client->name, 
                    'project' => $project->name,
                    'amounts' => $results
                ];
                $reportData[] = $clientData;
            }
        }

        return $reportData;
    }

    public function getInvoicesForProjectBetweenDates($startDate, $endDate, $projectId)
    {
        $invoices = Invoice::sentBetween($startDate, $endDate)
            ->where('project_id', '=', $projectId)
            ->status(['sent', 'paid'])
            ->get();

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
}
