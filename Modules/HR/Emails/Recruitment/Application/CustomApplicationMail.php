<?php

namespace Modules\HR\Emails\Recruitment\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;

class CustomApplicationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;
    public $mailSubject;
    public $mailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, $mailSubject, $mailBody)
    {
        $this->application = $application->load('applicant', 'job');
        $this->mailSubject = $mailSubject;
        $this->mailBody = $mailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->application->applicant->email, $this->application->applicant->name)
            ->bcc(config('hr.default.email'))
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($this->mailSubject)
            ->view('mail.plain')->with([
            'body' => $this->mailBody,
        ]);
    }
}
