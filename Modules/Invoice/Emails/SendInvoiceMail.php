<?php

namespace Modules\Invoice\Emails;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Entities\Client;
use Modules\Invoice\Entities\Invoice;

class SendInvoiceMail extends Mailable
{
    use SerializesModels, Queueable;

    public $client;
    public $month;
    public $year;
    public $monthName;
    public $invoiceNumber;
    public $email;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, Invoice $invoice, int $month, int $year, string $invoiceNumber, array $email)
    {
        $this->client = $client;
        $this->month = $month;
        $this->year = $year;
        $this->monthName = date('F', mktime(0, 0, 0, $month, 10));
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

        if (! $subject) {
            $subject = Setting::where('module', 'invoice')->where('setting_key', 'send_invoice_subject')->first();
            $subject = $subject ? $subject->setting_value : '';
            $subject = str_replace(config('invoice.template-variables.subject.project-name'), $this->client->name . ' Projects', $subject);
            $subject = str_replace(config('invoice.template-variables.subject.term'), $this->monthName, $subject);
            $subject = str_replace(config('invoice.template-variables.subject.year'), $this->year, $subject);
        }

        if (! $body) {
            $body = Setting::where('module', 'invoice')->where('setting_key', 'send_invoice_body')->first();
            $body = $body ? $body->setting_value : '';
            $body = str_replace(config('invoice.template-variables.body.billing-person-name'), optional($this->client->billing_contact)->name, $body);
            $body = str_replace(
                config('invoice.template-variables.body.invoice-amount'),
                $this->client->country->currency_symbol . $this->client->getTotalPayableAmountForTerm($this->month, $this->year, $this->client->clientLevelBillingProjects),
                $body
            );
            $body = str_replace(
                config('invoice.template-variables.body.invoice-number'),
                str_replace('-', '', $this->invoiceNumber),
                $body
            );
            $body = str_replace(
                config('invoice.template-variables.body.term'),
                $this->monthName,
                $body
            );
            $body = str_replace(
                config('invoice.template-variables.body.year'),
                $this->year,
                $body
            );
        }

        $invoiceFile = Storage::path($this->invoice->file_path);

        $mail = $this->to($this->email['to'], $this->email['to_name'])
            ->from($this->email['from'], $this->email['from_name']);

        foreach ($this->email['cc'] as $emailAddress) {
            $mail->cc($emailAddress);
        }

        return $mail->subject($subject)
            ->attach($invoiceFile, [
                'mime' => 'application/pdf',
            ])->view('mail.plain')->with([
                'body' => $body,
            ]);
    }
}
