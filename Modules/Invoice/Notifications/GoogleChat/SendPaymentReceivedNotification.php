<?php

namespace Modules\Invoice\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;

class SendPaymentReceivedNotification extends Notification
{
    use Queueable;
    public $projectAndClientName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($projectAndClientName)
    {
        $this->projectAndClientName = $projectAndClientName;
    }

    public function via($notifiable)
    {
        return [
            GoogleChatChannel::class
        ];
    }

    public function toGoogleChat($notifiable)
    {
        return GoogleChatMessage::create()->mentionAll('', ' We have received the payment for ' .
        $this->projectAndClientName . ' successfully!\n ');
    }
}
