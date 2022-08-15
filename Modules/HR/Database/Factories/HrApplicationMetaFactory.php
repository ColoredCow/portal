<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'hr_application_id'=>  Application::factory()->create()->id,
            'value'=> 1,
            'key'=> 2,
        ];
    }
}
