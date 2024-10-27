<?php
namespace Modules\HR\Listeners;

use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Notifications\RoundMailSentNotification;

class AppointmentSlotMailSent
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
     */
    public function handle($event)
    {
        if (! $event->getCondition() == 'select-appointment-slot') {
            return true;
        }

        $applicationRound = $event->getOptions('application_round');
        $conductedPerson = $applicationRound->getPreviousApplicationRound()->conductedPerson;
        $scheduledPerson = $applicationRound->scheduledPerson;

        // if a person is scheduling the next round for him/herself, they should not receive any notification.
        if ($conductedPerson->id != $scheduledPerson->id) {
            $applicationRound->scheduledPerson->notify(new RoundMailSentNotification($applicationRound));
        }

        $applicationMeta = new ApplicationMeta;
        $applicationMeta->hr_application_id = $applicationRound->application->id;
        $applicationMeta->key = config('constants.hr.application-meta.keys.custom-mail');

        $mailData = $event->getOptions('mail_data');

        $applicationMeta->value = json_encode([
            'mail-subject' => $mailData['subject'],
            'mail-body' => $mailData['body'],
            'mail-sender' => $applicationRound->scheduledPerson->name,
            'title' => "Email sent to schedule interview for {$applicationRound->round->name}",
        ]);

        $applicationMeta->save();
    }
}
