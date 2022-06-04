<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationRound, $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicationRound, $application)
    {
        $this->applicationRound = $applicationRound;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'), config('hr.default.name'))
            ->subject('Application rounds scheduled for today')
            ->view('hr::mail.interviewer-scheduled-rounds-reminder')->with([
                'applicationRound' => $this->applicationRound,
                'application' => $this->application
            ]);
    }
}
