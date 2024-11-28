<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUploadedInvoicesMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoicesFolderDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $invoicesFolderDetails)
    {
        $this->invoicesFolderDetails = $invoicesFolderDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $monthYear = now()->subMonth()->format('F Y');

        return $this->to(config('invoice.ca-email.email'))
            ->from(config('invoice.mail.finance-team.email'))
            ->cc(config('invoice.ca-email.email'))
            ->subject('Invoice details for ' . $monthYear)
            ->view('invoice::mail.uploaded-invoice-folder-details-mail')
            ->with([
                'invoicesFolderDetails' => $this->invoicesFolderDetails,
                'monthYear' => $monthYear
            ]);
    }
}
