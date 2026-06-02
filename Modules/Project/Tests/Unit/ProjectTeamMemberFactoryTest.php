<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\User\Entities\User;
use Tests\TestCase;

class ProjectTeamMemberFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_reuses_an_existing_user_by_default()
    {
        $user = User::factory()->create();

        $member = ProjectTeamMember::factory()->create([
            'project_id' => Project::factory()->create()->id,
        ]);

        $this->assertSame($user->id, $member->team_member_id);
        $this->assertSame(1, User::count(), 'factory must not mint a new user');
    }

    public function test_does_not_create_extra_user_or_project_when_ids_supplied()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $userCount = User::count();
        $projectCount = Project::count();

        $member = ProjectTeamMember::factory()->create([
            'project_id' => $project->id,
            'team_member_id' => $user->id,
        ]);

        $this->assertSame($user->id, $member->team_member_id);
        $this->assertSame($project->id, $member->project_id);
        $this->assertSame($userCount, User::count(), 'no orphan user');
        $this->assertSame($projectCount, Project::count(), 'no orphan project');
    }
}
