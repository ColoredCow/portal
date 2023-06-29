<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $followUps;

    /**
     * Create a new message instance.
     *
     * @param  array  $followUps
     * @return void
     */
    public function __construct(array $followUps)
    {
        $this->followUps = $followUps;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('hr::application.follow_up')
            ->subject('Follow-up Required for Applications.')
            ->with(['followUps' => $this->followUps]);
    }
}
