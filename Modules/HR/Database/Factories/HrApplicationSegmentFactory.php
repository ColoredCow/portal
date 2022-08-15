<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationEvaluationSegment;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Round;
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
            'application_id' => Application::factory()->create()->id,
            'application_round_id' => Round::first()->id,
            'evaluation_segment_id' => 2,
            'comments' => $this->faker->text(),
        ];
    }
}
