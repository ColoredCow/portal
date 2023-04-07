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
use Modules\Invoice\Emails\SendPendingInvoiceMail;
use Illuminate\Support\Facades\App;
use Mail;
use App\Models\Setting;
use Carbon\Carbon;
use Modules\Invoice\Emails\SendPaymentReceivedMail;
use Modules\Project\Entities\Project;
use Modules\Invoice\Exports\YearlyInvoiceReportExport;
use Modules\Invoice\Entities\LedgerAccount;
use Illuminate\Support\Facades\Notification;
use Modules\Invoice\Notifications\GoogleChat\SendPaymentReceivedNotification;

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
            $invoices = Invoice::query()->applyFilters($filters)->leftjoin('clients', 'invoices.client_id', '=', 'clients.id')
                ->select('invoices.*', 'clients.name')
                ->orderBy('name', 'asc')->orderBy('sent_on', 'desc')
                ->get();
            $clientsReadyToSendInvoicesData = [];
            $projectsReadyToSendInvoicesData = [];
        } else {
            $invoices = [];
            $clientsReadyToSendInvoicesData = Client::status('active')->invoiceReadyToSend()->orderBy('name')->get();
            $projectsReadyToSendInvoicesData = Project::whereHas('meta', function ($query) {
                return $query->where([
                    'key' => 'billing_level',
                    'value' => config('project.meta_keys.billing_level.value.project.key')
                ]);
            })->status('active')->invoiceReadyToSend()->orderBy('name')->get();
        }

        return [
            'invoices' => $invoices,
            'clients' => $this->getClientsForInvoice(),
            'currencyService' => $this->currencyService(),
            'totalReceivableAmount' => $this->getTotalReceivableAmountInINR($invoices),
            'filters' => $filters,
            'invoiceStatus' => $invoiceStatus,
            'clientsReadyToSendInvoicesData' => $clientsReadyToSendInvoicesData,
            'projectsReadyToSendInvoicesData' => $projectsReadyToSendInvoicesData,
            'sendInvoiceEmailSubject' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.send-invoice.subject')
            ])->first())->setting_value,
            'sendInvoiceEmailBody' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.send-invoice.body')
            ])->first())->setting_value,
            'invoiceReminderEmailSubject' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.invoice-reminder.subject')
            ])->first())->setting_value,
            'invoiceReminderEmailBody' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.invoice-reminder.body')
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
            'year' => null,
            'month' => null,
            'status' => 'sent',
            'client_id' => '',
        ];
    }

    public function create()
    {
        return [
            'clients' => $this->getClientsForInvoice(),
            'countries' => Country::all(),
            'sendInvoiceEmailSubject' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.send-invoice.subject')
            ])->first())->setting_value,
            'sendInvoiceEmailBody' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.send-invoice.body')
            ])->first())->setting_value,
            'invoiceReminderEmailSubject' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.invoice-reminder.subject')
            ])->first())->setting_value,
            'invoiceReminderEmailBody' => optional(Setting::where([
                'module' => 'invoice',
                'setting_key' => config('invoice.templates.setting-key.invoice-reminder.body')
            ])->first())->setting_value,
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

    public function update($data, $invoice)
    {
        $invoice->update($data);
        if (isset($data['send_mail'])) {
            $emailData = $this->getSendEmailData($data, $invoice);
            Mail::queue(new SendPaymentReceivedMail($invoice, $emailData));
            $webHookUrl = $invoice->project->google_chat_webhook_url
                ?? $invoice->client->google_chat_webhook_url;
            if ($webHookUrl) {
                $projectAndClientName = (optional($invoice->project)->name ?? $invoice->client->name);
                Notification::route('googleChat', $webHookUrl)
                    ->notify(new SendPaymentReceivedNotification($projectAndClientName));
            }
            $invoice->update([
                'payment_confirmation_mail_sent' => true
            ]);
        }
        if (isset($data['invoice_file']) and $data['invoice_file']) {
            $this->saveInvoiceFile($invoice, $data['invoice_file']);
            $this->setInvoiceNumber($invoice, $data['sent_on']);
        }

        return $invoice;
    }

    public function edit($invoice)
    {
        $emailData = $this->getPaymentReceivedEmailForInvoice($invoice);

        return [
            'invoice' => $invoice,
            'clients' => $this->getClientsForInvoice(),
            'countries' => Country::all(),
            'paymentReceivedEmailSubject' => $emailData['subject'],
            'paymentReceivedEmailBody' => $emailData['body'],
            'currencyService' => $this->currencyService(),
        ];
    }

    public function getPaymentReceivedEmailForInvoice(Invoice $invoice)
    {
        $templateVariablesForSubject = config('invoice.templates.setting-key.received-invoice-payment.template-variables.subject');
        $templateVariablesForBody = config('invoice.templates.setting-key.received-invoice-payment.template-variables.body');
        $year = $invoice->client->billingDetails->billing_date == 1 ? $invoice->sent_on->subMonth()->year : $invoice->sent_on->year;
        $subjectData = [
            $templateVariablesForSubject['project-name'] => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
            $templateVariablesForSubject['term'] => $invoice->term,
            $templateVariablesForSubject['year'] => $year
        ];

        $subject = optional(Setting::where('module', 'invoice')->where('setting_key', 'received_invoice_payment_subject')->first())->setting_value ?: '';

        foreach ($subjectData as $key => $value) {
            $subject = str_replace($key, $value, $subject);
        }

        $body = optional(Setting::where('module', 'invoice')->where('setting_key', 'received_invoice_payment_body')->first())->setting_value ?: '';
        $body = str_replace($templateVariablesForBody['billing-person-name'], optional($invoice->client->billing_contact)->first_name, $body);
        $body = str_replace($templateVariablesForBody['invoice-number'], $invoice->invoice_number, $body);

        if ($invoice->client->country->initials == 'IN') {
            $body = str_replace($templateVariablesForBody['amount'], $templateVariablesForBody['amount_paid'], $body);
        } else {
            $body = str_replace($templateVariablesForBody['amount'], (string) $invoice->amount, $body);
        }

        $body = str_replace($templateVariablesForBody['currency'], optional($invoice->client->country)->currency_symbol, $body);

        return [
            'subject' => $subject,
            'body' => $body
        ];
    }

    public function delete(Invoice $invoice)
    {
        return $invoice->delete();
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
        return Invoice::with('client')->all();
    }

    private function setInvoiceNumber($invoice, $sent_date)
    {
        $invoice->invoice_number = $this->getInvoiceNumber($invoice->client_id, $invoice->project_id, $sent_date, $invoice->billing_level);

        return $invoice->save();
    }

    public function getInvoicesBetweenDates($startDate, $endDate, $type = 'indian')
    {
        return Invoice::sentBetween($startDate, $endDate)
            ->region($type)
            ->status(['sent', 'paid'])
            ->get();
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
            'invoices' => $this->taxReportInvoices($filters),
            'clients' => Client::orderBy('name', 'asc')->get()
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
            ->orderBy('sent_on', 'desc');

        $igst = [];
        $cgst = [];
        $sgst = [];
        $clients = [];
        $clientAddress = [];
        foreach ($invoices->get() as $invoice) {
            $clients[] = Client::select('*')->where('id', $invoice->client_id)->first();
            $clientAddress[] = ClientAddress::select('*')->where('client_id', $invoice->client_id)->first();
            $igst[] = ((int) $invoice->display_amount * (int) config('invoice.invoice-details.igst')) / 100;
            $cgst[] = ((int) $invoice->display_amount * (int) config('invoice.invoice-details.cgst')) / 100;
            $sgst[] = ((int) $invoice->display_amount * (int) config('invoice.invoice-details.sgst')) / 100;
        }

        return [
            'invoices' => $invoices->paginate(config('constants.pagination_size')),
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
        return Invoice::query()
            ->applyFilters($filters)
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
        $countryId = optional(ClientAddress::where('client_id', $client ? $client->id : $project->client->id)->first())->country_id;
        $clientType = ($countryId == 1) ? 'IN' : 'EX';
        $lastInvoice = Invoice::where([['client_id', $client ? $client->id : $project->client->id], ['project_id', optional($project)->id]])->orderBy('sent_on', 'DESC')->first();
        $invoiceSequence = $lastInvoice ? (int) Str::substr($lastInvoice->invoice_number, 8, 6) + 1 : '000001';
        $invoiceNumber = $clientType . sprintf('%03s', $client ? $client->client_id : $project->client->client_id) . ($billingLevel == 'client' ? '000' : $project->client_project_id) . sprintf('%06s', $invoiceSequence) . date('m', strtotime($sentDate)) . date('y', strtotime($sentDate));

        return $invoiceNumber;
    }

    public function getInvoiceData(array $data)
    {
        $projectId = $data['project_id'] ?? null;
        $clientId = $data['client_id'] ?? null;
        $client = Client::find($clientId);
        $project = Project::find($projectId);
        $year = (int) substr($data['term'], 0, 4);
        $monthNumber = (int) substr($data['term'], 5, 2);
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 10));
        $billingLevel = $client ? 'client' : 'project';
        $projects = $billingLevel == 'client' ? $client->clientLevelBillingProjects : collect([$project]);
        $projectForInvoiceNumber = $billingLevel == 'project' ? $project : null;
        $invoiceNumber = $this->getInvoiceNumberPreview($client, $projectForInvoiceNumber, $data['sent_on'], $billingLevel);
        $billingStartMonth = $client ? $client->getMonthStartDateAttribute(1)->format('M') : $project->client->getMonthStartDateAttribute(1)->format('M');
        $billingStartMonthYear = $client ? $client->getMonthStartDateAttribute(1)->format('Y') : $project->client->getMonthStartDateAttribute(1)->format('Y');
        if ($data['period_start_date'] ?? false) {
            $billingStartMonth = Carbon::parse($data['period_start_date'])->format('M');
        }

        $billingEndMonth = $client ? $client->getMonthEndDateAttribute(1)->format('M') : $project->client->getMonthEndDateAttribute(1)->format('M');
        $billingEndMonthYear = $client ? $client->getMonthEndDateAttribute(1)->format('Y') : $project->client->getMonthEndDateAttribute(1)->format('Y');
        if ($data['period_end_date'] ?? false) {
            $billingEndMonth = Carbon::parse($data['period_end_date'])->format('M');
        }

        $termText = $billingStartMonth . ' ' . $billingStartMonthYear . ' - ' . $billingEndMonth . ' ' . $billingEndMonthYear;

        if ($billingStartMonth == $billingEndMonth) {
            $termText = $monthName;
        }

        return [
            'client' => $client ?: $project->client,
            'project' => $project,
            'projects' => $projects,
            'keyAccountManager' => $client ? $client->keyAccountManager()->first() : $project->client->keyAccountManager()->first(),
            'invoiceNumber' => $invoiceNumber,
            'invoiceData' => $data,
            'billingLevel' => $billingLevel,
            'monthName' => $monthName,
            'year' => $year,
            'monthNumber' => $monthNumber,
            'currencyService' => $this->currencyService(),
            'monthsToSubtract' => 1,
            'termText' => $termText,
            'periodStartDate' => $data['period_start_date'] ?? null,
            'periodEndDate' => $data['period_end_date'] ?? null
        ];
    }

    public function sendInvoice(array $data)
    {
        $term = $data['term'] ?? null;
        $client = Client::find($data['client_id'] ?? null);
        $project = Project::find($data['project_id'] ?? null);
        $ccEmails = $data['cc'] ?? [];
        $bccEmails = $data['bcc'] ?? [];
        $periodStartDate = $data['period_start_date'] ?? null;
        $periodEndDate = $data['period_end_date'] ?? null;

        if (! empty($ccEmails)) {
            $ccEmails = array_map('trim', explode(',', $data['cc']));
            foreach ($ccEmails as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($ccEmails[$index]);
            }
        }

        if (! empty($bccEmails)) {
            $bccEmails = array_map('trim', explode(',', $data['bcc']));
            foreach ($bccEmails as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($bccEmails[$index]);
            }
        }

        $email = [
            'to' => $data['to'] ?? ($client ? optional($client->billing_contact)->email : optional($project->client->billing_contact)->email),
            'to_name' => $data['to_name'] ?? ($client ? optional($client->billing_contact)->name : optional($project->client->billing_contact)->name),
            'from' => $data['from'] ?? config('invoice.mail.send-invoice.email'),
            'from_name' => config('invoice.mail.send-invoice.email'),
            'cc' => $ccEmails,
            'bcc' => $bccEmails,
            'body' => $data['email_body'] ?? null,
            'subject' => $data['email_subject'] ?? null
        ];
        $invoiceNumber = optional($client)->next_invoice_number ?: $project->next_invoice_number;
        $invoice = $this->createInvoice($client, $project, $term, $periodStartDate, $periodEndDate);
        Mail::queue(new SendInvoiceMail($invoice, $invoiceNumber, $email));
    }

    public function sendInvoiceReminder(Invoice $invoice, $data)
    {
        $ccEmails = $data['cc'] ?? [];
        $bccEmails = $data['bcc'] ?? [];

        if (! empty($ccEmails)) {
            $ccEmails = array_map('trim', explode(',', $data['cc']));
            foreach ($ccEmails as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($ccEmails[$index]);
            }
        }

        if (! empty($bccEmails)) {
            $bccEmails = array_map('trim', explode(',', $data['bcc']));
            foreach ($bccEmails as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($bccEmails[$index]);
            }
        }

        $email = [
            'to' => $data['to'] ?? optional($invoice->client->billing_contact)->email,
            'to_name' => $data['to_name'] ?? optional($invoice->client->billing_contact)->first_name,
            'from' => $data['from'] ?? config('invoice.mail.send-invoice.email'),
            'from_name' => config('invoice.mail.send-invoice.email'),
            'cc' => $ccEmails,
            'bcc' => $bccEmails,
            'body' => $data['email_body'] ?? null,
            'subject' => $data['email_subject'] ?? null
        ];
        Mail::queue(new SendPendingInvoiceMail($invoice, $email));
        $invoice->update([
            'reminder_mail_count' => ($invoice->reminder_mail_count + 1)
        ]);
    }

    public function sendPaymentReceivedMail(Invoice $invoice, $data)
    {
        $emailData = $this->getSendEmailData($data, $invoice);
        Mail::queue(new SendPaymentReceivedMail($invoice, $emailData));
        $invoice->update([
            'payment_confirmation_mail_sent' => true
        ]);
    }

    public function getSendEmailData(array $data, $invoice)
    {
        $ccEmails = $data['cc'] ?? [];
        $bccEmails = $data['bcc'] ?? [];

        if (! empty($ccEmails)) {
            $ccEmails = array_map('trim', explode(',', $data['cc']));
            foreach ($ccEmails as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($ccEmails[$index]);
            }
        }

        if (! empty($bccEmails)) {
            $bccEmails = array_map('trim', explode(',', $data['bcc']));
            foreach ($bccEmails as $index => $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                unset($bccEmails[$index]);
            }
        }

        return [
            'to' => $data['to'] ?? optional($invoice->client->billing_contact)->email,
            'to_name' => $data['to_name'] ?? optional($invoice->client->billing_contact)->first_name,
            'from' => $data['from'] ?? config('invoice.mail.send-invoice.email'),
            'from_name' => config('invoice.mail.send-invoice.email'),
            'cc' => $ccEmails,
            'bcc' => $bccEmails,
            'body' => $data['email_body'] ?? null,
            'subject' => $data['email_subject'] ?? null
        ];
    }

    public function createInvoice($client, $project, $term, $periodStartDate, $periodEndDate)
    {
        $term = $term ?? today(config('constants.timezone.indian'))->subMonth()->format('Y-m');
        $sentOn = today(config('constants.timezone.indian'));
        $dueOn = today(config('constants.timezone.indian'))->addDays(6);
        $monthsToSubtract = 1;
        $data = $this->getInvoiceData([
            'client_id' => optional($client)->id,
            'project_id' => optional($project)->id,
            'term' => $term,
            'billing_level' => $client ? 'client' : 'project',
            'sent_on' => $sentOn,
            'due_on' => $dueOn,
            'period_start_date' => $periodStartDate,
            'period_end_date' => $periodEndDate
        ]);
        $invoiceNumber = $data['invoiceNumber'];
        $data['invoiceNumber'] = $data['invoiceNumber'];
        $pdf = App::make('snappy.pdf.wrapper');
        $template = config('invoice.templates.invoice.clients.' . optional($data['client'])->name) ?: 'invoice-template';
        $html = view(('invoice::render.' . $template), $data)->render();
        $data['receivable_date'] = $dueOn;
        $data['project_id'] = null;
        $gst = null;

        if ($project) {
            if (optional($project->client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug')) {
                $amount = $project->getResourceBillableAmount() + $project->getTotalLedgerAmount();
            } else {
                $amount = $project->getBillableAmountForTerm($monthsToSubtract, $periodStartDate, $periodEndDate) + optional($project->client->billingDetails)->bank_charges;
                $gst = $project->getTaxAmountForTerm($monthsToSubtract, $periodStartDate, $periodEndDate);
            }
        } else {
            if (optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug')) {
                $amount = $client->getResourceBasedTotalAmount() + $client->getClientProjectsTotalLedgerAmount();
            } else {
                $amount = $client->getBillableAmountForTerm($monthsToSubtract, $client->clientLevelBillingProjects, $periodStartDate, $periodEndDate) + optional($client->billingDetails)->bank_charges;
                $gst = $client->getTaxAmountForTerm($monthsToSubtract, $client->clientLevelBillingProjects, $periodStartDate, $periodEndDate);
            }
        }

        $invoice = Invoice::create([
            'project_id' => optional($project)->id,
            'client_id' => optional($client)->id ?: $project->client->id,
            'billing_level' => $client ? 'client' : 'project',
            'status' => 'sent',
            'sent_on' =>  $sentOn,
            'due_on' => $dueOn,
            'receivable_date' => $dueOn,
            'currency' => $client ? $client->country->currency : $project->client->country->currency,
            'amount' => $amount,
            'gst' => $gst,
            'term_start_date' => $periodStartDate,
            'term_end_date' => $periodEndDate
        ]);

        $filePath = $this->getInvoiceFilePath($invoice) . '/' . $invoiceNumber . '.pdf';
        $pdf->generateFromHtml($html, storage_path('app' . $filePath), [], true);
        $invoice->update([
            'invoice_number' => $invoiceNumber,
            'file_path' => $filePath
        ]);

        return $invoice;
    }

    public function yearlyInvoiceReport($filters, $request)
    {
        $filters = $request->all();
        $filters = [
            'client_id' => $filters['client_id'] ?? null,
            'invoiceYear' => $filters['invoiceYear'] ?? today()->year,
        ];

        if ($filters['invoiceYear'] == 'all-years') {
            $filters['invoiceYear'] = null;
        }

        $invoices = Invoice::query()->applyFilters($filters)
            ->orderBy('sent_on', 'desc')
            ->get();
        $clients = Client::orderBy('name', 'asc')->get();
        $clientId = request()->client_id;
        $clientCurrency = $this->clientCurrency($clientId);

        return [
            'invoices' => $invoices,
            'clients' => $clients,
            'clientCurrency' => $clientCurrency,
        ];
    }
    public function yearlyInvoiceReportExport($filters, $request)
    {
        $filters = $request->all();
        $filters = [
            'client_id' => $filters['client_id'] ?? null,
            'invoiceYear' => $filters['invoiceYear'] ?? today()->year,
        ];
        if ($filters['invoiceYear'] == 'all-years') {
            $filters['invoiceYear'] = null;
        }

        $invoices = Invoice::query()->applyFilters($filters)
            ->orderBy('sent_on', 'desc')
            ->get();

        if (isset($filters['client_id'])) {
            $clientId = request()->client_id;
            $clientCurrency = $this->clientCurrency($clientId);
            $invoices = $clientCurrency == config('invoice.region.indian') ? $this->formatYearlyInvoicesReportForIndianClientExport($invoices) : $this->formatYearlyInvoicesReportForInternationalClientExport($invoices);
        } else {
            $invoices = $this->formatYearlyInvoicesForExportAll($invoices);
        }

        if ($request->client_id == 'all' || $request->client_id == null) {
            return Excel::download(new YearlyInvoiceReportExport($invoices), "YearlyInvoiceReportExport-$request->client_id-$request->invoiceYear.xlsx");
        }
        $clientId = request()->client_id;
        $clientName = Client::where('id', $clientId)->first()->name;

        return Excel::download(new YearlyInvoiceReportExport($invoices), "YearlyInvoiceReportExport-$clientName-$request->invoiceYear.xlsx");
    }
    private function formatYearlyInvoicesForExportAll($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project Name' => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
                'Invoice number' => $invoice->invoice_number,
                'Invoice Amount' => $invoice->amount,
                'GST Amount' => $invoice->gst,
                'Amount(+GST)' => $invoice->total_amount,
                'TDS' => number_format((float) $invoice->tds, 2),
                'Amount in INR' => $invoice->InvoiceAmountInInr,
                'Amount Recieved' => $invoice->amount_paid,
                'Bank Charges' => $invoice->bank_charges,
                'Dollar Rate' => $invoice->conversion_rate,
                'Exchange Rate Diff' => $invoice->conversion_rate_diff,
                'Amount Recieved in Dollars' => $invoice->amount_paid,
                'Sent at' => $invoice->sent_on->format(config('invoice.default-date-format')),
                'Payment at' => $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-',
                'Status' => $invoice->status
            ];
        });
    }

    private function formatYearlyInvoicesReportForIndianClientExport($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project Name' => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
                'Invoice number' => $invoice->invoice_number,
                'Invoice Amount' => $invoice->amount,
                'GST Amount' => $invoice->gst,
                'Amount(+GST)' => $invoice->total_amount,
                'TDS' => number_format((float) $invoice->tds, 2),
                'Amount Recieved' => $invoice->amount_paid,
                'Sent at' => $invoice->sent_on->format(config('invoice.default-date-format')),
                'Payment at' => $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-',
                'Status' => $invoice->status
            ];
        });
    }

    private function formatYearlyInvoicesReportForInternationalClientExport($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'Project Name' => optional($invoice->project)->name ?: ($invoice->client->name . ' Projects'),
                'Invoice number' => $invoice->invoice_number,
                'Invoice Amount' => $invoice->amount,
                'Amount in INR' => $invoice->InvoiceAmountInInr,
                'Amount Recieved' => $invoice->amount_paid,
                'Bank Charges' => $invoice->bank_charges,
                'Dollar Rate' => $invoice->conversion_rate,
                'Exchange Rate Diff' => $invoice->conversion_rate_diff,
                'Amount Recieved in Dollars' => $invoice->amount_paid,
                'Sent at' => $invoice->sent_on->format(config('invoice.default-date-format')),
                'Payment at' => $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-',
                'Status' => $invoice->status
            ];
        });
    }

    public function clientCurrency($clientId)
    {
        if ($clientId == null) {
            return;
        }

        return Client::find($clientId, 'id')->currency;
    }

    public function getLedgerAccountData(array $data)
    {
        $clients = Client::with('projects')->orderBy('name')->get();
        $client = Client::find($data['client_id'] ?? null);
        $project = Project::find($data['project_id'] ?? null);

        return [
            'clients' => $clients,
            'client' => $client,
            'project' => $project,
            'ledgerAccountData' => $project ? $project->ledgerAccounts->toArray() : ($client ? $client->ledgerAccounts->toArray() : [])
        ];
    }

    public function storeLedgerAccountData(array $data)
    {
        $project = Project::find($data['project_id'] ?? null);
        $client = Client::find($data['client_id'] ?? null);

        if (! $client) {
            return;
        }

        if ($project) {
            $ledgerAccountsIdToDelete = LedgerAccount::where('project_id', $project->id)->pluck('id')->toArray();
        } else {
            $ledgerAccountsIdToDelete = LedgerAccount::where('client_id', $client->id)->pluck('id')->toArray();
        }

        foreach ($data['ledger_account_data'] as $ledgerAccountData) {
            if ($ledgerAccountData['id'] == null) {
                LedgerAccount::create($ledgerAccountData);
                continue;
            }

            $ledgerAccount = LedgerAccount::find($ledgerAccountData['id']);
            $ledgerAccount->update($ledgerAccountData);
            $index = array_search($ledgerAccount->id, $ledgerAccountsIdToDelete);
            unset($ledgerAccountsIdToDelete[$index]);
        }

        LedgerAccount::destroy($ledgerAccountsIdToDelete);
    }
}
