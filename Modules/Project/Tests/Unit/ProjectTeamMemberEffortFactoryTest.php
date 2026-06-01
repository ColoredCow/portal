<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Tests\TestCase;

class ProjectTeamMemberEffortFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_effort_with_numeric_hours_in_range()
    {
        $effort = ProjectTeamMemberEffort::factory()->create();

        $this->assertIsNumeric($effort->actual_effort);
        $this->assertGreaterThanOrEqual(6, (int) $effort->actual_effort);
        $this->assertLessThanOrEqual(9, (int) $effort->actual_effort);
    }

    public function test_factory_links_to_a_team_member()
    {
        $effort = ProjectTeamMemberEffort::factory()->create();

        $this->assertNotNull($effort->project_team_member_id);
        $this->assertInstanceOf(ProjectTeamMember::class, $effort->projectTeamMember);
    }
}
