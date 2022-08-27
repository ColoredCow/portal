<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Round;
use Modules\User\Entities\User;
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
        $application = Application::factory()->create();
        $application->tag($application->status);

        return [
            'hr_application_id' => $application->id,
            'hr_round_id' => Round::first(),
            'scheduled_person_id' => User::first()->id,
            'is_latest' => true,
        ];
    }
}
