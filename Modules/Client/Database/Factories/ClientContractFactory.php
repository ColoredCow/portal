<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientContract;

class ClientContractFactory extends Factory
{
    protected $model = ClientContract::class;

    public function definition()
    {
        return [
            'client_id' => function () {
                return Client::factory()->create()->id;
            },
            'contract_file_path' => 'client-contracts/' . $this->faker->uuid . '.pdf',
            'start_date' => now()->subYear(),
            'end_date' => now()->addYear(),
        ];
    }
}
