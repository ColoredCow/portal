<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BasicDetailsOfJoinee extends Mailable
{
    use Queueable, SerializesModels;

    public $joinneeMail;
    public $joinneeName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($joinneeMail, $joinneeName)
    {
        $this->joinneeMail = $joinneeMail;
        $this->joinneeName = $joinneeName;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Subject: Request for Email Creation ')
            ->to($this->joinneeMail)
            ->view('hr::mail.basic-detail-of-joinee');
    }
}
