<?php

namespace Modules\Report\Services\Finance;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Invoice\Entities\Invoice;
use Modules\Client\Entities\ClientAddress;
use Modules\Report\Exports\MonthlySalesRegisterReportExport;

class MonthlSalesRegisterService
{
    public function index($filters)
    {
        $invoices = Invoice::query()->applyfilters($filters)
            ->orderBy('sent_on', 'desc');

        $igst = [];
        $cgst = [];
        $sgst = [];
        $clientAddress = [];
        foreach ($invoices->get() as $invoice) {
            $clientAddress[] = ClientAddress::select('*')->where('client_id', $invoice->client_id)->first();
            $igst[] = (int) $invoice->display_amount * (int) config('invoice.invoice-details.igst') / 100;
            $cgst[] = (int) $invoice->display_amount * (int) config('invoice.invoice-details.cgst') / 100;
            $sgst[] = (int) $invoice->display_amount * (int) config('invoice.invoice-details.sgst') / 100;
        }

        return [
            'invoices' => $invoices->paginate(config('constants.pagination_size')),
            'clientAddress' => $clientAddress,
            'igst' => $igst,
            'cgst' => $cgst,
            'sgst' => $sgst
        ];
    }

    public function defaultMonthlySalesRegisterReportFilters()
    {
        return [
            'region' => 'indian',
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
        ];
    }

    public function exportReport($filters)
    {
        $invoices = Invoice::query()
        ->applyFilters($filters)
        ->orderBy('sent_on', 'desc')
        ->get();

        $month = $filters['month'] ?? null;
        $year = $filters['year'] ?? null;
        if (isset($filters['region'])) {
            $invoices = $filters['region'] == config('invoice.region.indian') ? $this->formatSalesReportForExportIndian($invoices) : $this->formatSalesReportForExportInternational($invoices);
        }

        return Excel::download(new MonthlySalesRegisterReportExport($invoices), "Monthly-Sales-Register-Report-{$month}-{$year}.xlsx");
    }

    public function formatSalesReportForExportIndian($invoices)
    {
        return $invoices->map(function ($invoice) {
            $clientAddress[] = ClientAddress::select('*')->where('client_id', $invoice->client_id)->first();
            $igst[] = (int) $invoice->display_amount * (int) config('invoice.invoice-details.igst') / 100;
            $cgst[] = (int) $invoice->display_amount * (int) config('invoice.invoice-details.cgst') / 100;
            $sgst[] = (int) $invoice->display_amount * (int) config('invoice.invoice-details.sgst') / 100;
            $address = $invoice->client->addresses;

            return [
                'Invoice No.' => $invoice->invoice_number,
                'Invoice Date' => $invoice->created_at->format(config('invoice.default-date-format')),
                'Client Name' => $invoice->client->name,
                'Client complete Address' => $invoice->client->addresses->first() ? $address->first()->completeAddress : '',
                'Type (B2B/B2G/B2C)' => 'India',
                'GSTN_No' => $clientAddress[0] ? $clientAddress[0]->gst_number : 'B2C',
                'Item Description' => $invoice->project ? $invoice->project->name : '',
                'Units (Hrs.)' => $invoice->project ? $invoice->project->total_estimated_hours : '',
                'Unit Rate' => optional($invoice->client->billingDetails)->service_rates,
                'Total taxable' => (int) ($invoice->amount + $invoice->gst),
                'GST Rate (%)' => 18,
                'IGST Value' => $clientAddress[0] ? (($clientAddress[0]->state != config('invoice.invoice-details.billing-state')) && ($clientAddress[0]->country_id == 1) ? $igst[0] : '0') : '',
                'CGST Value' => $clientAddress[0] ? (($clientAddress[0]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[0]->country_id == 1) ? $cgst[0] : '0') : '',
                'SGST Value' => $clientAddress[0] ? (($clientAddress[0]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[0]->country_id == 1) ? $sgst[0] : '0') : '',
                'Net Total' => $invoice->totalAmount
            ];
        });
    }

    public function formatSalesReportForExportInternational($invoices)
    {
        return $invoices->map(function ($invoice) {
            $clientAddress[] = ClientAddress::select('*')->where('client_id', $invoice->client_id)->first();
            $address = $invoice->client->addresses;

            return [
                'Invoice No.' => $invoice->invoice_number,
                'Invoice Date' => $invoice->created_at->format(config('invoice.default-date-format')),
                'Client Name' => $invoice->client->name,
                'Client complete Address' => $invoice->client->addresses->first() ? $address->first()->completeAddress : '',
                'Type' => 'Export',
                'Item Description' => $invoice->project ? $invoice->project->name : '',
                'Units (Hrs.)' => $invoice->project ? $invoice->project->total_estimated_hours : '',
                'Rate (FCY)' => optional($invoice->client->billingDetails)->service_rates,
                'Exchange Rate' => $invoice->conversion_rate,
                'Total Amont (INR)' => $invoice->invoiceAmountInInr,
                'Net Total' => $invoice->totalAmountInInr
            ];
        });
    }
}
