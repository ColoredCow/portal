<?php

namespace Modules\HR\Emails\Recruitment\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;

class RoundNotConducted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Application instance for which round wasn't conducted.
     *
     * @var Application
     */
    public $application;

    /**
     * Application meta that tracks the details due to which round wasn't conducted.
     *
     * @var ApplicationMeta
     */
    public $applicationMeta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, ApplicationMeta $applicationMeta)
    {
        $this->application = $application;
        $this->applicationMeta = json_decode($applicationMeta->value);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->application->applicant->email, $this->application->applicant->name)
            ->bcc(config('hr.default.name'))
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($this->applicationMeta->mail_subject)
            ->view('mail.plain')->with([
            'body' => $this->applicationMeta->mail_body,
        ]);
    }
}
