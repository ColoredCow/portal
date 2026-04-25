<?php

namespace Modules\Project\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Entities\Client;
use Modules\Project\Database\Seeders\ProjectPermissionsTableSeeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DeliveryReportAccessTest extends TestCase
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
        $term = $this->termWithFile();

        $this->get(route('delivery-report.show', $term))->assertRedirect('/login');
    }

    public function test_authenticated_user_without_permission_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = User::factory()->create();
        $this->be($user);
        $term = $this->termWithFile();

        $this->get(route('delivery-report.show', $term));
    }

    public function test_user_with_permission_but_no_relationship_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = $this->userWithProjectsView();
        $this->be($user);
        $term = $this->unrelatedTermWithFile();

        $this->get(route('delivery-report.show', $term));
    }

    public function test_user_with_finance_reports_view_permission_can_download()
    {
        $user = $this->userWithProjectsView();
        Permission::findOrCreate('finance_reports.view');
        $user->givePermissionTo('finance_reports.view');

        $term = $this->unrelatedTermWithFile();

        $this->be($user);
        $this->get(route('delivery-report.show', $term))->assertOk();
    }

    public function test_active_team_member_can_download()
    {
        $user = $this->userWithProjectsView();
        $term = $this->termWithFile();
        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $response = $this->get(route('delivery-report.show', $term->fresh()));

        $response->assertOk();
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
    }

    public function test_key_account_manager_can_download()
    {
        $kam = $this->userWithProjectsView();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $project = Project::factory()->create(['client_id' => $client->id]);
        $file = UploadedFile::fake()->create('report.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('delivery_report', $file);
        $term = ProjectInvoiceTerm::factory()->create([
            'project_id' => $project->id,
            'delivery_report' => $path,
        ]);

        $this->be($kam);
        $this->get(route('delivery-report.show', $term))->assertOk();
    }

    public function test_ended_team_member_is_forbidden()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $user = $this->userWithProjectsView();
        $term = $this->termWithFile();
        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::now()->subMonth(),
            'ended_on' => Carbon::yesterday(),
        ]);

        $this->be($user);
        $this->get(route('delivery-report.show', $term->fresh()));
    }

    public function test_numeric_id_guess_returns_404()
    {
        $user = $this->userWithProjectsView();
        $term = $this->termWithFile();
        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->be($user);
        $this->get('/projects/delivery-report/' . $term->id)->assertNotFound();
    }

    public function test_unknown_uuid_returns_404()
    {
        $this->be($this->userWithProjectsView());
        $this->get('/projects/delivery-report/22222222-2222-2222-2222-222222222222')
            ->assertNotFound();
    }

    public function test_null_delivery_report_returns_404_and_logs_warning()
    {
        $user = $this->userWithProjectsView();
        $term = ProjectInvoiceTerm::factory()->create(['delivery_report' => null]);
        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        Log::spy();
        $this->be($user);
        $this->get(route('delivery-report.show', $term->fresh()))->assertNotFound();

        Log::shouldHaveReceived('warning')->withArgs(function ($message, $context) use ($term) {
            return $message === 'delivery report missing'
                && ($context['invoice_term_uuid'] ?? null) === $term->uuid;
        });
    }

    public function test_missing_file_on_disk_returns_404_and_logs_warning()
    {
        $user = $this->userWithProjectsView();
        $term = ProjectInvoiceTerm::factory()->create([
            'delivery_report' => 'delivery_report/never-uploaded.pdf',
        ]);
        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        Log::spy();
        $this->be($user);
        $this->get(route('delivery-report.show', $term->fresh()))->assertNotFound();

        Log::shouldHaveReceived('warning')->withArgs(function ($message, $context) {
            return $message === 'delivery report missing'
                && ($context['path'] ?? null) === 'delivery_report/never-uploaded.pdf';
        });
    }

    public function test_policy_denial_logs_notice()
    {
        $this->withoutExceptionHandling();

        $user = $this->userWithProjectsView();
        $term = $this->unrelatedTermWithFile();

        Log::spy();
        $this->be($user);

        try {
            $this->get(route('delivery-report.show', $term));
        } catch (AuthorizationException $e) {
            // expected
        }

        Log::shouldHaveReceived('notice')->withArgs(function ($message, $context) use ($term, $user) {
            return $message === 'delivery report access denied'
                && ($context['invoice_term_uuid'] ?? null) === $term->uuid
                && ($context['user_id'] ?? null) === $user->id;
        });
    }

    public function test_super_admin_can_download_without_relationship()
    {
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);
        $admin = User::factory()->create();
        $admin->assignRole($superAdminRole);

        $term = $this->termWithFile();

        $this->be($admin);
        $this->get(route('delivery-report.show', $term))->assertOk();
    }

    private function userWithProjectsView(): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo('projects.view');

        return $user;
    }

    private function termWithFile(): ProjectInvoiceTerm
    {
        $file = UploadedFile::fake()->create('report.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('delivery_report', $file);

        return ProjectInvoiceTerm::factory()->create(['delivery_report' => $path]);
    }

    private function unrelatedTermWithFile(): ProjectInvoiceTerm
    {
        $client = Client::factory()->create([
            'key_account_manager_id' => User::factory()->create()->id,
        ]);
        $project = Project::factory()->create(['client_id' => $client->id]);
        $file = UploadedFile::fake()->create('report.pdf', 10, 'application/pdf');
        $path = Storage::disk('local')->putFile('delivery_report', $file);

        return ProjectInvoiceTerm::factory()->create([
            'project_id' => $project->id,
            'delivery_report' => $path,
        ]);
    }
}
