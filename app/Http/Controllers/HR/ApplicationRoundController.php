<?php

namespace App\Http\Controllers\HR;

use App\Helpers\ContentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Http\Requests\HR\ApplicationRoundRequest;
use App\Mail\HR\Applicant\RoundReviewed;
use App\Models\HR\ApplicantRound;
use App\Models\HR\ApplicationRound;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationRoundController extends Controller
{
    /**
     * Update the specified resource in storage.
     * @param  ApplicationRoundRequest $request
     * @param  ApplicationRound        $round
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRoundRequest $request, ApplicationRound $round)
    {
        $round->_update($request->validated());
        return redirect('/hr/applications/' . $round->application->id . '/edit')->with('status', 'Application updated successfully!');
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
