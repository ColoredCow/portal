<?php

namespace Modules\Invoice\Services;

use App\Models\Country;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Support\Facades\Storage;
use Modules\Invoice\Exports\TaxReportExport;
use Modules\Invoice\Exports\MonthlyReportExport;
use Modules\Client\Contracts\ClientServiceContract;
use Modules\Client\Entities\ClientAddress;
use Modules\Invoice\Contracts\InvoiceServiceContract;
use Modules\Invoice\Contracts\CurrencyServiceContract;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;

class InvoiceService implements InvoiceServiceContract
{
    public function index($filters = [])
    {
        $query = Invoice::query();

        $invoices = $this
            ->applyFilters($query, $filters)
            ->get();

        return [
            'invoices' => $invoices,
            'clients' => $this->getClientsForInvoice(),
            'currencyService' => $this->currencyService(),
            'totalReceivableAmount' => $this->getTotalReceivableAmountInINR($invoices),
        ];
    }

    public function getTotalReceivableAmountInINR($invoices)
    {
        $totalAmount = 0;
        $currentRates = $this->currencyService()->getCurrentRatesInINR();

        foreach ($invoices as $invoice) {
            if ($invoice->isAmountInINR()) {
                $totalAmount += (int) $invoice->amount;
                continue;
            }

            $invoiceAmount = $currentRates * (int) $invoice->amount;
            $totalAmount += $invoiceAmount;
        }

        return round($totalAmount, 2);
    }

    public function defaultFilters()
    {
        return [
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
            'status' => 'sent',
        ];
    }

    public function create()
    {
        return [
            'clients' => $this->getClientsForInvoice(),
            'countries' => Country::all(),
        ];
    }

    public function store($data)
    {
        $data['receivable_date'] = $data['due_on'];
        $invoice = Invoice::create($data);
        $this->saveInvoiceFile($invoice, $data['invoice_file']);
        // Todo: We need to update the logic to set invoice numbers. It should get
        // generated using a combination of invoice id, project id, and client id.
        // We can also move this to observer if this function does not have lot of code.
        $this->setInvoiceNumber($invoice, $data['sent_on']);

        return $invoice;
    }

    public function update($data, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->update($data);
        if (isset($data['invoice_file']) and $data['invoice_file']) {
            $this->saveInvoiceFile($invoice, $data['invoice_file']);
            $this->setInvoiceNumber($invoice, $data['sent_on']);
        }

        return $invoice;
    }

    public function edit($id)
    {
        return [
            'invoice' => Invoice::find($id),
            'clients' => $this->getClientsForInvoice(),
            'countries' => Country::all(),
        ];
    }

    public function delete($invoiceID)
    {
        return Invoice::find($invoiceID)->delete();
    }

    public function getUnpaidInvoices()
    {
        return Invoice::status('sent')->with(['client', 'project'])->get();
    }

    public function saveInvoiceFile($invoice, $file)
    {
        $year = $invoice->sent_on->format('Y');
        $month = $invoice->sent_on->format('m');

        $folder = '/invoice/' . $year . '/' . $month;

        $fileName = $file->getClientOriginalName();
        $file = Storage::putFileAs($folder, $file, $fileName, ['visibility' => 'public']);
        $invoice->update(['file_path' => $file]);
    }

