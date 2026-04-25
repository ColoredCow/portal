# Contract PDF Permissions Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix IDOR on `GET /projects/contract/pdf/{id}` by (a) replacing the numeric route key with a UUID and (b) enforcing a `ProjectContractPolicy` that requires the `projects.view` permission together with active team membership on the project or KAM ownership of the project's client.

**Architecture:** Add a `uuid` column to `project_contracts`, expose it as the route key via `getRouteKeyName`, auto-generate UUIDs on model create, add a policy, register it in the module's auth service provider, and convert `ProjectController::showPdf` from a `public static` method to an instance method that calls `$this->authorize('view', $contract)` and streams the file via `Storage::disk('local')->response(...)`.

**Tech Stack:** Laravel 8, PHP 7.4+, MySQL 5.7, `nwidart/laravel-modules`, `spatie/laravel-permission`, `doctrine/dbal` (already present for `->change()`), PHPUnit, `Storage::fake` for tests.

**Spec:** `docs/superpowers/specs/2026-04-23-contract-pdf-permissions-design.md`

---

## File Structure

**Create:**

- `Modules/Project/Database/Factories/ProjectContractFactory.php` — factory for contract rows in tests.
- `Modules/Project/Database/Migrations/2026_04_23_000001_add_uuid_to_project_contracts_table.php` — nullable `uuid` column + backfill.
- `Modules/Project/Database/Migrations/2026_04_23_000002_make_uuid_not_null_on_project_contracts_table.php` — tighten to NOT NULL.
- `Modules/Project/Policies/ProjectContractPolicy.php` — access rule.
- `Modules/Project/Tests/Unit/ProjectContractPolicyTest.php` — policy matrix.
- `Modules/Project/Tests/Feature/ContractPdfAccessTest.php` — end-to-end route checks.

**Modify:**

- `Modules/Project/Entities/ProjectContract.php` — add `uuid` to `$fillable`, `booted()` UUID generator, `getRouteKeyName()`.
- `Modules/Project/Providers/ProjectAuthServiceProvider.php` — map `ProjectContract` → `ProjectContractPolicy`.
- `Modules/Project/Http/Controllers/ProjectController.php` — make `showPdf` non-static, authorize, stream via `Storage::disk('local')->response(...)`, log + 404 on missing file.

**No blade changes.** `route('pdf.show', $contract)` continues to work and emits the UUID once `getRouteKeyName` is set.

---

## Task 1: Add ProjectContractFactory

**Files:**
- Create: `Modules/Project/Database/Factories/ProjectContractFactory.php`

Needed before any test can instantiate a `ProjectContract`. Follows existing `ProjectFactory` pattern.

- [ ] **Step 1: Confirm the model uses `HasFactory`**

Run:
```bash
grep -n "HasFactory\|use Illuminate" Modules/Project/Entities/ProjectContract.php
```

If `HasFactory` is not present, add it while editing the model in Task 3 (noted there). Do not add the trait in this task.

- [ ] **Step 2: Create the factory file**

Write `Modules/Project/Database/Factories/ProjectContractFactory.php`:

```php
<?php

namespace Modules\Project\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;

class ProjectContractFactory extends Factory
{
    protected $model = ProjectContract::class;

    public function definition()
    {
        return [
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'contract_file_path' => 'contracts/' . $this->faker->uuid . '.pdf',
        ];
    }
}
```

- [ ] **Step 3: Commit**

```bash
git add Modules/Project/Database/Factories/ProjectContractFactory.php
git commit -m "feat(project): add ProjectContractFactory for tests"
```

---

## Task 2: Migration A — add nullable uuid column and backfill

**Files:**
- Create: `Modules/Project/Database/Migrations/2026_04_23_000001_add_uuid_to_project_contracts_table.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddUuidToProjectContractsTable extends Migration
{
    public function up()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        DB::table('project_contracts')
            ->whereNull('uuid')
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('project_contracts')
                        ->where('id', $row->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });
    }

    public function down()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
}
```

Note: we use `DB::table(...)` rather than the Eloquent model so the migration works even before Task 3 adds model boot logic, and so running the migration in isolation doesn't trigger the auto-generator twice.

- [ ] **Step 2: Run the migration against the test DB**

Run:
```bash
php artisan migrate --env=testing
```

Expected: `Migrated: 2026_04_23_000001_add_uuid_to_project_contracts_table`.

- [ ] **Step 3: Verify schema and backfill**

Run:
```bash
php artisan tinker --env=testing --execute="echo Schema::hasColumn('project_contracts','uuid') ? 'yes' : 'no';"
```

Expected output: `yes`.

