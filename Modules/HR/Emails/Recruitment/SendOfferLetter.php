<?php

namespace Modules\HR\Emails\Recruitment;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;

class SendOfferLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $body;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, string $subject, string $body)
    {
        $this->application = $application;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->application->applicant->email, $this->application->applicant->name)
            ->from(config('hr.default.email'), config('hr.default.name'))
            ->subject($this->subject)
            ->view('mail.plain')
            ->with([
                'body' => $this->body,
            ])
            ->attach(storage_path('app/' . $this->application->offer_letter));
    }
}
