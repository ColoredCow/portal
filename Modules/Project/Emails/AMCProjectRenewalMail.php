<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AMCProjectRenewalMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        
        $mail->to('email');


        

        return $mail->view('project::mail.amc-project-renewal-mail');
    }
}
