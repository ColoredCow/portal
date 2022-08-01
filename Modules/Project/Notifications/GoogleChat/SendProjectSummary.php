<?php

namespace Modules\Project\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use NotificationChannels\GoogleChat\Card;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Enums\Icon;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\GoogleChat\Widgets\Image;
use NotificationChannels\GoogleChat\Widgets\Buttons;
use NotificationChannels\GoogleChat\Enums\ImageStyle;
use NotificationChannels\GoogleChat\Widgets\KeyValue;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Widgets\TextParagraph;
use NotificationChannels\GoogleChat\Components\Button\TextButton;

class SendProjectSummary extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [
            GoogleChatChannel::class
        ];
    }

    public function toGoogleChat($notifiable)
    {
        return GoogleChatMessage::create()
            ->mentionAll('', " here's a summary of the daily effort")
            ->card(
                Card::create()
                    ->header(
                        'Daily Effort Summary - ProjectX',
                        today()->format('d M, Y')
                    )
                    ->section([
                        Section::create(
                            TextParagraph::create('Gaurav Gusain - ')
                                ->color('20 hours', '#38c172')
                                ->break()
                                ->text('Vaibhav Rathore - ')
                                ->color('18 hours', '#ff0000')
                        ),
                        Section::create(
                            TextParagraph::create()->link('https://portal.coloredcow.com', 'View Project')
                        )
                    ])
            );
    }
}
