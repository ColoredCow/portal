<?php

namespace Modules\Client\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Database\Seeders\ClientDatabaseSeeder;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientContract;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use Tests\TestCase;

class ClientContractPdfAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->artisan('db:seed', ['--class' => ClientDatabaseSeeder::class]);
        Storage::fake('local');
    }

    public function test_guest_is_redirected_to_login()
    {
        $contract = $this->contractWithFile();

        $response = $this->get(route('client.pdf.show', $contract));

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_without_permission_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = User::factory()->create();
        $this->be($user);
        $contract = $this->contractWithFile();

        $this->get(route('client.pdf.show', $contract));
    }

    public function test_user_with_permission_but_no_relationship_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = $this->userWithClientsView();
        $this->be($user);
        $contract = $this->contractWithFile();

        $this->get(route('client.pdf.show', $contract));
    }

    public function test_active_team_member_on_clients_project_can_download()
    {
        $user = $this->userWithClientsView();
        [$contract, $project] = $this->clientContractWithProject();
        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $response = $this->get(route('client.pdf.show', $contract->fresh()));

        $response->assertOk();
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
    }

    public function test_key_account_manager_can_download()
    {
        $kam = $this->userWithClientsView();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $file = UploadedFile::fake()->create('contract.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('client-contracts', $file);
        $contract = ClientContract::factory()->create([
            'client_id' => $client->id,
            'contract_file_path' => $path,
        ]);

        $this->be($kam);
        $this->get(route('client.pdf.show', $contract))->assertOk();
    }

    public function test_ended_team_member_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = $this->userWithClientsView();
        [$contract, $project] = $this->clientContractWithProject();
        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::now()->subMonth(),
            'ended_on' => Carbon::yesterday(),
        ]);

        $this->be($user);
        $this->get(route('client.pdf.show', $contract->fresh()));
    }

    public function test_numeric_id_guess_returns_404()
    {
        $user = $this->userWithClientsView();
        [$contract, $project] = $this->clientContractWithProject();
        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $this->get('/client/contract/pdf/' . $contract->id)->assertNotFound();
    }

    public function test_unknown_uuid_returns_404()
    {
        $this->be($this->userWithClientsView());
        $this->get('/client/contract/pdf/11111111-1111-1111-1111-111111111111')
            ->assertNotFound();
    }

    public function test_null_file_path_returns_404_and_logs_warning()
    {
        $user = $this->userWithClientsView();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);
        $contract = ClientContract::factory()->create([
            'client_id' => $client->id,
            'contract_file_path' => null,
        ]);

        Log::spy();
        $this->be($user);
        $this->get(route('client.pdf.show', $contract->fresh()))->assertNotFound();

        Log::shouldHaveReceived('warning')->withArgs(function ($message, $context) use ($contract) {
            return $message === 'client contract pdf missing'
                && ($context['contract_uuid'] ?? null) === $contract->uuid;
        });
    }

    public function test_missing_file_on_disk_returns_404_and_logs_warning()
    {
        $user = $this->userWithClientsView();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);
        $contract = ClientContract::factory()->create([
            'client_id' => $client->id,
            'contract_file_path' => 'client-contracts/never-uploaded.pdf',
        ]);

        Log::spy();
        $this->be($user);
        $this->get(route('client.pdf.show', $contract->fresh()))->assertNotFound();

        Log::shouldHaveReceived('warning')->withArgs(function ($message, $context) {
            return $message === 'client contract pdf missing'
                && ($context['path'] ?? null) === 'client-contracts/never-uploaded.pdf';
        });
    }

    public function test_policy_denial_logs_notice()
    {
        $this->withoutExceptionHandling();

        $user = $this->userWithClientsView();
        $contract = $this->contractWithFile();

        Log::spy();
        $this->be($user);

        try {
            $this->get(route('client.pdf.show', $contract));
        } catch (AuthorizationException $e) {
            // expected
        }

        Log::shouldHaveReceived('notice')->withArgs(function ($message, $context) use ($contract, $user) {
            return $message === 'client contract pdf access denied'
                && ($context['contract_uuid'] ?? null) === $contract->uuid
                && ($context['user_id'] ?? null) === $user->id;
        });
    }

    private function userWithClientsView(): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo('clients.view');

        return $user;
    }

    private function contractWithFile(): ClientContract
    {
        $file = UploadedFile::fake()->create('contract.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('client-contracts', $file);

        return ClientContract::factory()->create(['contract_file_path' => $path]);
    }

    /** @return array{ClientContract, Project} */
    private function clientContractWithProject(): array
    {
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $file = UploadedFile::fake()->create('contract.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('client-contracts', $file);
        $contract = ClientContract::factory()->create([
            'client_id' => $client->id,
            'contract_file_path' => $path,
        ]);

        return [$contract, $project];
    }
}
