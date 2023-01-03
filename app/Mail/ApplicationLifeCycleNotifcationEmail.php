<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationLifeCycleNotifcationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $expiredApplicationTotalNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($expiredApplicationTotalNumber)
    {
        $this->expiredApplicationTotalNumber = $expiredApplicationTotalNumber;
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
