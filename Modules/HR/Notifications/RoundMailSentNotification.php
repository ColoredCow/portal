<?php

namespace Modules\HR\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\HR\Entities\ApplicationRound;

class RoundMailSentNotification extends Notification
{
    use Queueable;

    protected $applicationRound;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ApplicationRound $applicationRound)
    {
        $this->applicationRound = $applicationRound;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $applicant = $this->applicationRound->application->applicant;
        $conductedPerson = $this->applicationRound->getPreviousApplicationRound()->conductedPerson;

        return (new MailMessage)
                    ->subject(config('app.name') . ' – HR application round assigned to you')
                    ->line("{$conductedPerson->name} has assigned you an HR application for {$this->applicationRound->round->name}.")
                    ->line("Candidate name: {$applicant->name}")
                    ->line('A confirmation email has been sent to the candidate. We will notify you when the applicant will confirm the interview slot.')
                    ->action('View this application', route('applications.job.edit', $this->applicationRound->application));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
