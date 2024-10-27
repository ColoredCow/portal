<?php
namespace Modules\HR\Emails\Recruitment\Applicant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\ApplicationMeta;

class NoShow extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of the ApplicationMeta.
     *
     * @var ApplicationMeta
     */
    public $applicationMeta;

    /**
     * Create a new message instance.
     *
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
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($subject)
            ->view('mail.plain')->with([
                'body' => $body,
            ]);
    }
}
