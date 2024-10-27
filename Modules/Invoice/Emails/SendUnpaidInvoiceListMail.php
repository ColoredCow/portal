<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUnpaidInvoiceListMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $unpaidInvoices;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $unpaidInvoices)
    {
        $this->unpaidInvoices = $unpaidInvoices;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->to(config('invoice.mail.unpaid-invoice.email'), config('invoice.mail.unpaid-invoice.name'))
        ->subject('List of unpaid invoices.')
        ->view('invoice::mail.unpaid-invoice-list')
        ->with(['unpaidInvoices' => $this->unpaidInvoices]);
    }
}
