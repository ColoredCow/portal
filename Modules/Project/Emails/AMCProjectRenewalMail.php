<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AMCProjectRenewalMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $data, $keyAccountManagerEmail, $keyAccountManagerEligibleProject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $keyAccountManagerEmail )
    {
        $this->data = $data;
        $this->keyAccountManagerEmail = $keyAccountManagerEmail;
        $this->build();
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->data);
        $mail = $this->subject('Project Contract Renewed');
        $mail->to($this->keyAccountManagerEmail);
        return $mail->view('project::mail.amc-project-renewal-mail');
    }
}
