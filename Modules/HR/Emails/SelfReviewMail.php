<?php

namespace Modules\HR\Emails;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SelfReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $targetedDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $targetedDate = null)
    {
        $this->employee = $employee;
        $this->targetedDate = $targetedDate ?? Carbon::now()->addDays(7)->format('d-m-y');
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

        $subject = 'Quarterly Self Review: ' . $this->getQuarterMonth($currentQuarter) . ' ' . $currentYear;

        return $this
            ->from(config('hr.default.email'))
            ->to($this->employee->first()->email)
            ->subject($subject)
            ->view('hr::mail.self-review');
    }

    /**
     * Get the name of the quarter month based on the quarter number.
     *
     * @param int
     * @return string
     */
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
