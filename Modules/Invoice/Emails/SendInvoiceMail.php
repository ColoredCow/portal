<?php

namespace Modules\Invoice\Emails;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Modules\Invoice\Entities\Invoice;

class SendInvoiceMail extends Mailable
{
    use SerializesModels, Queueable;

    public $client;
    public $monthToSubtract;
    public $invoiceNumber;
    public $email;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, string $invoiceNumber, array $email)
    {
        $this->client = $invoice->client;
        $this->monthToSubtract = 1;
        $this->invoiceNumber = $invoiceNumber;
        $this->email = $email;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->email['subject'];
        $body = $this->email['body'];
        $templateVariablesForSubject = config('invoice.templates.setting-key.send-invoice.template-variables.subject');
        $templateVariablesForBody = config('invoice.templates.setting-key.send-invoice.template-variables.body');
        $billingStartMonth = $this->client->getMonthStartDateAttribute(1)->format('M');
        $billingEndMonth = $this->client->getClientMonthEndDateAttribute(1)->format('M');
        $year = $this->client->getClientMonthEndDateAttribute(1)->year;
        $monthName = $this->client->getClientMonthEndDateAttribute(1)->format('F');
        $termText = $billingStartMonth != $billingEndMonth ? $billingStartMonth . ' - ' . $billingEndMonth : $monthName;

        if (! $subject) {
            $subject = Setting::where('module', 'invoice')->where('setting_key', 'send_invoice_subject')->first();
            $subject = $subject ? $subject->setting_value : '';
            $subject = str_replace($templateVariablesForSubject['project-name'], $this->client->name . ' Projects', $subject);
            $subject = str_replace($templateVariablesForSubject['term'], $termText, $subject);
            $subject = str_replace($templateVariablesForSubject['year'], $year, $subject);
        }

        if (! $body) {
            $body = Setting::where('module', 'invoice')->where('setting_key', 'send_invoice_body')->first();
            $body = $body ? $body->setting_value : '';
            $body = str_replace($templateVariablesForBody['billing-person-name'], optional($this->client->billing_contact)->first_name, $body);
            $body = str_replace(
                $templateVariablesForBody['invoice-amount'],
                $this->client->country->currency_symbol . $this->client->getTotalPayableAmountForTerm($this->monthToSubtract, $this->client->clientLevelBillingProjects),
                $body
            );
            $body = str_replace($templateVariablesForBody['invoice-number'], $this->invoiceNumber, $body);
            $body = str_replace($templateVariablesForBody['term'], $monthName, $body);
            $body = str_replace($templateVariablesForBody['year'], $year, $body);
        }

        $invoiceFile = Storage::path($this->invoice->file_path);

        $mail = $this->to($this->email['to'], $this->email['to_name'])
            ->from($this->email['from'], $this->email['from_name']);

        foreach ($this->email['cc'] as $emailAddress) {
            $mail->cc($emailAddress);
        }

        foreach ($this->email['bcc'] as $emailAddress) {
            $mail->bcc($emailAddress);
        }

        return $mail->subject($subject)
            ->attach($invoiceFile, [
                'mime' => 'application/pdf',
            ])->view('mail.plain')->with([
                'body' => $body,
            ]);
    }
}
