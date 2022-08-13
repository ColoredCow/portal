<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Modules\HR\Entities\Evaluation\ApplicationEvaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationEvaluationFactory extends Factory
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
            'application_id'=> 1,
			'application_round_id'=> 2,
			'evaluation_id'=> 2,
			'option_id'=> 1,
			'comment'=> $faker->text(),
        ];
    }
}
