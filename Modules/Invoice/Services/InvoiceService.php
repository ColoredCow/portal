<?php

namespace Modules\Invoice\Services;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Support\Facades\Storage;
use Modules\Invoice\Exports\TaxReportExport;
use Modules\Invoice\Exports\MonthlyGSTTaxReportExport;
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
            'filters' => $filters,
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

    public function getTotalReceivableAmountsInINR($invoice)
    {
        $totalAmount = 0;
        $currentRates = $this->currencyService()->getCurrentRatesInINR();

        if ($invoice->isAmountInINR()) {
            $totalAmount += (int) $invoice->amount;
        }

        $invoiceAmount = $currentRates * (int) $invoice->amount;
        $totalAmount += $invoiceAmount;

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
        return Invoice::status('sent')->with(['client', 'project'])->where('due_on', '>', Carbon::today())->get();

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

    public function getInvoiceFile($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        return Storage::download($invoice->file_path, basename($invoice->file_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getClientsForInvoice()
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

    public function defaultGstReportFilters()
    {
        return [
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
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

    public function invoiceDetails($filters)
    {
        $query = Invoice::query();

        $invoices = $this
            ->applyFilters($query, $filters)
            ->paginate(config('constants.pagination_size')) ?: [];

        $igst = [];
        $cgst = [];
        $sgst = [];
        $clients = [];
        $clientAddress = [];
        foreach ($invoices as $invoice) :
            $clients[] = Client::select('*')->where('id', $invoice->client_id)->first();
        $clientAddress[] = ClientAddress::select('*')->where('client_id', $invoice->client_id)->first();
        $igst[] = ((int) $invoice->display_amount * (int) config('invoice.invoice-details.igst')) / 100;
        $cgst[] = ((int) $invoice->display_amount * (int) config('invoice.invoice-details.cgst')) / 100;
        $sgst[] = ((int) $invoice->display_amount * (int) config('invoice.invoice-details.sgst')) / 100;
        endforeach;

        return [
            'invoices' => $invoices,
            'clients' => $clients,
            'clientAddress' => $clientAddress,
            // 'currentRates' => $this->currencyService()->getCurrentRatesInINR(),
            'igst' => $igst,
            'cgst' => $cgst,
            'sgst' => $sgst
        ];
    }

    public function monthlyGSTTaxReportExport($filters, $request)
    {
        $query = Invoice::query();

        $invoice = $this
            ->applyFilters($query, $filters)
            ->get() ?: [];

        $invoices = $invoice;
        $invoices = $this->formatMonthlyInvoicesForExportAll($invoices);

        return Excel::download(new MonthlyGSTTaxReportExport($invoices), "MonthlyGSTTaxReportExport-$request->month-$request->year.xlsx");
    }

    private function formatMonthlyInvoicesForExportAll($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Date' =>   $invoice->sent_on->format(config('invoice.default-date-format')),
                'Particular' => $invoice->client->name,
                'Type' => ClientAddress::select('*')->where('client_id', $invoice->client_id)->first() ? ((ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->country_id == 1) ? 'India' : 'Export') : '',
                'INVOICE NO.' => $invoice->invoice_number,
                'GST NO.' => ClientAddress::select('*')->where('client_id', $invoice->client_id)->first() ? ((ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->country_id == 1) ? (isset(ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->gst_number) ? ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->gst_number : 'B2C') : 'Export') : '',
                'INVOICE VALUE' => str_replace(['$', '₹', 'CAD', '€'], '', $invoice->invoiceAmount()),
                'RATE' => '',
                'RECEIVABLE AMOUNT' => ClientAddress::select('*')->where('client_id', $invoice->client_id)->first() ? str_replace(['$', '₹', 'CAD', '€'], '', $invoice->invoiceAmount()) : '',
                'TAXABLE AMOUNT' => str_replace(['$', '₹', 'CAD', '€'], '', $invoice->display_amount),
                'IGST' => ClientAddress::select('*')->where('client_id', $invoice->client_id)->first() ? ((ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->state != config('invoice.invoice-details.billing-state')) && (ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->country_id == 1) ? ((int) $invoice->display_amount * (int) config('invoice.invoice-details.igst')) / 100 : '0') : '',
                'CGST' => ClientAddress::select('*')->where('client_id', $invoice->client_id)->first() ? ((ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->state == config('invoice.invoice-details.billing-state')) && (ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->country_id == 1) ? ((int) $invoice->display_amount * (int) config('invoice.invoice-details.cgst')) / 100 : '0') : '',
                'SGST' => ClientAddress::select('*')->where('client_id', $invoice->client_id)->first() ? ((ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->state == config('invoice.invoice-details.billing-state')) && (ClientAddress::select('*')->where('client_id', $invoice->client_id)->first()->country_id == 1) ? ((int) $invoice->display_amount * (int) config('invoice.invoice-details.sgst')) / 100 : '0') : '',
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

    public function getInvoiceNumber($clientId, $projectId, $sentDate)
    {
        $client = Client::find($clientId);
        $countryId = optional(ClientAddress::where('client_id', $clientId)->first())->country_id;
        $clientType = ($countryId == 1) ? 'IN' : 'EX';
        $clientProjectId = Project::find($projectId)->client_project_id;
        $lastInvoice = optional(Invoice::where([['client_id', $clientId], ['project_id', $projectId]])->orderBy('id', 'DESC')->get())->offsetGet(1);
        $invoiceSequence = $lastInvoice ? (int) Str::substr($lastInvoice->invoice_number, 8, 6) + 1 : '000001';

        $invoiceNumber = $clientType . sprintf('%03s', $client->client_id) . $clientProjectId . sprintf('%06s', $invoiceSequence) . date('m', strtotime($sentDate)) . date('y', strtotime($sentDate));

        return $invoiceNumber;
    }

    public function getInvoiceNumberPreview($client, $project, $sentDate)
    {
        $countryId = optional(ClientAddress::where('client_id', $client->id)->first())->country_id;
        $clientType = ($countryId == 1) ? 'IN' : 'EX';
        $lastInvoice = Invoice::where([['client_id', $client->id], ['project_id', $project->id]])->orderBy('id', 'DESC')->first();
        $invoiceSequence = $lastInvoice ? (int) Str::substr($lastInvoice->invoice_number, 8, 6) + 1 : '000001';
        $invoiceNumber = $clientType . sprintf('%03s', $client->client_id) . '-' . $project->client_project_id . '-' . sprintf('%06s', $invoiceSequence) . date('m', strtotime($sentDate)) . date('y', strtotime($sentDate));

        return $invoiceNumber;
    }

    public function getInvoiceData(array $data)
    {
        // this is a incomplete code. Will complete it once the invoice generation functionality is ready.
        $client = Client::find($data['client_id']);
        $year = (int) substr($data['term'], 0, 4);
        $monthNumber = (int) substr($data['term'], 5, 2);
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10));
        $billingFor = $data['billing_for'] ?? null;
        $invoiceLevel = $billingFor == 'client_level' ? 'client' : 'project';
        $projects = $billingFor == 'client_level' ? $client->clientLevelBillingProjects : collect([Project::find($data['billing_for'])]);
        $projectForInvoiceNumber = $invoiceLevel == 'project' ? Project::find($data['billing_for']) : Client::find($data['client_id'])->primaryProject;
        $invoiceNumber = $this->getInvoiceNumberPreview($client, $projectForInvoiceNumber, $data['sent_on']);

        return [
            'client' => $client,
            'projects' => $projects,
            'keyAccountManager' => $client->keyAccountManager()->first(),
            'invoiceNumber' => $invoiceNumber,
            'invoiceData' => $data,
            'invoiceLevel' => $invoiceLevel,
            'monthName' => $monthName,
            'year' => $year,
            'monthNumber' => $monthNumber,
            'currencyService' => $this->currencyService(),
        ];
    }
}