    public function getInvoiceFile($invoiceID)
    {
        $invoice = Invoice::find($invoiceID);

        return Storage::download($invoice->file_path, basename($invoice->file_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getClientsForInvoice()
    {
        return app(ClientServiceContract::class)->getAll();
    }

    public function getClientAddressesForInvoice()
    {
        return app(ClientServiceContract::class)->getAll();
    }

    public function currencyService()
    {
        return app(CurrencyServiceContract::class);
    }

    public function dashboard()
    {
        return Invoice::status('sent')->get();
    }

    private function setInvoiceNumber($invoice, $sent_date)
    {
        $invoice->invoice_number = $this->getInvoiceNumber($invoice->client_id, $invoice->project_id, $sent_date);

        return $invoice->save();
    }

    private function applyFilters($query, $filters)
    {
        if ($year = Arr::get($filters, 'year', '')) {
            $query = $query->year($year);
        }

        if ($month = Arr::get($filters, 'month', '')) {
            $query = $query->month($month);
        }

        if ($status = Arr::get($filters, 'status', '')) {
            $query = $query->status($status);
        }

        if ($country = Arr::get($filters, 'country', '')) {
            $query = $query->country($country);
        }

        if ($country = Arr::get($filters, 'region', '')) {
            $query = $query->region($country);
        }

        return $query;
    }

    /**
     *  TaxReports.
     */
    public function defaultTaxReportFilters()
    {
        return [
            'region' => 'indian',
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
            'status' => 'paid',
        ];
    }

    public function taxReport($filters)
    {
        return [
            'invoices' => $this->taxReportInvoices($filters)
        ];
    }

    public function taxReportExport($filters)
    {
        $invoices = $this->taxReportInvoices($filters);
        if (isset($filters['region'])) {
            $invoices = $filters['region'] == config('invoice.region.indian') ? $this->formatInvoicesForExportIndian($invoices) : $this->formatInvoicesForExportInternational($invoices);
        } else {
            $invoices = $this->formatInvoicesForExportAll($invoices);
        }

        return Excel::download(new TaxReportExport($invoices), 'TaxReportExport.xlsx');
    }

    public function invoiceDetails()
    {
        $invoices = Invoice::all();
        foreach ($invoices as $invoice) :
            $clients[] = Client::select('*')->where('id', $invoice->client_id)->first();
        $clientAddress[] = ClientAddress::select('*')->where('client_id', $invoice->client_id)->first();
        endforeach;

        return [
            'invoices' => $invoices,
            'clients' => $clients,
            'clientAddress' => $clientAddress,
            'currentRates' => $this->currencyService()->getCurrentRatesInINR(),
            'totalReceivableAmount' => $this->getTotalReceivableAmountInINR($invoices),
        ];
    }

    public function monthlyReportExport($filters)
    {
        $invoices = $this->monthlyReportInvoices($filters);
        $invoices = $this->formatMonthlyInvoicesForExportAll($invoices);

        return Excel::download(new MonthlyReportExport($invoices), 'MonthlyReportExport.xlsx');
    }

    private function monthlyReportInvoices($filters)
    {
        echo $this->currencyService()->getCurrentRatesInINR();
        die();
        $query = Invoice::query();

        return $this
            ->applyFilters($query, $filters)
            ->get() ?: [];
    }

    private function formatMonthlyInvoicesForExportAll($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Date' =>   $invoice->sent_on->toDateString(),
                'Particular' => Client::select('*')->where('id', $invoice->client_id)->first()->name,
                'Type' => 'India',
                'INVOICE.' => $invoice->invoice_number,
                'GST' => (float) str_replace(['$', '₹'], '', ($invoice)->first()->invoiceAmount()),
                'INVOICE VALUE' => $invoice->invoiceAmount(),
                'RATE' => $this->currencyService()->getCurrentRatesInINR(),
                'RECEIVABLE AMOUNT' => $invoice->amount_paid,
                'TAXABLE AMOUNT' => $invoice->amount,
                'IGST' => ($invoice->amount * 18) / 100,
                'CGST' => ($invoice->amount * 9) / 100,
                'SGST' => ($invoice->amount * 9) / 100,
                'HSN CODE' => '',
            ];
        });
    }

    private function taxReportInvoices($filters)
    {
        $query = Invoice::query();

        return $this
            ->applyFilters($query, $filters)
            ->get() ?: [];
    }

    private function formatInvoicesForExportIndian($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project' => $invoice->project->name,
                'Amount' => $invoice->amount,
                'GST' => $invoice->gst,
                'Amount (+GST)' => (float) str_replace(['$', '₹'], '', $invoice->invoiceAmount()),
                'Received amount' => $invoice->amount_paid,
                'TDS' => number_format((float) $invoice->tds, 2),
                'Sent at' => $invoice->sent_on->format(config('invoice.default-date-format')),
                'Payment at' => $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-',
                'Status' => Str::studly($invoice->status)
            ];
        });
    }

    private function formatInvoicesForExportInternational($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project' => $invoice->project->name,
                'Amount' => $invoice->amount,
                'Received amount' => $invoice->amount_paid,
                'Bank Charges' => $invoice->bank_charges,
                'Conversion Rate Diff' => $invoice->conversion_rate_diff,
                'Conversion Rate' => $invoice->conversion_rate,
                'Sent at' => $invoice->sent_on->format(config('invoice.default-date-format')),
                'Payment at' => $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-',
                'Status' => Str::studly($invoice->status)
            ];
        });
    }

    private function formatInvoicesForExportAll($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project' => $invoice->project->name,
                'Amount' => $invoice->amount,
                'GST' => $invoice->gst,
                'Amount (+GST)' => (float) str_replace(['$', '₹'], '', $invoice->invoiceAmount()),
                'Received amount' => $invoice->amount_paid,
                'Bank Charges' => $invoice->bank_charges,
                'Conversion Rate Diff' => $invoice->conversion_rate_diff,
                'Conversion Rate' => $invoice->conversion_rate,
                'TDS' => number_format((float) $invoice->tds, 2),
                'Sent at' => $invoice->sent_on->format(config('invoice.default-date-format')),
                'Payment at' => $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-',
                'Status' => Str::studly($invoice->status)
            ];
        });
    }

    public function getInvoiceNumber($client_id, $project_id, $sent_date)
    {
        $country_id = ClientAddress::where('client_id', $client_id)->first()->country_id;
        $client_project_id = Project::find($project_id)->client_project_id;
        $client_type = ($country_id == 1) ? 'IN' : 'EX';
        $invoice_sequence = Invoice::where([['client_id', $client_id], ['project_id', $project_id]])->count() + 1;
        $invoice_number = $client_type . sprintf('%03s', $client_id) . $client_project_id . sprintf('%06s', $invoice_sequence) . date('m', strtotime($sent_date)) . date('y', strtotime($sent_date));

        return $invoice_number;
    }
}
