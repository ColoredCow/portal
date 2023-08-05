<?php

namespace Modules\Project\Database\Factories;

use Carbon\Carbon;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'client_id' => function () {
                return Client::factory()->create()->id;
            },
            'type' => 'monthly-billing',
            'client_project_id' => rand(1, 100),
            'status' => 'active',
            'effort_sheet_url' => $this->faker->url,
            'total_estimated_hours' => 1080,
            'monthly_estimated_hours' => 180,
            'start_date' => Carbon::today()->subDays(11),
            'end_date' => Carbon::today()->addMonth()
        ];
    }
}
