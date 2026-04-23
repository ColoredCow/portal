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
