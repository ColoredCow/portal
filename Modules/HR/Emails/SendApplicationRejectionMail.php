<?php

namespace Modules\HR\Emails;

use Dotenv\Util\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Applicant;

class SendApplicationRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $jobTitle;
    public $interviewLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $id, string $title, string $link)
    {
        $this->applicant = Applicant::find($id);
        $this->jobTitle = $title;
        $this->interviewLink = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'))
            ->to($this->applicant->email)
            ->subject('Application Rejected')
            ->view('emails.send-application-rejection-mail')
            ->with([
                'applicant' => $this->applicant,
                $this->jobTitle,
                $this->interviewLink,
            ]);
    }
}
