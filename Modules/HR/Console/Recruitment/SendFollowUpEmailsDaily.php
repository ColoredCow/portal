<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\FollowUp;
use Modules\HR\Emails\FollowUpEmail;

class SendFollowUpEmailsDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:send-follow-up-mail-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending a Follow-Up Email to HR';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $followUps = FollowUp::where('follow_up_attempts', '>', 2)->get();

        if ($followUps->isEmpty()) {
            $this->info('No applications require follow-up');

            return 0;
        }

        $emailRecipients = config('hr.follow_up_recipients');
        $data = ['followUps' => $followUps];

        Mail::to($emailRecipients)
            ->send(new FollowUpEmail($data));

        return 0; // Return 0 to indicate successful execution
    }
}
