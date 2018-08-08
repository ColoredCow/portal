<?php

namespace App\Mail\HR\Applicant;

use App\Models\HR\ApplicationRound;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledInterviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of the application round for which the applicant needs to be reminded.
     * @var ApplicationRound
     */
    public $applicationRound;

    /**
     * Create a new message instance.
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

        $body = str_replace(config('constants.hr.template-variables.applicant-name'), ucwords($application->applicant->name), $body);
        $body = str_replace(config('constants.hr.template-variables.interview-time'), date(config('constants.hr.interview-time-format'), strtotime($this->applicationRound->scheduled_date)), $body);
        $body = str_replace(config('constants.hr.template-variables.job-title'), ucwords($job->title), $body);

        return $this->to($application->applicant->email, $application->applicant->name)
            ->from(config('constants.hr.default.email'), config('constants.hr.default.name'))
            ->subject($subject)
            ->view('mail.plain')->with([
            'body' => $body,
        ]);
    }
}
