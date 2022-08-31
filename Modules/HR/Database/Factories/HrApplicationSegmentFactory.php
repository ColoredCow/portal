<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationEvaluationSegment;
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
        $hrEvaluationSegmentId = Segment::first();

        return [
            'application_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'application_round_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'evaluation_segment_id' => $hrEvaluationSegmentId,
            'comments' => $this->faker->text(),
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
            '8',
            '9',
            '10',
        ];
    }
}
