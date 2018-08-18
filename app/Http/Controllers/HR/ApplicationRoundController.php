<?php

namespace App\Http\Controllers\HR;

use App\Helpers\ContentHelper;
use App\Models\HR\Application;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Http\Requests\HR\ApplicationRoundRequest;
use App\Mail\HR\Applicant\RoundReviewed;
use App\Models\HR\ApplicantRound;
use App\Models\HR\ApplicationRound;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Helpers\FileHelper;

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
        $path = self::upload($request->file('offer_letter'));
        
        if (array_key_exists('round_evaluation', $request->validated())) {
            $round->updateOrCreateEvaluation($request->validated()['round_evaluation']);
        }
        return redirect()->back()->with('status', 'Application updated successfully!');
    }

     protected static function upload($file)
    {
        $fileName = $file->getClientOriginalName();

        if ($fileName) {
            return $file->storeAs('offer_letters', $fileName);
        }

        return $file->store('offer_letters');
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
        $applicant = $applicationRound->application->applicant;
        $job = $applicationRound->application->job;

        $mail_body = ContentHelper::editorFormat($validated['mail_body']);
        $mail_body = str_replace(config('constants.hr.template-variables.applicant-name'), $applicant->name, $mail_body);
        $mail_body = str_replace(config('constants.hr.template-variables.job-title'), $job->title, $mail_body);

        $applicationRound->load('application', 'application.job', 'application.applicant');
        $applicationRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $mail_body,
            'mail_sender' => Auth::id(),
            'mail_sent_at' => Carbon::now(),
        ]);

        Mail::send(new RoundReviewed($applicationRound));

        return redirect()->back()->with(
            'status',
            "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
            <span data-toggle='modal' data-target='#round_mail_$applicationRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        );
    }
}
