<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationMeta;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Application;

class HrApplicationMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationMeta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hr_application_id' => Application::inRandomOrder()->first()->id,
            'value' => $this->faker->text(),
            'key' => 'form-data'
        ];
    }
}
