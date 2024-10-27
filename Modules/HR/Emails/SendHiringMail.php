<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendHiringMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobHiring;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobHiring)
    {
        $this->jobHiring = $jobHiring;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
        ->subject('HR-New job requisition is available')
        ->to('hr@coloredcow.com')
        ->view('emails.send-hiring');
    }
}
