<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Round;
use Modules\HR\Entities\Evaluation\ApplicationEvaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationEvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationEvaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'application_id' => Application::factory()->create()->id,
            'application_round_id'=> Round::first()->id,
            'evaluation_id'=> 2,
            'option_id'=> 1,
            'comment'=> $faker->text(),
        ];
    }
}
