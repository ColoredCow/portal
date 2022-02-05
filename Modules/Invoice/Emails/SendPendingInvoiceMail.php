<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPendingInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        ->subject('Mail of pending invoices.')
        ->view('invoice::mail.pending-invoice')
        ->with([
            'name' => 'Pending envoice',
        ]);
    }
}