Run (in a local DB if you have rows; skip if empty):
```bash
php artisan tinker --execute="echo DB::table('project_contracts')->whereNull('uuid')->count();"
```

Expected: `0`.

- [ ] **Step 4: Rollback test**

Run:
```bash
php artisan migrate:rollback --env=testing --step=1
php artisan migrate --env=testing
```

Expected: rollback succeeds (column dropped), then re-migrate succeeds.

- [ ] **Step 5: Commit**

```bash
git add Modules/Project/Database/Migrations/2026_04_23_000001_add_uuid_to_project_contracts_table.php
git commit -m "feat(project): add uuid column to project_contracts with backfill"
```

---

## Task 3: Update `ProjectContract` model (uuid generation, route key, factory trait)

**Files:**
- Modify: `Modules/Project/Entities/ProjectContract.php`
- Create: `Modules/Project/Tests/Unit/ProjectContractModelTest.php`

- [ ] **Step 1: Write failing unit tests**

Create `Modules/Project/Tests/Unit/ProjectContractModelTest.php`:

```php
<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\ProjectContract;
use Tests\TestCase;

class ProjectContractModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_auto_generated_on_create()
    {
        $contract = ProjectContract::factory()->create();

        $this->assertNotNull($contract->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $contract->uuid
        );
    }

    public function test_uuids_are_unique_per_row()
    {
        $a = ProjectContract::factory()->create();
        $b = ProjectContract::factory()->create();

        $this->assertNotSame($a->uuid, $b->uuid);
    }

    public function test_explicit_uuid_is_not_overwritten()
    {
        $uuid = '11111111-1111-1111-1111-111111111111';
        $contract = ProjectContract::factory()->create(['uuid' => $uuid]);

        $this->assertSame($uuid, $contract->uuid);
    }

    public function test_route_key_name_is_uuid()
    {
        $this->assertSame('uuid', (new ProjectContract())->getRouteKeyName());
    }
}
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectContractModelTest.php
```

Expected: failures — `ProjectContract::factory` not found or `uuid` column unused, and/or `getRouteKeyName` still returns `id`.

- [ ] **Step 3: Update the model**

Overwrite `Modules/Project/Entities/ProjectContract.php` with:

```php
<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Project\Database\Factories\ProjectContractFactory;

class ProjectContract extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'contract_file_path', 'uuid'];

    protected static function booted()
    {
        static::creating(function (ProjectContract $contract) {
            if (empty($contract->uuid)) {
                $contract->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function newFactory()
    {
        return ProjectContractFactory::new();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
```

- [ ] **Step 4: Run tests, confirm they pass**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectContractModelTest.php
```

Expected: all four tests pass.

- [ ] **Step 5: Commit**

```bash
git add Modules/Project/Entities/ProjectContract.php \
        Modules/Project/Tests/Unit/ProjectContractModelTest.php
git commit -m "feat(project): auto-generate uuid on ProjectContract and use it as route key"
```

---

## Task 4: Migration B — enforce `uuid` NOT NULL

**Files:**
- Create: `Modules/Project/Database/Migrations/2026_04_23_000002_make_uuid_not_null_on_project_contracts_table.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUuidNotNullOnProjectContractsTable extends Migration
{
    public function up()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->change();
        });
    }
}
```

- [ ] **Step 2: Run the migration**

Run:
```bash
php artisan migrate --env=testing
```

Expected: migration succeeds. If it fails with "cannot be null", rerun Task 2's backfill against the target DB before retrying.

- [ ] **Step 3: Verify constraint**

Run:
```bash
php artisan tinker --env=testing --execute="var_export(DB::selectOne('SHOW COLUMNS FROM project_contracts LIKE \"uuid\"'));"
```

Expected: `Null => NO`.

- [ ] **Step 4: Commit**

```bash
git add Modules/Project/Database/Migrations/2026_04_23_000002_make_uuid_not_null_on_project_contracts_table.php
git commit -m "feat(project): make project_contracts.uuid NOT NULL"
```

---

## Task 5: Create `ProjectContractPolicy`

**Files:**
- Create: `Modules/Project/Policies/ProjectContractPolicy.php`
- Create: `Modules/Project/Tests/Unit/ProjectContractPolicyTest.php`

- [ ] **Step 1: Write failing unit tests**

Create `Modules/Project/Tests/Unit/ProjectContractPolicyTest.php`:

```php
<?php

namespace Modules\Project\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Entities\Client;
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
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectContractPolicyTest.php
```

Expected: fails — class `Modules\Project\Policies\ProjectContractPolicy` not found.

- [ ] **Step 3: Create the policy**

Write `Modules/Project/Policies/ProjectContractPolicy.php`:

```php
<?php

