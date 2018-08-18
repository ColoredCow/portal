<?php

namespace App\Mail\HR;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendForApproval extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->to('vikasmrnv@gmail.com')
            ->bcc(config('constants.hr.default.email'))
            ->subject('Requested For Approval')
            ->view('mail.hr.send-for-approval');
    }
}
