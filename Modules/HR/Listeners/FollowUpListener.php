<?php

namespace Modules\HR\Listeners;

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Applicant\ApplicantCreateAutoResponder;
use Modules\HR\Entities\FollowUp;
use Modules\User\Entities\User;

class FollowUpListener
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
     * @return void
     */
    public function handle($event)
    {
        $application = $event->application;
        $applicant = $application->applicant;
        $subject = Setting::where('module', 'hr')->where('setting_key', config('hr.templates.follow_up_email_for_scheduling_interview.subject'))->first();
        $body = Setting::where('module', 'hr')->where('setting_key', config('hr.templates.follow_up_email_for_scheduling_interview.body'))->first();

        $body->setting_value = str_replace(config('constants.hr.template-variables.applicant-name'), $applicant->name, $body->setting_value);
        $body->setting_value = str_replace(config('hr.template-variables.round-name'), $application->latestApplicationRound->round->name, $body->setting_value);

        Mail::to($applicant->email, $applicant->name)
            ->send(new ApplicantCreateAutoResponder($subject->setting_value, $body->setting_value));

        $application->update([
            'applicant_verification_subject' => $subject->setting_value,
            'applicant_verification_body' => $body->setting_value,
        ]);

        FollowUp::create([
            'hr_application_round_id' => $application->latestApplicationRound->id,
            'comments' => 'sent follow up email',
            'conducted_by' => User::select('id')->first()->id
                ]);
    }
}
