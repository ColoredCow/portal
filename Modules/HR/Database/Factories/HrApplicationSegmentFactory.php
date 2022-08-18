<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationEvaluationSegment;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        $hrEvalationSegmentId = Segment::first();

        return [
            'application_id' => Application::factory()->create()->id,
            'application_round_id' => ApplicationRound::factory()->create()->id,
            'evaluation_segment_id' => $hrEvalationSegmentId,
            'comments' => $this->faker->text(),
        ];
    }
}
