<?php

namespace Modules\Project\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Entities\Client;
use Modules\Project\Database\Seeders\ProjectPermissionsTableSeeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Policies\ProjectContractPolicy;
use Modules\User\Entities\User;
use Tests\TestCase;

class ProjectContractPolicyTest extends TestCase
{
    use RefreshDatabase;

    private ProjectContractPolicy $policy;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->artisan('db:seed', ['--class' => ProjectPermissionsTableSeeder::class]);
        $this->policy = new ProjectContractPolicy();
    }

    public function test_denies_user_without_projects_view_permission()
    {
        $user = User::factory()->create();
        $contract = ProjectContract::factory()->create();

        $this->assertFalse($this->policy->view($user, $contract));
    }

    public function test_denies_user_with_permission_but_no_relationship()
    {
        $user = $this->userWithProjectsView();
        $contract = ProjectContract::factory()->create();

        $this->assertFalse($this->policy->view($user, $contract));
    }

    public function test_allows_active_team_member()
    {
        $user = $this->userWithProjectsView();
        $contract = ProjectContract::factory()->create();

        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->assertTrue($this->policy->view($user, $contract));
    }

    public function test_denies_ended_team_member()
    {
        $user = $this->userWithProjectsView();
        $contract = ProjectContract::factory()->create();

        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::now()->subMonth(),
            'ended_on' => Carbon::yesterday(),
        ]);

        $this->assertFalse($this->policy->view($user->fresh(), $contract->fresh()));
    }

    public function test_allows_client_key_account_manager()
    {
        $kam = $this->userWithProjectsView();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $project = Project::factory()->create(['client_id' => $client->id]);
        $contract = ProjectContract::factory()->create(['project_id' => $project->id]);

        $this->assertTrue($this->policy->view($kam, $contract));
    }

    private function userWithProjectsView(): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo('projects.view');

        return $user;
    }
}
