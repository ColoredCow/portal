<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendApplicationRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hrApplicantEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->hrApplicantEmail = $email;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'))
            ->to($this->hrApplicantEmail)
            ->subject('Application Rejected Mail')
            ->view('emails.send-application-rejection-mail');
    }
}
