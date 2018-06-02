<?php

namespace App\Mail\HR;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewerScheduledRoundsReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Application rounds scheduled for the user
     * @var array
     */
    public $applicationRounds;

    /**
     * Create a new message instance.
     * @param array $applicationRound
     */
    public function __construct(array $applicationRounds)
    {
        $this->applicationRounds = $applicationRounds;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'))
            ->subject('Application rounds scheduled for today')
            ->view('mail.hr.interviewer-scheduled-rounds-reminder')->with([
                'applicationRounds' => $this->applicationRounds,
            ]);
    }
}
