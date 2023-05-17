<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;

class ClientAddressesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = ClientAddress::class;
    public function definition()
    {
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'country_id' => '1',
        ];
    }
    
}
