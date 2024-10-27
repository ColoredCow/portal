<?php

namespace Modules\HR\Emails\Recruitment\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;

class JobChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Application instance for which job has changed.
     *
     * @var Application
     */
    public $application;

    /**
     * Application meta that tracks the job change details.
     *
     * @var ApplicationMeta
     */
    public $changeJobMeta;

    /**
     * Create a new message instance.
     *
     * @param Application $application
     * @param ApplicationMeta $changeJobMeta
     */
    public function __construct(Application $application, ApplicationMeta $changeJobMeta)
    {
        $this->application = $application;
        $this->changeJobMeta = json_decode($changeJobMeta->value);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->application->applicant->email, $this->application->applicant->name)
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($this->changeJobMeta->job_change_mail_subject)
            ->view('mail.plain')->with([
            'body' => $this->changeJobMeta->job_change_mail_body,
        ]);
    }
}
