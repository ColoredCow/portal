<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Evaluation\segment;
use Modules\HR\Entities\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationEvaluationSegmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Segment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->getSegmentNames()[array_rand($this->getSegmentNames())],
            'round_id' => Round::first()->id,
        ];
    }
    private function getSegmentNames()
    {
        return [
			'Academic achievements',
			'Experience',
			'Projects',
			'Resume feeling',
			'CodeTrek',
        'Test segment',
        'Telephonic Interview Segment',
        'Pradeep Chandra Sharaf',
    ];
    }
}
