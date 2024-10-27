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
    public $commencementDateFormat;

    public function __construct($employee, $pdf, $commencementDateFormat)
    {
        $this->employee = $employee;
        $this->pdf = $pdf;
        $this->commencementDateFormat = $commencementDateFormat;
    }

    public function build()
    {
        $ccEmails = array_map('trim', explode(',', $this->employee['ccemails']));
        $ccEmails = array_filter($ccEmails);

        return $this->from(config('salary.default.email'), config('salary.default.name'))
            ->subject('Appraisal Letter - ' . $this->employee['employeeName'])
            ->view('salary::emails.appraisalLetterMail', $this->employee)
            ->attachData($this->pdf, $this->employee['employeeName'] . '_Appraisal Letter_' . $this->commencementDateFormat . '.pdf', ['mime' => 'application/pdf'])
            ->when(! empty($ccEmails) && is_array($ccEmails), function ($message) use ($ccEmails) {
                $message->cc($ccEmails);
            });
    }
}
