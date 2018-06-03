<?php

namespace App\Mail\HR\Applicant;

use App\Models\HR\ApplicationRound;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledInterviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of the application round for which the applicant needs to be reminded.
     * @var ApplicationRound
     */
    public $applicationRound;

    /**
     * Create a new message instance.
     * @param ApplicationRound $applicationRound
     */
    public function __construct(ApplicationRound $applicationRound)
    {
        $this->applicationRound = $applicationRound;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = $this->applicationRound->application;

        return $this->to($application->applicant->email, $application->applicant->name)
            ->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'))
            // the following template should be editable from the settings tab.
            ->subject('ColoredCow – Interview scheduled for today')
            ->view('mail.plain')->with([
                'body' => "Hi,<br>Just in case if you are not aware, you have an interview scheduled for today with ColoredCow. Please make sure you've confirmed for the interview by confirming the Google calendar invitation. If already done, please ignore."
            ]);
    }
}
