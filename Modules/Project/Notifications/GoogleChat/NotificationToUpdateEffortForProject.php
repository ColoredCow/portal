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
        $projects = PROJECT::all();
        foreach ($projects as $project) {
            $diff_project = CARBON::NOW()->diff($project->end_date());

            if ($diff_project == 1) {
                return GoogleChatMessage::create()
                    ->mentionAll('', " it's time to update your efforts the end date is tomorrow!\n")
                    ->card(
                        Card::create()
                            ->section(
                                Section::create(
                                    KeyValue::create('Project', $this->project->name)
                                    ->setContentMultiline(true)
                                    ->icon(Icon::CLOCK)
                                    ->button(
                                        TextButton::create($this->project->effort_sheet_url, 'Open effortsheet')
                                    )
                                ),
                            ),
                    );
            }
        }
    }
}
