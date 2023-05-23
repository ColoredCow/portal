<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendJobExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobsData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->jobsData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'), config('hr.default.name'))
        ->subject('You have expired Jobs opening.')
        ->view('emails.send-job-expired-mail', $this->jobsData->toArray());
    }
}
