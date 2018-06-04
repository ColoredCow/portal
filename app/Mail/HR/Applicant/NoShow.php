<?php

namespace App\Mail\HR\Applicant;

use App\Models\HR\ApplicationMeta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoShow extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Instance of the ApplicationMeta
     * @var ApplicationMeta
     */
    public $applicationMeta;

    /**
     * Create a new message instance.
     * @param ApplicationMeta $applicationMeta [description]
     */
    public function __construct(ApplicationMeta $applicationMeta)
    {
        $this->applicationMeta = $applicationMeta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = $this->applicationMeta->application;

        $applicationMetaValue = json_decode($this->applicationMeta->value);
        $subject = $applicationMetaValue->mail_subject;
        $body = $applicationMetaValue->mail_body;

        return $this->to($application->applicant->email, $application->applicant->name)
            // ->bcc($application->job->posted_by)
            // ->bcc(env('HR_DEFAULT_FROM_EMAIL'))
            ->from(env('HR_DEFAULT_FROM_EMAIL'), env('HR_DEFAULT_FROM_NAME'))
            ->subject($subject)
            ->view('mail.plain')->with([
                'body' => $body
            ]);
    }
}
