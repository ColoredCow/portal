<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SelfReviewMail extends Mailable
{
    use Queueable, SerializesModels;
    public $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
        $this->build();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('hr.default.email'))
            ->to($this->employee->first()->email)
            ->subject('Quarterly Self Review:')
            ->view('hr::mail.self-review');
    }
}
