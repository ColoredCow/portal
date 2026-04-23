<?php

namespace Modules\Project\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Entities\Client;
use Modules\Project\Database\Seeders\ProjectPermissionsTableSeeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ContractPdfAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->artisan('db:seed', ['--class' => ProjectPermissionsTableSeeder::class]);
        Storage::fake('local');
    }

    public function test_guest_is_redirected_to_login()
    {
        $contract = $this->contractWithFile();

        $response = $this->get(route('pdf.show', $contract));

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_without_permission_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = User::factory()->create();
        $this->be($user);
        $contract = $this->contractWithFile();

        $this->get(route('pdf.show', $contract));
    }

    public function test_active_team_member_with_permission_can_download_pdf()
    {
        $user = $this->userWithProjectsView();
        $contract = $this->contractWithFile();
        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $response = $this->get(route('pdf.show', $contract));

        $response->assertOk();
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
    }

    public function test_key_account_manager_can_download_pdf()
    {
        $kam = $this->userWithProjectsView();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $project = Project::factory()->create(['client_id' => $client->id]);

        $file = UploadedFile::fake()->create('contract.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('contracts', $file);
        $contract = ProjectContract::factory()->create([
            'project_id' => $project->id,
            'contract_file_path' => $path,
        ]);

        $this->be($kam);
        $this->get(route('pdf.show', $contract))->assertOk();
    }

    public function test_ended_team_member_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = $this->userWithProjectsView();
        $contract = $this->contractWithFile();
        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::now()->subMonth(),
            'ended_on' => Carbon::yesterday(),
        ]);

        $this->be($user);
        $this->get(route('pdf.show', $contract));
    }

    public function test_numeric_id_guess_returns_404()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ModelNotFoundException::class);

        $user = $this->userWithProjectsView();
        $contract = $this->contractWithFile();
        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $this->get('/projects/contract/pdf/' . $contract->id);
    }

    public function test_unknown_uuid_returns_404()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ModelNotFoundException::class);

        $this->be($this->userWithProjectsView());
        $this->get('/projects/contract/pdf/11111111-1111-1111-1111-111111111111');
    }

    public function test_missing_file_on_disk_returns_404()
    {
        $this->withoutExceptionHandling();
        $this->expectException(NotFoundHttpException::class);

        $user = $this->userWithProjectsView();
        $contract = ProjectContract::factory()->create([
            'contract_file_path' => 'contracts/never-uploaded.pdf',
        ]);
        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $this->get(route('pdf.show', $contract));
    }

    public function test_null_file_path_returns_404()
    {
        $this->withoutExceptionHandling();
        $this->expectException(NotFoundHttpException::class);

        $user = $this->userWithProjectsView();
        $contract = ProjectContract::factory()->create(['contract_file_path' => null]);
        $contract->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $this->get(route('pdf.show', $contract));
    }

    private function userWithProjectsView(): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo('projects.view');

        return $user;
    }

    private function contractWithFile(): ProjectContract
    {
        $file = UploadedFile::fake()->create('contract.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('contracts', $file);

        return ProjectContract::factory()->create(['contract_file_path' => $path]);
    }
}
