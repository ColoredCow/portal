<?php

namespace Modules\CodeTrek\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodetrekMailApplicant extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->build();

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'))
            ->to($this->data['email_id'])
            ->subject('ColoredCow Portal - Welcome to the CodeTrek')
            ->view('codetrek::mail.codetrek');
    }
}
