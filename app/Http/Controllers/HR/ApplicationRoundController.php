<?php

namespace App\Http\Controllers\HR;

use App\Helpers\ContentHelper;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Http\Requests\HR\ApplicationRoundRequest;
use App\Mail\HR\Applicant\RoundReviewed;
use App\Mail\HR\SendForApproval;
use App\Mail\HR\SendOfferLetter;
use App\Models\HR\ApplicantRound;
use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\User;
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
        $validated = $request->validated();
        $application = $round->application;
        $applicant = $round->application->applicant;
        switch ($validated['action']) {
            case 'schedule-update':
                $attr = [
                    'scheduled_date' => $validated['scheduled_date'],
                    'scheduled_person_id' => $validated['scheduled_person_id'],
                ];
                $round->updateSchedule($attr, $application);
                $attr['reviews'] = [];
                break;

            case 'confirm':
                $round->comfirm();
                $application->markInProgress();
                $nextApplicationRound = $application->job->rounds->where('id', $validated['next_round'])->first();
                $scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id ?? config('constants.hr.defaults.scheduled_person_id');
                $applicationRound = ApplicationRound::create([
                    'hr_application_id' => $application->id,
                    'hr_round_id' => $validated['next_round'],
                    'scheduled_date' => $validated['next_scheduled_start'],
                    'scheduled_end' => isset($validated['next_scheduled_end']) ? $validated['next_scheduled_end'] : null,
                    'scheduled_person_id' => $validated['next_scheduled_person_id'],
                ]);
                break;

            case 'reject':
                $round->reject();
                foreach ($applicant->applications as $applicantApplication) {
                    $applicantApplication->reject();
                }
                break;

            case 'refer':
                $round->reject();
                $application->reject();
                $applicant->applications->where('id', $validated['refer_to'])->first()->markInProgress();
                break;

            case 'send-for-approval':
                $round->comfirm();
                $application->sendForApproval($validated['send_for_approval_person']);
                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'sent-for-approval',
                    'value' => json_encode([
                        'conducted_person_id' => Auth::id(),
                        'supervisor_id' => $validated['send_for_approval_person'],
                    ]),
                ]);
                $supervisor = User::find($validated['send_for_approval_person']);
                Mail::send(new SendForApproval($supervisor, $application));
                break;

            case 'approve':
                $round->approve();
                $application->approve();
                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'approved',
                    'value' => json_encode([
                        'approved_by' => Auth::id(),
                    ]),
                ]);

                $subject = $validated['subject'];
                $body = $validated['body'];

                if (!$application->offer_letter) {
                    $application->offer_letter = FileHelper::generateOfferLetter($application);
                }
                Mail::send(new SendOfferLetter($application, $subject, $body));
                break;

            case 'onboard':
                $round->confirm();
                $application->onboarded();

                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'onboarded',
                    'value' => json_encode([
                        'onboarded_by' => $round['conducted_person_id'],
                    ]),
                ]);

                // The below env call needs to be changed to config after the default
                // credentials bug in the Google API services is resolved.
                $email = $attr['onboard_email'] . '@' . env('GOOGLE_CLIENT_HD');
                $applicant->onboard($email, $attr['onboard_password'], [
                    'designation' => $attr['designation'],
                ]);

                User::create([
                    'email' => $email,
                    'name' => $applicant->name,
                    'password' => Hash::make($attr['onboard_password']),
                    'provider' => 'google',
                    'provider_id' => '',
                ]);
                break;
        }
        $round->update([
            'conducted_person_id' => Auth::id(),
            'conducted_date' => Carbon::now(),
        ]);
       $round->_updateOrCreateReviews($validated['reviews']);

        if (array_key_exists('round_evaluation', $request->validated())) {
            $round->updateOrCreateEvaluation($validated['round_evaluation']);
        }
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
