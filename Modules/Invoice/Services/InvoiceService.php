<?php

namespace Modules\Invoice\Services;

use App\Models\Country;
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
use Modules\Invoice\Emails\SendInvoiceMail;
use Illuminate\Support\Facades\App;
use Mail;
use App\Models\Setting;
use Modules\Project\Entities\Project;
use Modules\Invoice\Exports\InvoiceReportExport;

class InvoiceService implements InvoiceServiceContract
{
    public function index($filters = [], $invoiceStatus = 'sent')
    {
        $filters = [
            'client_id' => $filters['client_id'] ?? null,
            'month' => $filters['month'] ?? null,
            'year' => $filters['year'] ?? null,
            'status' => $filters['status'] ?? null,
        ];

        if ($invoiceStatus == 'sent') {
            $invoices = Invoice::query()->applyFilters($filters)
                ->orderBy('sent_on', 'desc')
                ->get();
            $clientsReadyToSendInvoicesData = [];
        } else {
            $invoices = [];
            $clientsReadyToSendInvoicesData = Client::status('active')->invoiceReadyToSend()->orderBy('name')->get();
        }

        return [
            'invoices' => $invoices,
            'clients' => $this->getClientsForInvoice(),
            'currencyService' => $this->currencyService(),
            'totalReceivableAmount' => $this->getTotalReceivableAmountInINR($invoices),
            'filters' => $filters,
            'invoiceStatus' => $invoiceStatus,
            'clientsReadyToSendInvoicesData' => $clientsReadyToSendInvoicesData,
            'emailSubject' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.send-invoice.subject')
            ])->first())->setting_value,
            'emailBody' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.send-invoice.body')
            ])->first())->setting_value,
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
            'client_id' => '',
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
        if ($data['billing_level'] == config('project.meta_keys.billing_level.value.client.key')) {
            $data['project_id'] = null;
        }
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
        return Invoice::status('sent')->with(['client', 'project'])->get();
    }

    public function saveInvoiceFile($invoice, $file, $fileName = null)
    {
        $folder = $this->getInvoiceFilePath($invoice);

        if (! $fileName) {
            $fileName = $file->getClientOriginalName();
        }
        $file = Storage::putFileAs($folder, $file, $fileName, ['visibility' => 'public']);
        $invoice->update(['file_path' => $file]);
    }

    public function getInvoiceFilePath(Invoice $invoice)
    {
        $year = $invoice->sent_on->format('Y');
        $month = $invoice->sent_on->format('m');

        return '/invoice/' . $year . '/' . $month;
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
        $invoice->invoice_number = $this->getInvoiceNumber($invoice->client_id, $invoice->project_id, $sent_date, $invoice->billing_level);

        return $invoice->save();
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

    public function taxReportExport($filters, $request)
    {
        $invoices = $this->taxReportInvoices($filters);
        if (isset($filters['region'])) {
            $invoices = $filters['region'] == config('invoice.region.indian') ? $this->formatInvoicesForExportIndian($invoices) : $this->formatInvoicesForExportInternational($invoices);
        } else {
            $invoices = $this->formatInvoicesForExportAll($invoices);
        }

        return Excel::download(new TaxReportExport($invoices), "TaxReportExport-$request->month-$request->year.xlsx");
    }

    public function invoiceDetails($filters)
    {
        $invoices = Invoice::query()->applyFilters($filters)
            ->orderBy('sent_on', 'desc')
            ->get();

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
        $invoices = Invoice::query()->applyFilters($filters)
            ->orderBy('sent_on', 'desc')
            ->get();

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
        return Invoice::query()->applyFilters($filters)
            ->orderBy('sent_on', 'desc')
            ->get();
    }

    private function formatInvoicesForExportIndian($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project' => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
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
                'Project' => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
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
                'Project' => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
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

    public function getInvoiceNumber($clientId, $projectId, $sentDate, $billingLevel)
    {
        $client = Client::find($clientId);
        $countryId = optional(ClientAddress::where('client_id', $clientId)->first())->country_id;
        $clientType = ($countryId == 1) ? 'IN' : 'EX';
        $clientProjectId = optional(Project::find($projectId))->client_project_id;
        $lastInvoice = optional(Invoice::where([['client_id', $clientId], ['project_id', $projectId]])->orderBy('sent_on', 'DESC')->get())->offsetGet(1);
        $invoiceSequence = $lastInvoice ? (int) Str::substr($lastInvoice->invoice_number, 8, 6) + 1 : '000001';

        $invoiceNumber = $clientType . sprintf('%03s', $client->client_id) . ($billingLevel == 'client' ? '000' : $clientProjectId) . sprintf('%06s', $invoiceSequence) . date('m', strtotime($sentDate)) . date('y', strtotime($sentDate));

        return $invoiceNumber;
    }

    public function getInvoiceNumberPreview($client, $project, $sentDate, $billingLevel)
    {
        $countryId = optional(ClientAddress::where('client_id', $client->id)->first())->country_id;
        $clientType = ($countryId == 1) ? 'IN' : 'EX';
        $lastInvoice = Invoice::where([['client_id', $client->id], ['project_id', optional($project)->id]])->orderBy('sent_on', 'DESC')->first();
        $invoiceSequence = $lastInvoice ? (int) Str::substr($lastInvoice->invoice_number, 8, 6) + 1 : '000001';
        $invoiceNumber = $clientType . sprintf('%03s', $client->client_id) . '-' . ($billingLevel == 'client' ? '000' : $project->client_project_id) . '-' . sprintf('%06s', $invoiceSequence) . '-' . date('m', strtotime($sentDate)) . date('y', strtotime($sentDate));

        return $invoiceNumber;
    }

    public function getInvoiceData(array $data)
    {
        $client = Client::find($data['client_id']);
        $year = (int) substr($data['term'], 0, 4);
        $monthNumber = (int) substr($data['term'], 5, 2);
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10));
        $billingLevel = $data['billing_level'] ?? null;
        $projects = $billingLevel == 'client' ? $client->clientLevelBillingProjects : collect([Project::find($data['project_id'])]);
        $projectForInvoiceNumber = $billingLevel == 'project' ? Project::find($data['project_id']) : null;
        $invoiceNumber = $this->getInvoiceNumberPreview($client, $projectForInvoiceNumber, $data['sent_on'], $billingLevel);

        return [
            'client' => $client,
            'projects' => $projects,
            'keyAccountManager' => $client->keyAccountManager()->first(),
            'invoiceNumber' => $invoiceNumber,
            'invoiceData' => $data,
            'billingLevel' => $billingLevel,
            'monthName' => $monthName,
            'year' => $year,
            'monthNumber' => $monthNumber,
            'currencyService' => $this->currencyService(),
        ];
    }

    public function sendInvoice(Client $client, $term, $data)
    {
        $cc = $data['cc'] ?? [];

        if (! empty($cc)) {
            $cc = array_map('trim', explode(',', $data['cc']));
            foreach ($cc as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($cc[$index]);
            }
        }

        $email = [
            'to' => $data['to'] ?? optional($client->billing_contact)->email,
            'to_name' => $data['to_name'] ?? optional($client->billing_contact)->name,
            'from' => $data['from'] ?? config('invoice.mail.send-invoice.email'),
            'from_name' => config('invoice.mail.send-invoice.email'),
            'cc' => $cc,
            'body' => $data['email_body'] ?? null,
            'subject' => $data['email_subject'] ?? null
        ];
        $year = (int) substr($term, 0, 4);
        $monthNumber = (int) substr($term, 5, 2);
        $invoiceNumber = str_replace('-', '', $client->next_invoice_number);
        $invoice = $this->generateInvoiceForClient($client, $monthNumber, $year, $term);
        Mail::queue(new SendInvoiceMail($client, $invoice, $monthNumber, $year, $invoiceNumber, $email));
    }

    public function generateInvoiceForClient(Client $client, $monthNumber, $year, $term)
    {
        $term = $term ?? today(config('constants.timezone.indian'))->subMonth()->format('Y-m');
        $sentOn = today(config('constants.timezone.indian'));
        $dueOn = today(config('constants.timezone.indian'))->addWeek();

        $data = $this->getInvoiceData([
            'client_id' => $client->id,
            'term' => $term,
            'billing_level' => 'client',
            'sent_on' => $sentOn,
            'due_on' => $dueOn
        ]);

        $invoiceNumber = str_replace('-', '', $data['invoiceNumber']);
        $pdf = App::make('snappy.pdf.wrapper');
        $html = view('invoice::render.render', $data)->render();
        $data['receivable_date'] = $dueOn;
        $data['project_id'] = null;
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'billing_level' => 'client',
            'status' => 'sent',
            'sent_on' =>  $sentOn,
            'due_on' => $dueOn,
            'receivable_date' => $dueOn,
            'currency' => $client->country->currency,
            'amount' => $client->getBillableAmountForTerm($monthNumber, $year, $client->clientLevelBillingProjects)
        ]);

        $filePath = $this->getInvoiceFilePath($invoice) . '/' . $invoiceNumber . '.pdf';
        $pdf->generateFromHtml($html, storage_path('app' . $filePath), [], true);
        $invoice->update([
            'invoice_number' => $invoiceNumber,
            'file_path' => $filePath
        ]);

        return $invoice;
    }

    public function invoiceReport($filters, $request)
    {
        $filters = $request->all();
        $filters = [
            'client_id' => $filters['client_id'] ?? null,
            'invoiceYear' => $filters['invoiceYear'] ?? null,
        ];
        $invoices = Invoice::query()->applyFilters($filters)
            ->orderBy('sent_on', 'desc')
            ->get();
        $clients = Client::all();

        return [
            'invoices' => $invoices,
            'clients' => $clients,
        ];
    }
}
