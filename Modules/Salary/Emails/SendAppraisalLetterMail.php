<?php

namespace Modules\Salary\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAppraisalLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function build()
    {
        return $this->from('jyoti.srivastava@colored.com', 'Jyoti Srivastava')
        ->subject('hello - Salary Notification')
        ->view('salary::emails.appraisalLetterMail');
    }
}
