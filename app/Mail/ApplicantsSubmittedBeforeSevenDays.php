<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantsSubmittedBeforeSevenDays extends Mailable
{
    use Queueable, SerializesModels;

    public $applicants;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicants)
    {
        $this->applicants = $applicants;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $count = $this->applicants->count();
        $subject = "$count applicants submitted their application before 7 days.";

        return $this->view('emails.applicants_before_seven_days', [
                        'applicants' => $this->applicants,
                        'count' => $this->applicants->count(),])
                    ->subject($subject);
    }
}