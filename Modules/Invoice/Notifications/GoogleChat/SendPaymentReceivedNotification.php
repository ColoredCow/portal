<?php

namespace Modules\Invoice\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;

class SendPaymentReceivedNotification extends Notification
{
    use Queueable;
    public $invoiceNotificationData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoiceNotificationData)
    {
        $this->invoiceNotificationData = $invoiceNotificationData;
    }

    public function via($notifiable)
    {
        return [
            GoogleChatChannel::class
        ];
    }

    public function toGoogleChat($notifiable)
    {
        return GoogleChatMessage::create()->mentionAll('', 'We have received the payment for' .
        $this->invoiceNotificationData . 'successfully!\n');
    }
}
