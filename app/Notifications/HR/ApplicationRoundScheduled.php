<?php

namespace App\Notifications\HR;

use App\Models\HR\ApplicationRound;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $application = $this->applicationRound->application;
        $job = $application->job;
        return (new MailMessage)
            ->subject(config('app.name') . ': New application round scheduled')
            ->line('You have been assigned an application round.')
            ->action('View this application', route("applications.$job->type.edit", $application->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
