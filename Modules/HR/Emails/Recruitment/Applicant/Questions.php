<?php

namespace Modules\HR\Emails\Recruitment\Applicant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Traits\Encryptable;

class Questions extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The mail subject.
     *
     * @var string
     */
    public $subject;

    /**
     * The mail body.
     *
     * @var string
     */
    public $body;

    /**
     * Create new message instance.
     *
     * @return void
     */
    public function __construct($applicantData)
    {
       $this->applicant = $applicantData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('negiabhi03@gmail.com')
            ->to($this->applicant['email'])
            ->subject("Request for Further Details on Your Resume")
            ->view('mail.hr.question-for-applicant')->with(['applicant'=>$this->applicant]);
    }
}
