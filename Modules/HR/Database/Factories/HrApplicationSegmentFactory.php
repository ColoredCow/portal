<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationEvaluationSegment;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationSegmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationEvaluationSegment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'application_id' => 2,
            'application_round_id' => 1,
            'evaluation_segment_id' => 2,
            'comments' => $this->faker->text(),
        ];
    }
}
