<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Evaluation\ApplicationEvaluation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Evaluation\Parameter;
use Modules\HR\Entities\Evaluation\ParameterOption;

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
            'application_id' => Application::inRandomOrder()->first()->id,
            'application_round_id' => ApplicationRound::inRandomOrder()->first()->id,
            'evaluation_id' => Parameter::inRandomOrder()->first()->id,
            'option_id'=> ParameterOption::inRandomOrder()->first()->id,
        ];
    }
}
