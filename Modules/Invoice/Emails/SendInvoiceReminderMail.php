<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoiceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $upcomingInvoices;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $upcomingInvoices)
    {
        $this->upcomingInvoices = $upcomingInvoices;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('constants.finance.scheduled-invoice.email'))
            ->from(config('mail.from.address'))
            ->subject('Upcoming Scheduled Invoices Notification')
            ->view('invoice::mail.upcoming-invoice-list')
            ->with(['upcomingInvoices' => $this->upcomingInvoices]);
    }
}
