<?php

namespace App\Mail\HR;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\HR\Application;

class SendOfferLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $subject;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, $mail_data)
    {
        $this->application = $application;
        $this->subject = $mail_data['subject'];
        $this->body = $mail_data['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->to($this->application->applicant->email, $this->application->applicant->name)
            ->from(config('constants.hr.default.email'), config('constants.hr.default.name'))
            ->subject(config('app.name') .  – $this->subject)
            ->view('mail.plain')
            ->with([
                'body' => $this->body,
            ]);
    }
}
