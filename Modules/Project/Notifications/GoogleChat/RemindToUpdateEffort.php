<?php
namespace Modules\Project\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Card;
use NotificationChannels\GoogleChat\Components\Button\TextButton;
use NotificationChannels\GoogleChat\Enums\Icon;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Widgets\KeyValue;

class RemindToUpdateEffort extends Notification
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

    public function via()
    {
        return [
            GoogleChatChannel::class,
        ];
    }

    public function toGoogleChat()
    {
        return GoogleChatMessage::create()
            ->mentionAll('', " it's time to update your efforts for today!\n")
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
                    )
            );
    }
}
