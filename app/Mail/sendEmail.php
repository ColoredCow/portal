<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $applications;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    /**
     * Build the message.
     *
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'), config('hr.default.name'))
        ->to(config('mail.error_address'))
        ->subject('Follow up with non verified applicants')
        ->view('emails.send-non-verified-applicants-information-email');
    }
}
