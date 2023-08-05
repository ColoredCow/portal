<?php

namespace Modules\Project\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\User\Entities\User;

class ProjectTeamMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTeamMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userId = User::factory()->create()->id;

        return [
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'team_member_id' => $userId,
            'designation' => array_rand(config('project.designation')),
            'daily_expected_effort' => '8',
            'started_on' => Carbon::today()->subDays(10)
        ];
    }
}
