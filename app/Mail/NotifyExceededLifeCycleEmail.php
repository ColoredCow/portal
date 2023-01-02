<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyExpiredLifeCycleEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $expiredApplicationNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($expiredApplicationNumber)
    {
        $this->expiredApplicationNumber = $expiredApplicationNumber;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-application-lifecycle');
    }
}
