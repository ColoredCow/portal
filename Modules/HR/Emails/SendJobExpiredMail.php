<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendJobExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobs_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->jobs_data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'), config('hr.default.name'))
        ->subject('Job end date is expired')
        ->view('emails.send-job-closed-mail', $this->jobs_data->toArray());
    }
}
