<?php
namespace App\Mail;

use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorReport extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $timeOfException;
    public $exception;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Exception $exception, $user, string $timeOfException)
    {
        $this->exception = $exception;
        $this->user = $user;
        $this->timeOfException = $timeOfException;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->to(config('mail.error_address'))
            ->subject('[ERROR REPORT] ' . $this->exception->getMessage())
            ->markdown('mail.error-report');
    }
}
