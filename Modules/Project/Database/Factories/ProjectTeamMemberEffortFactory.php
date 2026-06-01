<?php

namespace Modules\Project\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMemberEffort;

class ProjectTeamMemberEffortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTeamMemberEffort::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $effort = $this->faker->numberBetween(6, 9);

        return [
            'project_team_member_id' => ProjectTeamMember::factory(),
            'actual_effort' => $effort,
            'employee_actual_working_effort' => $effort,
            'total_effort_in_effortsheet' => $effort,
            'total_employee_actual_working_effort' => $effort,
            'added_on' => Carbon::today()->subDay(),
        ];
    }
}
