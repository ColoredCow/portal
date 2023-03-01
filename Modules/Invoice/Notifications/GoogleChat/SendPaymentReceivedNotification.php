<?php

namespace Modules\Invoice\Notifications\GoogleChat;

use Illuminate\Bus\Queueable;
use NotificationChannels\GoogleChat\Card;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Enums\Icon;
use NotificationChannels\GoogleChat\Widgets\KeyValue;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Components\Button\TextButton;

class SendPaymentReceivedNotification extends Notification
{
    use Queueable;
    protected $invoice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
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
            ->mentionAll('', " We have received the payment for {$this->invoice->project->name} ? : {$this->invoice->client->name} successfully!\n")
            ->card(
                Card::create()
                    ->section(
                        Section::create(
                            KeyValue::create('Invoice', $this->invoice->project->name)
                                ->setContentMultiline(true)
                                ->icon(Icon::DOLLAR)
                                ->button(
                                    TextButton::create($this->invoice->project->google_chat_webhook_url, 'View invoice')
                                )
                        ),
                    )
            );
    }
}
