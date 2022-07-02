<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    public function build(Request $request)
    {
        $month = Carbon::now($request->month)->format('F');

        return $this
        ->from($request->sender_invoice_email)
        ->subject((optional($this->invoice->project)->name ?: $this->invoice->client->name . ' Projects') . ' invoice ' . '-' . ' ' . $month . ' ' . $request->year)
        ->view('invoice::mail.pending-invoice')
        ->with(['invoice' => $this->invoice]);
    }
}
