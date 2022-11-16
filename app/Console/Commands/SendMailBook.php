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
    protected $signature = 'sendmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail to all users by runnig this command';

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
