<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Models\HR\ApplicantRound;
use Illuminate\Support\Facades\Auth;

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

        // send the mail to the applicant.

        $applicantRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $validated['mail_body'],
            'mail_sender' => Auth::id(),
        ]);

        return redirect()->back();
    }
}
