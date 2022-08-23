<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
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
            'application_round_id'=> ApplicationRound::factory()->create()->id,
            'evaluation_id'=> $this->getEvaluationId()[array_rand($this->getEvaluationId())],
            'option_id'=>  $this->getOptionId()[array_rand($this->getOptionId())],
            'comment'=> $faker->text(),
        ];
    }

    private function getEvaluationId()
    {
        return [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
        ];
    }

    private function getOptionId()
    {
        return [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10'
        ];
    }
}
