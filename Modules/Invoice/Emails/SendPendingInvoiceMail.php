<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPendingInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->to(config('invoice.pending-invoice-mail.pending-invoice.email'), config('invoice.pending-invoice-mail.pending-invoice.name'))
        ->subject($this->invoice->project->name . ' invoice ')
        ->view('invoice::mail.pending-invoice')
        ->with(['invoice' => $this->invoice]);
    }
}
