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
    public function __construct($supervisor, $application)
    {
        $this->supervisor = $supervisor;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->supervisor['email'])
            ->subject('Requested For Approval')
            ->view('mail.hr.send-for-approval')->with([
                'application' => $this->application,
                'supervisor' => $this->supervisor,
            ]);
    }
}