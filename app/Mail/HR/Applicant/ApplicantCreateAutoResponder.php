<?php

namespace App\Mail\HR\Applicant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantCreateAutoResponder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The mail subject.
     *
     * @var String
     */
    public $subject;

    /**
     * The mail body.
     *
     * @var String
     */
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'))
            ->subject($this->subject)
            ->view('mail.plain')->with([
                'body' => $this->body
            ]);
    }
}
