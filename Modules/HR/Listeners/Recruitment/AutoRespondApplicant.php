<?php

namespace Modules\HR\Listeners\Recruitment;

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Applicant\ApplicantCreateAutoResponder;
use Modules\HR\Events\Recruitment\ApplicationCreated;

class AutoRespondApplicant
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
     * @param  ApplicationCreated  $event
     * @return void
     */
    public function handle(ApplicationCreated $event)
    {
        $application = $event->application;
        $applicant = $application->applicant;

        $subject = Setting::where('module', 'hr')->where('setting_key', 'applicant_create_autoresponder_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'applicant_create_autoresponder_body')->first();

        $body->setting_value = str_replace(config('constants.hr.template-variables.applicant-name'), $application->applicant->name, $body->setting_value);

        Mail::to($applicant->email, $applicant->name)
            ->send(new ApplicantCreateAutoResponder($subject->setting_value, $body->setting_value));

        $application->update([
            'autoresponder_subject' => $subject->setting_value,
            'autoresponder_body' => $body->setting_value,
        ]);
    }
}
