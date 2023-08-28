<?php

namespace App\Console\Commands;

use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;

class FakeProdDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:prod_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker::create();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! app()->environment(['local', 'staging', 'UAT'])) {
            return 0;
        }

        $this->fakeClientTablesData();

        return 0;
    }

    private function fakeClientTablesData()
    {
        foreach (Client::all() ?: [] as $client) {
            $client->name = $this->faker->company;
            $client->update();
        }

        foreach (ClientAddress::all() ?: [] as $clientAddress) {
            if ($clientAddress->country->name == 'india') {
                $clientAddress->state = \Faker\Provider\en_IN\Address::state();
                $clientAddress->address = \Faker\Provider\en_IN\Address();
            } else {
                $clientAddress->state = \Faker\Provider\en_AU\Address::state();
            }

            $clientAddress->update();
        }
    }
}
