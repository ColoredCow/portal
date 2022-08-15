<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\FollowUp;

class HrFollowUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FollowUp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [

            'hr_application_round_id'=> ApplicationRound::factory()->create()->id,
            'checklist'=> $faker->text(),
            'assigned_to' => null,
            'conducted_by' => null,

        ];
    }
}
