<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Entities\Client;

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
            'name' => $this->faker->name,
            'status' => 'inactive',
            'key_account_manager_id' => $this->faker->unique($reset = true)->randomDigitNotNull,
            'created_at' => now(),
            'updated_at' => now(),
            'is_channel_partner' => 0,
            'has_departments' => 0,
        ];
    }
}
