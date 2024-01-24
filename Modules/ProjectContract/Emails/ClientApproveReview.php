<?php

namespace Modules\ProjectContract\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientApproveReview extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('projectcontract.portal-email'))
        ->subject('Updates from client about contract review')
        ->view('projectcontract::client-approve-mail');
    }
}
