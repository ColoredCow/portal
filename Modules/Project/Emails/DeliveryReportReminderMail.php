<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryReportReminderMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $keyAccountManager;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($keyAccountManager)
    {
        $this->keyAccountManager = $keyAccountManager;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Action Required: Missing Delivery Reports for Scheduled Invoices')
                    ->from(config('mail.from.address'))
                    ->to($this->keyAccountManager->email)
                    ->view('project::mail.delivery-report-reminder');
    }
}
