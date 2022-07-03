<?php

namespace Modules\HR\Emails\Recruitment\Applicant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnHold extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The mail subject.
     *
     * @var string
     */
    public $subject;

    /**
     * The mail body.
     *
     * @var string
     */
    public $body;

    /**
     * Create new message instance.
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
        return $this->from("amanbahuguna009@gmail.com")
            ->subject($this->subject)
            ->view('mail.plain')->with([
            'body' => $this->body,
        ]);
    }
}
