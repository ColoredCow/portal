<?php

namespace Modules\HR\Emails\Recruitment\Applicant;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;

class SendFollowUpReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of the application round for which the applicant needs to be reminded.
     * @var Application
     */
    public $application;

    /**
     * Create a new message instance.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = $this->applicationRound->application;
        $job = $application->job;

        $subject = Setting::where('module', 'hr')->where('setting_key', 'Follow_up_email_for_scheduling_interview_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'Follow_up_email_for_scheduling_interview_body')->first();
        $roundName = Round::where('id', $application->latestApplicationRound->hr_application_id)->first();

        $subject = $subject ? $subject->setting_value : '';
        $body = $body ? $body->setting_value : '';

        $body = str_replace(config('hr.template-variables.applicant-name'), $application->applicant->name, $body);
        $body = str_replace(config('hr.template-variables.round-name'), $roundName, $body);

        return $this->to($application->applicant->email, $application->applicant->name)
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($subject)
            ->view('mail.plain')->with([
            'body' => $body,
        ]);
    }
}
