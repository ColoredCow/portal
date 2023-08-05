<?php

namespace Modules\Project\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\ProjectTeamMembersEffort;

class ProjectTeamMembersEffortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTeamMembersEffort::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_team_member_id' => function () {
                return ProjectTeamMember::factory()->create()->id;
            },
            'actual_effort' => array_rand(config('project.designation')),
            'total_effort_in_effortsheet' => '8',
            'added_on' => Carbon::today()->subDays(11)
        ];
    }
}
