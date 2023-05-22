<?php

namespace Modules\CodeTrek\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodetrekMailApplicantRound extends Mailable
{
    use Queueable, SerializesModels;
    public $applicationRound;
    public $codetrekApplicant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicationRound, $codetrekApplicant)
    {
        $this->applicationRound = $applicationRound;
        $this->codetrekApplicant = $codetrekApplicant;
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
        ->to($this->codetrekApplicant[0]->email)
        ->subject('ColoredCow Portal - Round Change Notification')
        ->view('codetrek::mail.codetrek-round');
    }
}
