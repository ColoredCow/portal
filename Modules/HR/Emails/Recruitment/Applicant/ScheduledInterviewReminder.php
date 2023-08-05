<?php

namespace Modules\HR\Emails\Recruitment\Applicant;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\ApplicationRound;

class ScheduledInterviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of the application round for which the applicant needs to be reminded.
     *
     * @var ApplicationRound
     */
    public $applicationRound;

    /**
     * Create a new message instance.
     *
     * @param ApplicationRound $applicationRound
     */
    public function __construct(ApplicationRound $applicationRound)
    {
        $this->applicationRound = $applicationRound;
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

        $subject = Setting::where('module', 'hr')->where('setting_key', 'applicant_interview_reminder_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'applicant_interview_reminder_body')->first();

        $subject = $subject ? $subject->setting_value : '';
        $body = $body ? $body->setting_value : '';

        $body = str_replace(config('hr.template-variables.applicant-name'), $application->applicant->name, $body);
        $body = str_replace(
            config('hr.template-variables.interview-time'),
            $this->applicationRound->scheduled_date->format(config('hr.interview-time-format')),
            $body
        );
        $body = str_replace(config('hr.template-variables.job-title'), "<a href='{$job->link}'>{$job->title}</a>", $body);

        return $this->to($application->applicant->email, $application->applicant->name)
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($subject)
            ->view('mail.plain')->with([
            'body' => $body,
        ]);
    }
}
