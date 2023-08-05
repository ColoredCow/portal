<?php

namespace Modules\Project\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;

class NotificationToUpdateEffortForProject extends Notification
{
    use Queueable;

    public function via()
    {
        return [
            GoogleChatChannel::class
        ];
    }

    public function toGoogleChat()
    {
        return GoogleChatMessage::create()
            ->mentionAll('', ' Please check and update the efforts sheet to avoid last minutes updates at the end of the billing cycle.');
    }
}
