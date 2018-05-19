<?php

namespace App\Notifications\HR;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\HR\ApplicationRound;

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
        return (new MailMessage)
                    ->subject( config('app.name') . ': New application round scheduled')
                    ->line('You have been assigned to conduct an application round.')
                    ->action('View this application', url("hr/applications/$application->id/edit"));
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