namespace Modules\Project\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Project\Entities\ProjectContract;
use Modules\User\Entities\User;

class ProjectContractPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ProjectContract $contract)
    {
        if (! $user->hasPermissionTo('projects.view')) {
            return false;
        }

        $project = $contract->project;
        if (! $project) {
            return false;
        }

        $isKAM = optional($project->client)->key_account_manager_id === $user->id;
        if ($isKAM) {
            return true;
        }

        return $project->teamMembers()->where('users.id', $user->id)->exists();
    }
}
```

- [ ] **Step 4: Run tests, confirm they pass**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectContractPolicyTest.php
```

Expected: all five tests pass.

- [ ] **Step 5: Commit**

```bash
git add Modules/Project/Policies/ProjectContractPolicy.php \
        Modules/Project/Tests/Unit/ProjectContractPolicyTest.php
git commit -m "feat(project): add ProjectContractPolicy gating contract views"
```

---

## Task 6: Register the policy

**Files:**
- Modify: `Modules/Project/Providers/ProjectAuthServiceProvider.php`

- [ ] **Step 1: Update the provider**

Change the contents to:

```php
<?php

namespace Modules\Project\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Policies\ProjectContractPolicy;
use Modules\Project\Policies\ProjectPolicy;

class ProjectAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
        ProjectContract::class => ProjectContractPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
```

- [ ] **Step 2: Confirm the provider is loaded**

Run:
```bash
grep -n "ProjectAuthServiceProvider" Modules/Project/Providers/ProjectServiceProvider.php config/app.php
```

Expected: the provider is referenced by `ProjectServiceProvider::register` (standard for `nwidart/laravel-modules`). If not, register it there — but the file already exists and was loading before this change, so this should be a no-op check.

- [ ] **Step 3: Sanity check from tinker**

Run:
```bash
php artisan tinker --env=testing --execute="\$c = \Modules\Project\Entities\ProjectContract::factory()->create(); \$u = \Modules\User\Entities\User::factory()->create(); echo \Gate::forUser(\$u)->check('view', \$c) ? 'true' : 'false';"
```

Expected: `false` (unauthenticated/no permission user is denied — proves the policy is wired up and returning a boolean).

- [ ] **Step 4: Commit**

```bash
git add Modules/Project/Providers/ProjectAuthServiceProvider.php
git commit -m "feat(project): register ProjectContractPolicy"
```

---

## Task 7: Gate and stream in `ProjectController::showPdf`

**Files:**
- Modify: `Modules/Project/Http/Controllers/ProjectController.php`
- Create: `Modules/Project/Tests/Feature/ContractPdfAccessTest.php`

### Step-by-step

- [ ] **Step 1: Write failing feature test (happy path + 403)**

Create `Modules/Project/Tests/Feature/ContractPdfAccessTest.php`:

```php
<?php

namespace Modules\Project\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Entities\Client;
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
        $user = User::factory()->create();
        $this->be($user);
        $contract = $this->contractWithFile();

        $response = $this->get(route('pdf.show', $contract));

        $response->assertForbidden();
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
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Feature/ContractPdfAccessTest.php
```

Expected: the forbidden test fails (current controller returns 200 for anyone logged in), and the happy-path test may fail due to `file_get_contents` on the non-existent absolute path produced by `storage_path('app/' . $path)` combined with `Storage::fake` placing files on the fake disk.

- [ ] **Step 3: Rewrite `ProjectController::showPdf`**

In `Modules/Project/Http/Controllers/ProjectController.php`:

1. Ensure these imports are present at the top of the file:

```php
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
```

2. Replace the existing `showPdf` method (currently at `Modules/Project/Http/Controllers/ProjectController.php:132`) with:

```php
public function showPdf(ProjectContract $contract)
{
    $this->authorize('view', $contract);

    $path = $contract->contract_file_path;
    if (! $path || ! Storage::disk('local')->exists($path)) {
        Log::warning('contract pdf missing', [
            'contract_uuid' => $contract->uuid,
            'user_id' => auth()->id(),
            'path' => $path,
        ]);
        abort(404);
    }

    $filename = pathinfo($path, PATHINFO_BASENAME);

    return Storage::disk('local')->response($path, $filename, [
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
}
```

Notes:
- Method changed from `public static` to `public`. The existing constructor already uses the `AuthorizesRequests` trait (see `ProjectController` class body), so `$this->authorize()` is available.
- We no longer read the file into memory.

