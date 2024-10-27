<?php
namespace Modules\HR\Observers\Recruitment;

use App\Services\CalendarEventService;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Events\ApplicationMovedToNewRound;
use Modules\HR\Events\CustomMailTriggeredForApplication;

class ApplicationRoundObserver
{
    /**
     * Listen to the ApplicationRound created event.
     *
     * @param  ApplicationRound  $applicationRound
     * @return void
     */
    public function created(ApplicationRound $applicationRound)
    {
        // Mark all the previous rounds for this application as old and mark this one as is latest.
        $applicationRound->updateIsLatestColumn();

        $applicationRound->load('application', 'scheduledPerson');

        $applicationRound->application->untag('need-follow-up');

        if ($applicationRound->application->status != config('constants.hr.status.on-hold.label')) {
            $data = request()->all();
            if (isset($data['send_mail_to_applicant']['confirm'])) {
                $data['action'] = "Email sent to schedule interview for {$applicationRound->round->name}";
                $data['mail_subject'] = $data['mail_to_applicant']['confirm']['subject'];
                $data['mail_body'] = $data['mail_to_applicant']['confirm']['body'];
                $data['mail_sender_name'] = $data['mail_sender_name'] ?? auth()->user()->name;
            }
            event(new ApplicationMovedToNewRound($applicationRound, $data));
            // SendApplicationRoundScheduled::dispatch($applicationRound);
        }

        // if (request()->get('create_calendar_event')) {
        //     self::createCalendarEvent($applicationRound);
        // }
    }

    /**
     * Listen to the ApplicationRound updated event.
     *
     * @param  ApplicationRound  $applicationRound
     * @return void
     */
    public function updated(ApplicationRound $applicationRound)
    {
        if ($applicationRound->round_status == config('constants.hr.status.rejected.label')) {
            $applicationRound->load('application', 'scheduledPerson');
            $data = request()->all();
            if (isset($data['send_mail_to_applicant']['reject'])) {
                $data['action'] = "Email sent for rejection for {$applicationRound->round->name}";
                $data['mail_subject'] = $data['mail_to_applicant']['reject']['subject'];
                $data['mail_body'] = $data['mail_to_applicant']['reject']['body'];
                $data['mail_sender_name'] = $data['mail_sender_name'] ?? auth()->user()->name;
                event(new CustomMailTriggeredForApplication($applicationRound->application, $data));
            }
        }
    }

    /**
     * Create the calendar event for the application round instance.
     *
     * @param  ApplicationRound $applicationRound
     */
    public function createCalendarEvent(ApplicationRound $applicationRound)
    {
        $applicant = $applicationRound->application->applicant;
        $summary = request()->get('summary_calendar_event');

        $event = new CalendarEventService;
        $event->create([
            'summary' => $summary,
            'start' => $applicationRound->scheduled_date->format(config('constants.datetime_format')),
            'end' => $applicationRound->scheduled_end,
            'attendees' => [
                $applicationRound->scheduledPerson->email,
                $applicant->email,
            ],
        ]);

        $applicationRound->update([
            'calendar_event' => $event->id,
        ]);
    }
}
