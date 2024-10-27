<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewNDA extends Notification
{
    use Queueable;

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return (new MailMessage)
                    ->line('Review NDA.')
                    ->action('Review From Here', url('/'))
                    ->line('Thanks');
    }

    public function toArray()
    {
        return [
            //
        ];
    }
}
