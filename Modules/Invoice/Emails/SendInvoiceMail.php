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
