<?php

namespace Modules\HR\Emails\Recruitment\Applicant;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Round;

class SendFollowUpReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of the application round for which the applicant needs to be reminded.
     * @var Application
     */
    public $application;
    public $tag;

    /**
     * Create a new message instance.
     * @param Application $application
     */
    public function __construct(Application $application, $tag)
    {
        $this->application = $application;
        $this->tag = $tag;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = $this->application;

        $subject = Setting::where('module', 'hr')->where('setting_key', 'Follow_up_email_for_scheduling_interview_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'Follow_up_email_for_scheduling_interview_body')->first();
        $roundName = Round::select('*')->where('id', $application->latestApplicationRound->hr_application_id)->first()->name;

        $subject = $subject ? $subject->setting_value : '';
        $body = $body ? $body->setting_value : '';

        $body = str_replace(config('hr.template-variables.applicant-name'), $application->applicant->name, $body);
        $body = str_replace(config('hr.template-variables.round-name'), $roundName, $body);

        if ($this->tag->slug == 'need-follow-up') {
            return $this->to($application->applicant->email, $application->applicant->name)
                ->from(config('hr.default.email'), config('hr.default.name'))
                ->subject($subject)
                ->view('mail.plain')->with([
                'body' => $body,
            ]);
        }
    }
}
