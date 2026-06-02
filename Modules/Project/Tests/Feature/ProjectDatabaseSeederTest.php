<?php

namespace Modules\Project\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Entities\Client;
use Modules\Project\Database\Seeders\ProjectDatabaseSeeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Modules\User\Entities\User;
use Tests\TestCase;

class ProjectDatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_builds_a_connected_graph_from_existing_users()
    {
        User::factory()->count(4)->create();

        (new ProjectDatabaseSeeder())->seedConnectedGraph(2, 2, 2, 3);

        // 2 clients × 2 projects × 2 members × 3 efforts
        $this->assertSame(2, Client::count());
        $this->assertSame(4, Project::count());
        $this->assertSame(8, ProjectTeamMember::count());
        $this->assertSame(24, ProjectTeamMemberEffort::count());
    }

    public function test_graph_has_no_orphans_and_uses_real_users()
    {
        User::factory()->count(4)->create();

        (new ProjectDatabaseSeeder())->seedConnectedGraph(2, 2, 2, 3);

        $this->assertSame(0, Project::whereDoesntHave('client')->count());
        $this->assertSame(
            0,
            ProjectTeamMember::whereNotIn('team_member_id', User::pluck('id'))->count(),
            'every team member must reference a real user'
        );
        // each member has exactly the requested number of effort rows
        ProjectTeamMember::all()->each(function ($member) {
            $this->assertSame(3, $member->projectTeamMemberEffort()->count());
        });
    }
}
