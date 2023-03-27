<?php

namespace Modules\Project\Notifications\GoogleChat;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Project\Entities\Project;
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
        $projects = Project::all();
        foreach ($projects as $project) {
            $date = Carbon::today()->setDay($project->client->billingDetails->billing_date);
            if ($date > today()) {
                $interval = date_diff(today(), $date);
                if ($interval->days == 1) {
                    return GoogleChatMessage::create()
                        ->mentionAll('', ' Please check and update the efforts sheet to avoid last minutes updates at the end of the billing cycle.');
                }
            }
        }
    }
}
