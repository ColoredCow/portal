<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SelfReviewMail extends Mailable
{
    use Queueable, SerializesModels;
    public $employeeId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
        $this->build();
        // dd($this->employeeId = $employeeId);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from(config('hr.default.email'))
        ->view('hr::application.self');
    }
}
