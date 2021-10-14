<?php

namespace Modules\HR\Database\Factories;

use Carbon\Carbon;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationRoundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationRound::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hr_application_id' => function () {
                return Application::factory()->create()->id;
            },
            'hr_round_id' =>  function () {
                return Round::first()->id;
            }
        ];
    }
}


