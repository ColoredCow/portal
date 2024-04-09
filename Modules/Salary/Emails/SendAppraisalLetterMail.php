<?php

namespace Modules\Salary\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAppraisalLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $pdf;

    public function __construct($employee, $pdf)
    {
        $this->employee = $employee;
        $this->pdf = $pdf;
    }

    public function build()
    {
        $ccEmails = array_map('trim', explode(',', $this->employee['ccemails']));
        $ccEmails = array_filter($ccEmails); // Remove any empty elements

        return $this->from('hr@coloredcow.com', 'Mohit Sharma')
            ->subject('Appraisal Letter - ' . $this->employee['employeeName'])
            ->view('salary::emails.appraisalLetterMail', $this->employee)
            ->attachData($this->pdf, $this->employee['employeeName'] . '.pdf', ['mime' => 'application/pdf'])
            ->when(!empty($ccEmails) && is_array($ccEmails), function ($message) use ($ccEmails) {
                $message->cc($ccEmails);
            });

    }
}
