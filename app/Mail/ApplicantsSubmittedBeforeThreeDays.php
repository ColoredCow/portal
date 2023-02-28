<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantsSubmittedBeforeThreeDays extends Mailable
{
    use Queueable, SerializesModels;

    public $screeningApplicants;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($screeningApplicants)
    {
        $this->screeningApplicants = $screeningApplicants;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $count = $this->screeningApplicants->count();
        $subject = "$count applicants submitted their application before 3 days.";

        return $this->view('emails.applicants_before_three_days', [
                        'applicants' => $this->screeningApplicants,
                        'count' => $this->screeningApplicants->count(), ])
                    ->subject($subject);
    }
}
