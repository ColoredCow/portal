<?php

namespace App\Http\Controllers\HR\Applications;

use App\Helpers\ContentHelper;
use App\Http\Controllers\HR\Applications\ApplicationController;
use App\Http\Requests\HR\CustomApplicationMailRequest;
use App\Mail\HR\Application\CustomApplicationMail;
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

    public function sendMail(CustomApplicationMailRequest $mailRequest, Application $application)
    {
        $validated = $mailRequest->validated();

        $mailDetails = [
            'action' => ContentHelper::editorFormat($validated['mail_action']),
            'mail_subject' => ContentHelper::editorFormat($validated['mail_subject']),
            'mail_body' => ContentHelper::editorFormat($validated['mail_body']),
            'mail_triggered_by' => Auth::id(),
        ];

        ApplicationMeta::create([
            'hr_application_id' => $application->id,
            'key' => config('constants.hr.application-meta.keys.custom-mail'),
            'value' => json_encode($mailDetails),
        ]);

        Mail::send(new CustomApplicationMail($application, $mailDetails['mail_subject'], $mailDetails['mail_body']));

        $status = "Mail sent successfully to <b>" . $application->applicant->name . "</b> at <b>" . $application->applicant->email . "</b>.<br>";

        return redirect()->back()
            ->with('status', $status);
    }
}
