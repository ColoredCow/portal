<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeAssessmetReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $key;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key, $data)
    {
        $this->key = $key;
        $this->data = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $currentQuarter = now()->quarter;
        $currentYear = date('Y');
        $subject = '';
        $mailTemplate = '';
        $currentQuarterMonth = $this->getQuarterMonth($currentQuarter);
        $user = $this->data['user'];

        switch ($this->key) {
            case 'self':
                $subject = 'Quarterly Self Review: ' . $currentQuarterMonth . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.self-review';
                break;
            case 'hr':
                $subject = 'Quarterly HR Review: ' . $currentQuarterMonth . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.hr-review';
                break;
            case 'mentor':
                $subject = 'Quarterly Mentor Review: ' . $currentQuarterMonth . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.mentor-review';
                break;
            case 'manager':
                $subject = 'Quarterly Manager Review: ' . $currentQuarterMonth . ' ' . $currentYear;
                $mailTemplate = 'hr::mail.manager-review';
                break;
        }

        return $this
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->to($user['email'])
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
