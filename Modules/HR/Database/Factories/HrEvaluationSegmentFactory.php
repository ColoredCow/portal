<?php

namespace Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Entities\Round;

class HrEvaluationSegmentFactory extends Factory
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
        Round::factory()->create();

        return [
            'round_id' => Round::inRandomOrder()->first()->id,
            'name' => $this->faker->sentence(),
        ];
    }
}
