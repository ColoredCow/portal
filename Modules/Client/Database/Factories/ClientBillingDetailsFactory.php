<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientBillingDetail;

class ClientBillingDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = ClientBillingDetail::class;
    public function definition()
    {
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'currency' => 'INR',
        ];
    }
}
