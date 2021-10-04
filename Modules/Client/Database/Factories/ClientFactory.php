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
            'status' => 'Inactive',
            'key_account_manager_id' => $this->faker->unique($reset = true)->randomDigitNotNull,
            'created_at' => now(),
            'updated_at' => now(),
            'is_channel_partner' => rand(0, 1),
            'has_departments' => rand(0, 1),
            'channel_partner_id' => rand(1, 1000),
            'parent_organisation_id' => rand(1, 1000),
            'country' => 'India',
            'state' => null,
            'phone' => null,
            'address' => $this->faker->address,
            'pincode' => null,
        ];
    }
}
