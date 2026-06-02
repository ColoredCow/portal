<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Tests\TestCase;

class EffortModelConsolidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_relationship_reads_efforts_from_the_shared_table()
    {
        $member = ProjectTeamMember::factory()->create();
        ProjectTeamMemberEffort::factory()->create([
            'project_team_member_id' => $member->id,
            'actual_effort' => 7,
        ]);
        ProjectTeamMemberEffort::factory()->create([
            'project_team_member_id' => $member->id,
            'actual_effort' => 8,
        ]);

        $this->assertSame(2, $member->projectTeamMemberEffort()->count());
        $this->assertSame(15, (int) $member->projectTeamMemberEffort()->sum('actual_effort'));
    }

    public function test_singular_model_runs_the_pipeline_sum_query()
    {
        $member = ProjectTeamMember::factory()->create();
        ProjectTeamMemberEffort::factory()->create([
            'project_team_member_id' => $member->id,
            'total_effort_in_effortsheet' => 5,
            'added_on' => now(),
            'created_at' => now(),
        ]);

        $sum = ProjectTeamMemberEffort::whereIn('project_team_member_id', function ($query) use ($member) {
            $query->select('id')
                ->from('project_team_members')
                ->where('project_id', $member->project_id)
                ->whereNull('ended_on');
        })
        ->whereDate('created_at', now()->toDateString())
        ->sum('total_effort_in_effortsheet');

        $this->assertSame(5, (int) $sum);
    }
}
