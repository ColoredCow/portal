<?php

namespace Modules\Invoice\Emails;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Invoice\Entities\Invoice;

class SendPendingInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $month;
    public $year;
    public $monthName;
    public $email;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, array $email)
    {
        $this->month = $invoice->sent_on->subMonth()->month;
        $this->year = $invoice->sent_on->subMonth()->year;
        $this->monthName = date('F', mktime(0, 0, 0, $this->month, 10));
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
        $templateVariablesForSubject = config('invoice.templates.setting-key.invoice-reminder.template-variables.subject');
        $templateVariablesForBody = config('invoice.templates.setting-key.invoice-reminder.template-variables.body');

        if (! $subject) {
            $subject = Setting::where('module', 'invoice')->where('setting_key', 'invoice_reminder_subject')->first();
            $subject = $subject ? $subject->setting_value : '';
            $subject = str_replace($templateVariablesForSubject['project-name'], optional($this->invoice->project)->name ?: ($this->invoice->client->name . ' Projects'), $subject);
            $subject = str_replace($templateVariablesForSubject['term'], $this->monthName, $subject);
            $subject = str_replace($templateVariablesForSubject['year'], $this->year, $subject);
        }

        if (! $body) {
            $body = Setting::where('module', 'invoice')->where('setting_key', 'invoice_reminder_body')->first();
            $body = $body ? $body->setting_value : '';
            $body = str_replace($templateVariablesForBody['billing-person-name'], optional($this->client->billing_contact)->name, $body);
        }

        $mail = $this->to($this->email['to'], $this->email['to_name'])
            ->from($this->email['from'], $this->email['from_name']);

        foreach ($this->email['cc'] as $emailAddress) {
            $mail->cc($emailAddress);
        }

        foreach ($this->email['bcc'] as $emailAddress) {
            $mail->bcc($emailAddress);
        }

        return $mail->subject($subject)
            ->view('mail.plain')->with([
                'body' => $body,
            ]);
    }
}