- [ ] **Step 4: Run feature tests, confirm all three pass**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Feature/ContractPdfAccessTest.php
```

Expected: 3 passing.

- [ ] **Step 5: Commit**

```bash
git add Modules/Project/Http/Controllers/ProjectController.php \
        Modules/Project/Tests/Feature/ContractPdfAccessTest.php
git commit -m "fix(project): authorize and stream contract pdf downloads"
```

---

## Task 8: Add remaining feature-test cases (KAM, ended member, numeric-id, missing file, missing column)

**Files:**
- Modify: `Modules/Project/Tests/Feature/ContractPdfAccessTest.php`

- [ ] **Step 1: Append the new test methods**

Add the following methods to the test class created in Task 7:

```php
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
    $user = $this->userWithProjectsView();
    $contract = $this->contractWithFile();
    $contract->project->teamMembers()->attach($user->id, [
        'designation' => 'developer',
        'started_on' => Carbon::now()->subMonth(),
        'ended_on' => Carbon::yesterday(),
    ]);

    $this->be($user);
    $this->get(route('pdf.show', $contract))->assertForbidden();
}

public function test_numeric_id_guess_returns_404()
{
    $user = $this->userWithProjectsView();
    $contract = $this->contractWithFile();
    $contract->project->teamMembers()->attach($user->id, [
        'designation' => 'developer',
        'started_on' => Carbon::yesterday(),
        'ended_on' => null,
    ]);

    $this->be($user);
    $this->get('/projects/contract/pdf/' . $contract->id)->assertNotFound();
}

public function test_unknown_uuid_returns_404()
{
    $this->be($this->userWithProjectsView());
    $this->get('/projects/contract/pdf/11111111-1111-1111-1111-111111111111')
        ->assertNotFound();
}

public function test_missing_file_on_disk_returns_404()
{
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
    $this->get(route('pdf.show', $contract))->assertNotFound();
}

public function test_null_file_path_returns_404()
{
    $user = $this->userWithProjectsView();
    $contract = ProjectContract::factory()->create(['contract_file_path' => null]);
    $contract->project->teamMembers()->attach($user->id, [
        'designation' => 'developer',
        'started_on' => Carbon::yesterday(),
        'ended_on' => null,
    ]);

    $this->be($user);
    $this->get(route('pdf.show', $contract))->assertNotFound();
}
```

- [ ] **Step 2: Run the full feature test file**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Feature/ContractPdfAccessTest.php
```

Expected: 9 passing.

- [ ] **Step 3: Run the whole project-module test suite**

Run:
```bash
vendor/bin/phpunit Modules/Project
```

Expected: all green. If anything else breaks, treat it as regression and investigate before committing.

- [ ] **Step 4: Commit**

```bash
git add Modules/Project/Tests/Feature/ContractPdfAccessTest.php
git commit -m "test(project): cover KAM, ended member, missing file, numeric-id cases"
```

---

## Task 9: Run the full test suite and linters

**Files:** none modified.

- [ ] **Step 1: Run the full PHPUnit suite**

Run:
```bash
vendor/bin/phpunit
```

Expected: green.

- [ ] **Step 2: Run PHP-CS-Fixer**

Run:
```bash
php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --diff
```

Expected: either no changes, or auto-fixes applied. If auto-fixes applied, stage and amend them into the last relevant commit or create a fixup commit.

- [ ] **Step 3: Run Larastan**

Run:
```bash
./vendor/bin/phpstan analyse Modules/Project
```

Expected: no new errors introduced by this change. Pre-existing errors may remain — leave them alone.

- [ ] **Step 4: Commit any style fixes**

If Step 2 produced changes:
```bash
git add -u
git commit -m "style: apply php-cs-fixer auto-fixes"
```

Otherwise skip.

---

## Self-review notes

- **Spec coverage:**
  - Access rule (permission + team/KAM): Task 5 policy + Task 6 registration + Task 7 authorize.
  - UUID route key: Tasks 2–4 (migrations + model).
  - Streaming via `Storage::response`: Task 7.
  - Error handling cases (null path, missing file, 403, 404, 302): Tasks 7 and 8.
  - Test matrix (policy × relationship, feature happy/forbidden/not-found): Tasks 5 and 8.
  - Migration test (backfill correctness): covered implicitly by Task 2 Step 3 verification.
- **Placeholder scan:** every code block is full code; no "TBD" or "similar to above".
- **Type consistency:** `contract_file_path`, `uuid`, `key_account_manager_id`, `teamMembers()`, `projects.view`, `getRouteKeyName()` all match between tasks.
- **Known pre-existing duplication:** `app/Policies/ProjectPolicy.php` and `Modules/Project/Policies/ProjectPolicy.php` both exist. Out of scope — do not touch in this plan.
