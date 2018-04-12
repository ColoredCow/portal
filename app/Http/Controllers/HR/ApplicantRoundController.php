<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Models\HR\ApplicantRound;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicantRoundController extends Controller
{

    /**
     * Send email to the applicant for current round
     *
     * @param  ApplicantRoundMailRequest $request
     * @param  ApplicantRound            $applicantRound
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail(ApplicantRoundMailRequest $request, ApplicantRound $applicantRound)
    {
        $validated = $request->validated();
        $mail_body = preg_replace('/\r\n/', '', $validated['mail_body']);
        $applicant = $applicantRound->applicant;

        Mail::raw($validated['mail_body'], function($message) use ($validated, $applicant) {
            $message->to($applicant->email, $applicant->name)
                    ->subject($validated['mail_subject'])
                    ->bcc($applicant->job->posted_by)
                    ->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'));
        });

        $applicantRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $mail_body,
            'mail_sender' => Auth::id(),
            'mail_sent_at' => Carbon::now(),
        ]);

        return redirect()->back()->with(
            'status',
            "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
            <span data-toggle='modal' data-target='#round_mail_$applicantRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        );
    }
}
