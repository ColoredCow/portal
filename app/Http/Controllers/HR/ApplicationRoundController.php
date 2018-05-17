<?php

namespace App\Http\Controllers\HR;

use App\Helpers\ContentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Http\Requests\HR\ApplicantRoundRequest;
use App\Mail\HR\Applicant\RoundReviewed;
use App\Models\HR\ApplicantRound;
use App\Models\HR\ApplicationRound;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationRoundController extends Controller
{
    /**
     * Update the specified resource in storage.
     * @param  ApplicantRoundRequest $request
     * @param  ApplicationRound        $round
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicantRoundRequest $request, ApplicationRound $round)
    {
        $validated = $request->validated();

        $round->_update([
            'round_status' => $validated['round_status'],
            'conducted_person_id' => Auth::id(),
            'conducted_date' => Carbon::now(),
        ], $validated['action_type'], $validated['reviews'], $validated['next_round']);

        return redirect()->back()->with('status', 'Application updated successfully!');
    }

    /**
     * Send email to the applicant for current round
     *
     * @param  ApplicantRoundMailRequest $request
     * @param  ApplicationRound            $applicationRound
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail(ApplicantRoundMailRequest $request, ApplicationRound $applicationRound)
    {
        $validated = $request->validated();
        $mail_body = ContentHelper::editorFormat($validated['mail_body']);

        $application = $applicationRound->application;
        $applicant = $application->applicant;

        $applicationRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $mail_body,
            'mail_sender' => Auth::id(),
            'mail_sent_at' => Carbon::now(),
        ]);

        Mail::to($applicant->email, $applicant->name)
            ->bcc($application->job->posted_by)
            ->send(new RoundReviewed($applicationRound));

        return redirect()->back()->with(
            'status',
            "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
            <span data-toggle='modal' data-target='#round_mail_$applicationRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        );
    }
}
