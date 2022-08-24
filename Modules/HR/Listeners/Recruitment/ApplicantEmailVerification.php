<?php

namespace Modules\HR\Listeners\Recruitment;

use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Applicant\ApplicantCreateAutoResponder;
use Modules\HR\Events\Recruitment\ApplicationCreated;

class ApplicantEmailVerification
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
        $attr['email_template'] = $applicant->emailTemplate;

        $subject = request()->subject;
        $body = request()->body;

        $body = str_replace(config('constants.hr.template-variables.applicant-name'), $application->applicant->name, $body);
        $encryptedEmail = encrypt($application->applicant->email);
        $verification_link = route('applicant.email.verification', [$encryptedEmail, $application->id]);
        $body = str_replace(config('constants.hr.template-variables.verification-link'), $verification_link, $body);

        if (request()->ApplicantVerificationEmail) {
            Mail::to($applicant->email, $applicant->name)
            ->queue(new ApplicantCreateAutoResponder($subject, $body));
        }

        $application->update([
            'applicant_verification_subject' => $subject,
            'applicant_verification_body' => $body,
        ]);
    }
}
