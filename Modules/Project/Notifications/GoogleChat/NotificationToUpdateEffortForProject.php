<?php

namespace Modules\Project\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Client\Entities\Client;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;

class NotificationToUpdateEffortForProject extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return [
            GoogleChatChannel::class
        ];
    }

    public function toGoogleChat($notifiable)
    {
        $projects = Client::all();
        foreach ($projects as $project) {
            $interval = date_diff($project->billingDetails->billing_date, today());

            if ($interval->days == 1) {
                return GoogleChatMessage::create()
                    ->mentionAll('', "  Please check and update the efforts sheet to avoid last minutes updates at the end of the billing cycle.\n");
            }
        }
    }
}
