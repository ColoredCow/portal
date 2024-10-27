<?php
namespace Modules\CodeTrek\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodetrekMailApplicant extends Mailable
{
    use Queueable, SerializesModels;
    public $applicant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant)
    {
        $this->applicant = $applicant;
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
            ->to($this->applicant['email_id'])
            ->subject('ColoredCow Portal - Welcome to the CodeTrek')
            ->view('codetrek::mail.codetrek');
    }
}
