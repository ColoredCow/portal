<?php

namespace App\Http\Controllers\HR\Applications;

use App\Helpers\ContentHelper;
use App\Http\Controllers\HR\Applications\ApplicationController;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Mail\HR\Application\CustomMail;
use App\Models\HR\Application;
use App\Models\HR\ApplicationMeta;
use Illuminate\Support\Facades\Mail;

class JobApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'job';
    }

    public function sendMail(ApplicantRoundMailRequest $mailRequest, Application $application)
    {
        $validated = $mailRequest->validated();

        $mail = [
            'Mail' => ContentHelper::editorFormat($validated['mail_subject']),
            'Message' => ContentHelper::editorFormat($validated['mail_body']),
        ];

        $application_meta = ApplicationMeta::where('hr_application_id', $application->id)
            ->where('key', config('constants.hr.application-meta.keys.form-data'))
            ->get()
            ->first();

        if (!$application_meta) {
            // no previous form-data entry for this application
            // create a new entry
            ApplicationMeta::create([
                'hr_application_id' => $application->id,
                'key' => config('constants.hr.application-meta.keys.form-data'),
                'value' => json_encode($mail),
            ]);
        } else {
            dd(json_decode($application_meta->value));
        }

        Mail::send(new CustomMail($application, $mail));

        $applicant = $application->applicant;
        return redirect()->back();

        // ->with(
        //     'status',
        //     "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
        //     <span data-toggle='modal' data-target='#round_mail_$applicationRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        // )
    }
}
