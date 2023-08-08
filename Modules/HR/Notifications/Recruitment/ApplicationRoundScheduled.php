<?php

namespace Modules\HR\Notifications\Recruitment;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\HR\Entities\ApplicationRound;

class ApplicationRoundScheduled extends Notification
{
    use Queueable;

    /**
     * The application round that has been scheduled.
     */
    protected $applicationRound;

    /**
     * Create a new notification instance.
     *
     * @param ApplicationRound $applicationRound
     */
    public function __construct(ApplicationRound $applicationRound)
    {
        $this->applicationRound = $applicationRound;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        $application = $this->applicationRound->application;
        $applicant = $application->applicant;
        $job = $application->job;

        return (new MailMessage)
            ->subject(config('app.name') . ": {$this->applicationRound->round->name} scheduled")
            ->line('You have been assigned an application round.')
            ->line("Candidate name: {$applicant->name}")
            ->line("Round: {$this->applicationRound->round->name}")
            ->line("Timing: {$this->applicationRound->scheduled_date->format(config('constants.display_daydatetime_format'))}")
            ->line("Meeting Link: {$this->applicationRound->hangout_link}")
            ->action('View this application', route("applications.{$job->type}.edit", $application->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            //
        ];
    }
}
