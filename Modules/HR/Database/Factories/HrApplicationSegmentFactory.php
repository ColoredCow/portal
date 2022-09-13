<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationEvaluationSegment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Evaluation\Segment;

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
            'application_id' => Application::inRandomOrder()->first()->id,
            'application_round_id' => ApplicationRound::inRandomOrder()->first()->id,
            'evaluation_segment_id' => Segment::inRandomOrder()->first()->id,
            'comments' => $this->faker->text(),
        ];
    }
}
