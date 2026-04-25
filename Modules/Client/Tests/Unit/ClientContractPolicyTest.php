<?php

namespace Modules\Client\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Database\Seeders\ClientDatabaseSeeder;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientContract;
use Modules\Client\Policies\ClientContractPolicy;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use Tests\TestCase;

class ClientContractPolicyTest extends TestCase
{
    use RefreshDatabase;

    private ClientContractPolicy $policy;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->artisan('db:seed', ['--class' => ClientDatabaseSeeder::class]);
        $this->policy = new ClientContractPolicy();
    }

    public function test_denies_user_without_clients_view_permission()
    {
        $user = User::factory()->create();
        $contract = ClientContract::factory()->create();

        $this->assertFalse($this->policy->view($user, $contract));
    }

    public function test_denies_user_with_permission_but_no_relationship()
    {
        $user = $this->userWithClientsView();
        $contract = ClientContract::factory()->create();

        $this->assertFalse($this->policy->view($user, $contract));
    }

    public function test_allows_active_team_member_on_any_of_clients_projects()
    {
        $user = $this->userWithClientsView();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $contract = ClientContract::factory()->create(['client_id' => $client->id]);

        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->assertTrue($this->policy->view($user->fresh(), $contract->fresh()));
    }

    public function test_denies_ended_team_member()
    {
        $user = $this->userWithClientsView();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $contract = ClientContract::factory()->create(['client_id' => $client->id]);

        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::now()->subMonth(),
            'ended_on' => Carbon::yesterday(),
        ]);

        $this->assertFalse($this->policy->view($user->fresh(), $contract->fresh()));
    }

    public function test_allows_client_key_account_manager()
    {
        $kam = $this->userWithClientsView();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $contract = ClientContract::factory()->create(['client_id' => $client->id]);

        $this->assertTrue($this->policy->view($kam, $contract));
    }

    public function test_denies_when_client_relation_is_missing()
    {
        $user = $this->userWithClientsView();
        $client = Client::factory()->create();
        $contract = ClientContract::factory()->create(['client_id' => $client->id]);

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $client->delete();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->assertFalse($this->policy->view($user, $contract->fresh()));
    }

    private function userWithClientsView(): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo('clients.view');

        return $user;
    }
}
