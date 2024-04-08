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
        return $this->from('hr@coloredcow.com', 'Mohit Sharma')
        ->subject('Appraisal Letter -', $this->employee['employeeName'])
        ->view('salary::emails.appraisalLetterMail', $this->employee);
    }
}
