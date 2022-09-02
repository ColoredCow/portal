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
        $mail = $this->subject('HR-New job requisition is available');
        $mail->to('hr@coloredcow.com');

        return
        $mail->view('emails.send-hiring');
    }
}
