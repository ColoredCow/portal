<?php

namespace Modules\Project\Database\Factories;

use Carbon\Carbon;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\User\Entities\User;
use Modules\HR\Entities\HrJobDesignation;

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
        return [
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'team_member_id' => function () {
                return User::factory()->create()->id;
            },
            'designation' => array_rand(config('project.designation')), 
            'designation_id' =>  HrJobDesignation::where('designation', array_rand(config('project.designation')))->value('id'),
            'daily_expected_effort' => '8',
            'started_on' => Carbon::today()->subDays(10)
        ];
    }
}
