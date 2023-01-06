<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Support\Arr;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'status' => Arr::random(['active', 'inactive']),
            'key_account_manager_id' => $this->faker->unique($reset = true)->randomDigitNotNull,
            'created_at' => now(),
            'updated_at' => now(),
            'is_channel_partner' => 0,
            'has_departments' => 0,
        ];
    }
}
