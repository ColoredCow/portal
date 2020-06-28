<?php

namespace Modules\HR\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\HR\ApplicationRound;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SelectAppointmentSlotNotification extends Notification
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $schedulePerson = $this->applicationRound->scheduledPerson;
        $params = encrypt(json_encode(['user_id' => $schedulePerson->id, 'application_round_id' => $this->applicationRound->id]));
        return (new MailMessage)
            ->subject(config('app.name') . ': New application round scheduled')
            ->line('Click the button to schedule your interview.')
            ->action('Schedule now', route('select-appointments', $params));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
