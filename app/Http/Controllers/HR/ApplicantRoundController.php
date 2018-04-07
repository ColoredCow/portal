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

        Mail::raw($validated['mail_body'], function($message) use ($validated, $applicantRound) {
            $message->to($applicantRound->applicant->email)
                    ->subject($validated['mail_subject'])
                    ->from(Auth::user()->email);
        });

        $applicantRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $validated['mail_body'],
            'mail_sender' => Auth::id(),
            'mail_sent_at' => Carbon::now(),
        ]);

        return redirect()->back();
    }
}
