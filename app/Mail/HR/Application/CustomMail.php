<?php

namespace App\Mail\HR\Application;

use App\Models\HR\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;
    public $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, $mail)
    {
        $this->application = $application;
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->application->applicant->email, $this->application->applicant->name)
            ->bcc($this->application->job->posted_by)
            ->bcc(config('constants.hr.default.email'))
            ->from(config('constants.hr.default.email'), config('constants.hr.default.name'))
            ->subject($this->mail['subject'])
            ->view('mail.plain')->with([
            'body' => $this->mail['body'],
        ]);
    }
}
