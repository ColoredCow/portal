<?php
namespace App\Mail;

use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ErrorReport extends Mailable
{
    use Queueable, SerializesModels;
    public $userDetails;
    public $timeOfException;
    public $exception;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Exception $exception, string $timeOfException)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userDetails = [
                "name" => $user->name,
                "email" => $user->email,
            ];
        } else {
            $userDetails = [
                "name" => 'System Generated',
                "email" => '',
            ];
        }
        $this->exception = $exception;
        $this->userDetails = $userDetails;
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
