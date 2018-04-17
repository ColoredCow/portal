<?php

namespace App\Mail\HR\Applicant;

use App\Models\HR\ApplicantRound;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoundReviewed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The applicantRound instance.
     *
     * @var ApplicantRound
     */
    public $applicantRound;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ApplicantRound $applicantRound)
    {
        $this->applicantRound = $applicantRound;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'))
            ->subject($this->applicantRound->mail_subject)
            ->view('mail.plain')->with([
                'body' => $this->applicantRound->mail_body
            ]);
    }
}
