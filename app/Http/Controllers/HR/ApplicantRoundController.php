<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Http\Requests\HR\ApplicantRoundRequest;
use App\Mail\HR\Applicant\RoundReviewed;
use App\Models\HR\ApplicantRound;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicantRoundController extends Controller
{

    /**
     * Update the specified resource in storage.
     * @param  ApplicantRoundRequest $request
     * @param  ApplicantRound        $round
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicantRoundRequest $request, ApplicantRound $round)
    {
        $validated = $request->validated();
        $round->_update([
            'round_status' => $validated['round_status'],
            'conducted_person_id' => Auth::id(),
            'conducted_date' => Carbon::now(),
        ], $validated['action_type'], $validated['reviews'], $validated['next_round']);

        return redirect('/hr/applicants/' . $round->applicant->id . '/edit')->with('status', 'Applicant updated successfully!');
    }

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

        $applicantRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $mail_body,
            'mail_sender' => Auth::id(),
            'mail_sent_at' => Carbon::now(),
        ]);

        Mail::to($applicant->email, $applicant->name)
            ->bcc($applicant->job->posted_by)
            ->send(new RoundReviewed($applicantRound));

        return redirect()->back()->with(
            'status',
            "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
            <span data-toggle='modal' data-target='#round_mail_$applicantRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        );
    }
}
