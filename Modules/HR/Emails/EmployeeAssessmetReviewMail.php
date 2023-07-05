<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeAssessmetReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $key;
    public $user;
    public $employee;
    public $links;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key, $user, $employee, $links)
    {
        $this->key = $key;
        $this->user = $user;
        $this->employee = $employee;
        $this->links = $links;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $currentQuarter = now()->quarter; // Calculate current quarter
        $currentYear = date('Y'); // Get current year
        $subject = '';
        $mailTemplate = '';
        switch ($this->key) {
            case 'selfMail':
                $subject = 'Quarterly Self Review: ' . $this->getQuarterMonth($currentQuarter) . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.self-review';
                break;
            case 'hrMail':
                $subject = 'Quarterly HR Review: ' . $this->getQuarterMonth($currentQuarter) . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.hr-review';
                break;
            case 'managerMail':
                $subject = 'Quarterly Manager Review: ' . $this->getQuarterMonth($currentQuarter) . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.manager-review';
                break;
            default:
                $subject = 'Quarterly Mentor Review: ' . $this->getQuarterMonth($currentQuarter) . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.mentor-review';
        }
        return $this
            ->from(config('hr.default.email'))
            ->to($this->user->email)
            ->subject($subject)
            ->view($mailTemplate);
    }

    public function getQuarterMonth($quarterNumber)
    {
        $quarterMonths = [
            1 => 'January - March',
            2 => 'April - June',
            3 => 'July - September',
            4 => 'October - December',
        ];

        return $quarterMonths[$quarterNumber] ?? '';
    }
}
