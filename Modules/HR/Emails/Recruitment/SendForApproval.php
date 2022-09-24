<?php

namespace Modules\HR\Emails\Recruitment;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\User;
use App\Models\Setting;
use Modules\HR\Entities\Application;

class SendForApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $approver;
    public $application;

    /**
     * Create a new message instance.
     *
     * @param User $approver
     */
    public function __construct(User $approver, Application $application)
    {
        $this->approver = $approver;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application_link = route('hr.applicant.details.show', [$this->application->id]);
        $subject = Setting::where('module', 'hr')->where('setting_key', 'send_for_approval_subject')->first()->setting_value;
        $body = Setting::where('module', 'hr')->where('setting_key', 'send_for_approval_body')->first()->setting_value;
        $body = str_replace('|APPLICANT NAME|', $this->application->applicant->name, $body);
        $body = str_replace('|JOB TITLE|', $this->application->job->title, $body);
        $body = str_replace('|ASSIGNEE NAME|', $this->approver->name, $body);
        $body = str_replace('|APPLICATION TYPE|', $this->application->job->type, $body);
        $body = str_replace('|APPLICATION LINK|', $application_link, $body);

        return $this->to($this->approver->email, $this->approver->name)
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($subject)
            ->view('mail.plain')->with([
                'body' => $body
        ]);
    }
}
