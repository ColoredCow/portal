<?php

namespace Modules\Project\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use NotificationChannels\GoogleChat\Card;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Widgets\TextParagraph;

class SendProjectSummary extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return [
            GoogleChatChannel::class
        ];
    }

    public function toGoogleChat($notifiable)
    {
        $teamMemberTextParagraph = TextParagraph::create()
            ->bold('Individual velocities');
        foreach ($this->data['teamMembers'] as $teamMemberData) {
            $teamMemberTextParagraph->break()
                ->text($teamMemberData['name'] . ': ')
                ->color($teamMemberData['velocity'], $teamMemberData['velocityColor']);
        }

        return GoogleChatMessage::create()
            ->mentionAll('', " here's a summary of the daily effort")
            ->card(
                Card::create()
                    ->header(
                        'Daily Effort Summary • ' . $this->data['projectName'],
                        today()->format('d M, Y')
                    )
                    ->section([
                        Section::create($teamMemberTextParagraph),
                        Section::create(
                            TextParagraph::create()->link($this->data['projectUrl'], 'View Project')
                        )
                    ])
            );
    }
}
