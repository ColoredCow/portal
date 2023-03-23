<?php

namespace Modules\Project\Notifications\GoogleChat;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use NotificationChannels\GoogleChat\Card;
use Modules\Project\Entities\Project;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Enums\Icon;
use NotificationChannels\GoogleChat\Widgets\KeyValue;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Components\Button\TextButton;

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
            $diff_in_dates = date_diff($project->end_date, today());

            if ($diff_in_dates->days == 1) {
                return GoogleChatMessage::create()
                    ->mentionAll('', "  Please check and update the efforts sheet to avoid last minutes updates at the end of the billing cycle.\n");
            }
        }
    }
}
