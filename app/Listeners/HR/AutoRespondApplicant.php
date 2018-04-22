<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicantCreated;
use App\Mail\HR\Applicant\ApplicantCreateAutoResponder;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

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
     * @param  ApplicantCreated  $event
     * @return void
     */
    public function handle(ApplicantCreated $event)
    {
        $applicant = $event->applicant;

        $subject = Setting::where('module', 'hr')->where('setting_key', 'applicant_create_autoresponder_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'applicant_create_autoresponder_body')->first();
        
        Mail::to($applicant->email, $applicant->name)
            ->send(new ApplicantCreateAutoResponder($subject->setting_value, $body->setting_value));

        $applicant->update([
            'autoresponder_subject' => $subject->setting_value,
            'autoresponder_body' => $body->setting_value,
        ]);
    }
}
