<?php
namespace Modules\HR\Emails\Recruitment\Applicant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\ApplicationRound;

class RoundReviewed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The ApplicationRound instance.
     *
     * @var ApplicationRound
     */
    public $applicationRound;

    /**
     * Create a new message instance.
     *
     * @return void
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

        return $this->to($application->applicant->email, $application->applicant->name)
            ->bcc($application->job->postedBy->email)
            ->bcc(config('hr.default.email'))
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($this->applicationRound->mail_subject)
            ->view('mail.plain')->with([
            'body' => $this->applicationRound->mail_body,
        ]);
    }
}
