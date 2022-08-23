<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrResourcesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'resource_link'=> $this->faker->url,
            'hr_resource_category_id'=> 2,
            'job_id'=> 1,

        ];
    }
}
