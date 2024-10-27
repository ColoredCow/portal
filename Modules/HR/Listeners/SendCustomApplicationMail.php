<?php

namespace Modules\HR\Listeners;

use App\Helpers\ContentHelper;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Application\CustomApplicationMail;
use Modules\HR\Entities\ApplicationMeta;

class SendCustomApplicationMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        if (! isset($event->data['action'], $event->data['mail_subject'], $event->data['mail_body'], $event->data['mail_sender_name'])) {
            return;
        }

        $mailDetails = [
            'action' => ContentHelper::editorFormat($event->data['action']),
            'mail-subject' => ContentHelper::editorFormat($event->data['mail_subject']),
            'mail-body' => ContentHelper::editorFormat($event->data['mail_body']),
            'mail-sender' => $event->data['mail_sender_name'],
        ];

        ApplicationMeta::create([
            'hr_application_id' => $event->application->id,
            'key' => config('constants.hr.application-meta.keys.custom-mail'),
            'value' => json_encode($mailDetails),
        ]);

        Mail::send(new CustomApplicationMail($event->application, $mailDetails['mail-subject'], $mailDetails['mail-body']));
    }
}
