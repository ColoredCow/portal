<?php

namespace Modules\HR\Database\Factories;

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
        return [
            'application_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'application_round_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'evaluation_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'option_id'=> $this->getRandomId()[array_rand($this->getRandomId())],
        ];
    }
    private function getRandomId()
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
}
