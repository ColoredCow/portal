<?php

namespace App\Http\Controllers\HR\Applications;

use App\Helpers\ContentHelper;
use App\Http\Controllers\HR\Applications\ApplicationController;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Mail\HR\Application\CustomMail;
use App\Models\HR\Application;
use App\Models\HR\ApplicationMeta;
use Illuminate\Support\Facades\Auth;
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

        $mailDetails = [
            'action' => 'action name',
            'mail_subject' => ContentHelper::editorFormat($validated['mail_subject']),
            'mail_body' => ContentHelper::editorFormat($validated['mail_body']),
            'mail_triggered_by' => Auth::user()->email,
        ];

        ApplicationMeta::create([
            'hr_application_id' => $application->id,
            'key' => config('constants.hr.application-meta.keys.custom-mail'),
            'value' => json_encode($mailDetails),
        ]);

        Mail::send(new CustomMail($application, $mailDetails['mail_subject'], $mailDetails['mail_body']));

        return redirect()->back();

        // ->with(
        //     'status',
        //     "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
        //     <span data-toggle='modal' data-target='#round_mail_$applicationRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        // )
    }
}
