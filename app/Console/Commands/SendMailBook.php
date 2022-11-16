<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BookServices;

class SendMailBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'sendmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $message = 'send mail to all users who had not comments on books even they have read';

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
        $service = app(BookServices::class);
        $BookDetails = $service->SendMailUncommentedUsers();

        return $this->$BookDetails;
    }
}
