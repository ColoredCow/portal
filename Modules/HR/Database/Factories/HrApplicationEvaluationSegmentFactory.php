<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Evaluation\segment;
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
            'name' => $this->faker->name,
            'round_id' => 1,
        ];
    }
}
