<?php

namespace App\Mail\HR\Applicant;

use App\Models\HR\ApplicationRound;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
            ->bcc($application->job->posted_by)
            ->bcc(env('HR_DEFAULT_FROM_EMAIL'))
            ->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'))
            ->subject($this->applicationRound->mail_subject)
            ->view('mail.plain')->with([
                'body' => $this->applicationRound->mail_body
            ]);
    }
}
