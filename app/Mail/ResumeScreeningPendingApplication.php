<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResumeScreeningPendingApplication extends Mailable
{
    use Queueable, SerializesModels;

    public $applications;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Applications in resume screening round for more than 3 days.';

        return $this->view('emails.application_in_resume_screening_reminder', [
                        'applications' => $this->applications,
                        'count' => $this->applications->count(), ])
                    ->subject($subject);
    }
}
