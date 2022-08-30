<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\HR\Entities\Applicant;

class SendOnHoldMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    // public $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $subject, string $body , $applicant)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // to email
        // to name
        // subject
        // body
        // from email
        // from name
        return $this->to($this->applicant->email, $this->applicant->name)
        ->subject($this->subject)
        ->from(config('hr.default.email'), config('hr.default.name'))
        ->view('mail.plain')
        ->with([
            'body' => $this->body,
        ]);
    }
}
