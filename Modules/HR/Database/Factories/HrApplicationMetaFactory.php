<?php

namespace Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;

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
            'key' => 'form-data',
        ];
    }
}
