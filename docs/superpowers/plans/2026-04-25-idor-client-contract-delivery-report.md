# IDOR Fix — Client Contract & Project Delivery Report Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix IDOR on `GET /client/contract/pdf/{contract}` and `GET /projects/delivery-report/{invoice}` by replacing numeric route keys with UUIDs, gating each behind a per-resource policy, and streaming files via `Storage::response`. One PR, two endpoints, mirrors PR #3820 pattern.

**Architecture:** For each of `ClientContract` and `ProjectInvoiceTerm`: (1) add a UUID column with backfill + NOT NULL migrations, (2) auto-generate UUID on create + expose via `getRouteKeyName`, (3) add a policy with `view($user, $resource)`, (4) register the policy in the module's auth provider (create one for Client, reuse Project's), (5) convert the controller method to instance + authorize first + stream via `Storage::disk('local')->response(...)` + log on deny / missing file. For `ProjectInvoiceTerm`, also update four blade callers that currently pass the integer id to pass the model instance instead.

**Tech Stack:** Laravel 8, PHP 7.4+, MySQL 5.7, `nwidart/laravel-modules`, `spatie/laravel-permission`, `doctrine/dbal` (already present), PHPUnit, `Storage::fake` for tests.

**Spec:** [docs/superpowers/specs/2026-04-25-idor-client-contract-delivery-report-design.md](../specs/2026-04-25-idor-client-contract-delivery-report-design.md)

**Issue:** [ColoredCow/portal#3821](https://github.com/ColoredCow/portal/issues/3821)

**Branch:** `bugfix/3821/idor-client-contract-delivery-report` (already created off `main`).

---

## File Structure

### Phase 1 — Client Contract

**Create:**

- `Modules/Client/Database/Factories/ClientContractFactory.php`
- `Modules/Client/Database/Migrations/2026_04_25_000001_add_uuid_to_client_contracts_table.php`
- `Modules/Client/Database/Migrations/2026_04_25_000002_make_uuid_not_null_on_client_contracts_table.php`
- `Modules/Client/Policies/ClientContractPolicy.php`
- `Modules/Client/Providers/ClientAuthServiceProvider.php`
- `Modules/Client/Tests/Unit/ClientContractModelTest.php`
- `Modules/Client/Tests/Unit/ClientContractPolicyTest.php`
- `Modules/Client/Tests/Feature/ClientContractPdfAccessTest.php`

**Modify:**

- `Modules/Client/Entities/ClientContract.php` — add `uuid` to `$fillable`, `HasFactory`, `booted()` UUID generator, `getRouteKeyName()`, `newFactory()`.
- `Modules/Client/Providers/ClientServiceProvider.php` — register the new `ClientAuthServiceProvider` from `register()`.
- `Modules/Client/Http/Controllers/ClientController.php` — `showPdf` becomes a public instance method; authorize → 403 logging → file existence check → 404 logging → stream via `Storage::disk('local')->response(...)`.

### Phase 2 — Project Delivery Report

**Create:**

- `Modules/Project/Database/Factories/ProjectInvoiceTermFactory.php`
- `Modules/Project/Database/Migrations/2026_04_25_000003_add_uuid_to_project_invoice_terms_table.php`
- `Modules/Project/Database/Migrations/2026_04_25_000004_make_uuid_not_null_on_project_invoice_terms_table.php`
- `Modules/Project/Policies/ProjectInvoiceTermPolicy.php`
- `Modules/Project/Tests/Unit/ProjectInvoiceTermModelTest.php`
- `Modules/Project/Tests/Unit/ProjectInvoiceTermPolicyTest.php`
- `Modules/Project/Tests/Feature/DeliveryReportAccessTest.php`

**Modify:**

- `Modules/Project/Entities/ProjectInvoiceTerm.php` — add `uuid` to `$fillable`, `HasFactory`, `booted()` UUID generator, `getRouteKeyName()`, `newFactory()`.
- `Modules/Project/Providers/ProjectAuthServiceProvider.php` — add `ProjectInvoiceTerm => ProjectInvoiceTermPolicy` to `$policies`.
- `Modules/Project/Http/Controllers/ProjectController.php` — `showDeliveryReport($invoice)` becomes a typed `ProjectInvoiceTerm` parameter; authorize → log + 404 on missing → stream. No service call.
- `Modules/Project/Services/ProjectService.php` — delete `showDeliveryReport`. The `saveOrUpdateDeliveryReport` writer is unrelated and stays.
- `Modules/Invoice/Resources/views/index.blade.php:398` — pass `$invoice` (the `ProjectInvoiceTerm` model) instead of `$invoice->id`.
- `Modules/Invoice/Resources/views/mail/upcoming-invoice-list.blade.php:47` — same.
- `Modules/Project/Resources/views/subviews/edit-project-inoice-terms.blade.php:48` — uses Vue’s `getDeliveryReportUrl`; covered by the JS change in `edit.blade.php`.
- `Modules/Project/Resources/views/edit.blade.php:295` — change `getDeliveryReportUrl` argument from `invoiceTermId` (numeric) to `invoiceTermUuid`. Update the Vue invoice-terms array to carry `uuid`. Update the controller-side data feeding the Vue component.

### Phase 3 — Verification

No file changes. Runs full PHPUnit suite, PHP-CS-Fixer, Larastan.

---

# PHASE 1 — CLIENT CONTRACT

## Task 1: Add `ClientContractFactory`

**Files:**
- Create: `Modules/Client/Database/Factories/ClientContractFactory.php`

- [ ] **Step 1: Verify the model does not yet use `HasFactory`**

Run:
```bash
grep -n "HasFactory\|use Illuminate" Modules/Client/Entities/ClientContract.php
```

Expected: only the existing `use Illuminate\Database\Eloquent\Model;` line — no `HasFactory`. The trait will be added in Task 3 along with the rest of the model changes.

- [ ] **Step 2: Create the factory file**

Write `Modules/Client/Database/Factories/ClientContractFactory.php`:

```php
<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientContract;

class ClientContractFactory extends Factory
{
    protected $model = ClientContract::class;

    public function definition()
    {
        return [
            'client_id' => function () {
                return Client::factory()->create()->id;
            },
            'contract_file_path' => 'client-contracts/' . $this->faker->uuid . '.pdf',
            'start_date' => now()->subYear(),
            'end_date' => now()->addYear(),
        ];
    }
}
```

- [ ] **Step 3: Commit**

```bash
git add Modules/Client/Database/Factories/ClientContractFactory.php
git commit -m "feat(client): add ClientContractFactory for tests"
```

---

## Task 2: Migration A — add nullable `uuid` to `client_contracts`

**Files:**
- Create: `Modules/Client/Database/Migrations/2026_04_25_000001_add_uuid_to_client_contracts_table.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddUuidToClientContractsTable extends Migration
{
    public function up()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        DB::table('client_contracts')
            ->whereNull('uuid')
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('client_contracts')
                        ->where('id', $row->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });
    }

    public function down()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
}
```

Note: backfill uses `DB::table` rather than the Eloquent model so the migration works before Task 3 wires up the model `booted()` generator.

- [ ] **Step 2: Run the migration against the test DB**

Run:
```bash
php artisan migrate --env=testing
```

Expected: `Migrated: 2026_04_25_000001_add_uuid_to_client_contracts_table`.

- [ ] **Step 3: Verify schema and backfill**

Run:
```bash
php artisan tinker --env=testing --execute="echo Schema::hasColumn('client_contracts','uuid') ? 'yes' : 'no';"
```

Expected: `yes`.

Run:
```bash
php artisan tinker --env=testing --execute="echo DB::table('client_contracts')->whereNull('uuid')->count();"
```

Expected: `0`.

- [ ] **Step 4: Rollback test**

Run:
```bash
php artisan migrate:rollback --env=testing --step=1
php artisan migrate --env=testing
```

Expected: rollback drops the column, re-migrate succeeds.

- [ ] **Step 5: Commit**

```bash
git add Modules/Client/Database/Migrations/2026_04_25_000001_add_uuid_to_client_contracts_table.php
git commit -m "feat(client): add uuid column to client_contracts with backfill"
```

---

## Task 3: Update `ClientContract` model

**Files:**
- Modify: `Modules/Client/Entities/ClientContract.php`
- Create: `Modules/Client/Tests/Unit/ClientContractModelTest.php`

- [ ] **Step 1: Write failing unit tests**

Create `Modules/Client/Tests/Unit/ClientContractModelTest.php`:

```php
<?php

namespace Modules\Client\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Entities\ClientContract;
use Tests\TestCase;

class ClientContractModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_auto_generated_on_create()
    {
        $contract = ClientContract::factory()->create();

        $this->assertNotNull($contract->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $contract->uuid
        );
    }

    public function test_uuids_are_unique_per_row()
    {
        $a = ClientContract::factory()->create();
        $b = ClientContract::factory()->create();

        $this->assertNotSame($a->uuid, $b->uuid);
    }

    public function test_explicit_uuid_is_not_overwritten()
    {
        $uuid = '11111111-1111-1111-1111-111111111111';
        $contract = ClientContract::factory()->create(['uuid' => $uuid]);

        $this->assertSame($uuid, $contract->uuid);
    }

    public function test_route_key_name_is_uuid()
    {
        $this->assertSame('uuid', (new ClientContract())->getRouteKeyName());
    }
}
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Client/Tests/Unit/ClientContractModelTest.php
```

Expected: failures — `ClientContract::factory()` undefined and `getRouteKeyName` returns `id`.

- [ ] **Step 3: Update the model**

Overwrite `Modules/Client/Entities/ClientContract.php`:

```php
<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Client\Database\Factories\ClientContractFactory;

class ClientContract extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'contract_file_path', 'start_date', 'end_date', 'uuid'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function (ClientContract $contract) {
            if (empty($contract->uuid)) {
                $contract->uuid = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory()
    {
        return ClientContractFactory::new();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
```

- [ ] **Step 4: Run tests, confirm pass**

Run:
```bash
vendor/bin/phpunit Modules/Client/Tests/Unit/ClientContractModelTest.php
```

Expected: 4 passing.

- [ ] **Step 5: Commit**

```bash
git add Modules/Client/Entities/ClientContract.php \
        Modules/Client/Tests/Unit/ClientContractModelTest.php
git commit -m "feat(client): auto-generate uuid on ClientContract and use it as route key"
```

---

## Task 4: Migration B — make `client_contracts.uuid` NOT NULL

**Files:**
- Create: `Modules/Client/Database/Migrations/2026_04_25_000002_make_uuid_not_null_on_client_contracts_table.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUuidNotNullOnClientContractsTable extends Migration
{
    public function up()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
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

Expected: migration succeeds.

- [ ] **Step 3: Verify constraint**

Run:
```bash
php artisan tinker --env=testing --execute="var_export(DB::selectOne('SHOW COLUMNS FROM client_contracts LIKE \"uuid\"'));"
```

Expected: `Null => NO`.

- [ ] **Step 4: Commit**

```bash
git add Modules/Client/Database/Migrations/2026_04_25_000002_make_uuid_not_null_on_client_contracts_table.php
git commit -m "feat(client): make client_contracts.uuid NOT NULL"
```

---

## Task 5: `ClientContractPolicy` + unit tests

**Files:**
- Create: `Modules/Client/Policies/ClientContractPolicy.php`
- Create: `Modules/Client/Tests/Unit/ClientContractPolicyTest.php`

- [ ] **Step 1: Write failing unit tests**

Create `Modules/Client/Tests/Unit/ClientContractPolicyTest.php`:

```php
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

    private function userWithClientsView(): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo('clients.view');

        return $user;
    }
}
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Client/Tests/Unit/ClientContractPolicyTest.php
```

Expected: fails — `Modules\Client\Policies\ClientContractPolicy` undefined.

- [ ] **Step 3: Create the policy**

Write `Modules/Client/Policies/ClientContractPolicy.php`:

```php
<?php

namespace Modules\Client\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Client\Entities\ClientContract;
use Modules\User\Entities\User;

class ClientContractPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ClientContract $contract)
    {
        if (! $user->hasPermissionTo('clients.view')) {
            return false;
        }

        $client = $contract->client;
        if (! $client) {
            return false;
        }

        if ($client->key_account_manager_id === $user->id) {
            return true;
        }

        return $client->projects()
            ->whereHas('teamMembers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->exists();
    }
}
```

The `teamMembers` relation on `Project` already scopes `whereNull('project_team_members.ended_on')`, so the `whereHas` only matches **active** members.

- [ ] **Step 4: Run tests, confirm pass**

Run:
```bash
vendor/bin/phpunit Modules/Client/Tests/Unit/ClientContractPolicyTest.php
```

Expected: 5 passing.

- [ ] **Step 5: Commit**

```bash
git add Modules/Client/Policies/ClientContractPolicy.php \
        Modules/Client/Tests/Unit/ClientContractPolicyTest.php
git commit -m "feat(client): add ClientContractPolicy gating contract pdf views"
```

---

## Task 6: Create `ClientAuthServiceProvider` and register it

**Files:**
- Create: `Modules/Client/Providers/ClientAuthServiceProvider.php`
- Modify: `Modules/Client/Providers/ClientServiceProvider.php`

- [ ] **Step 1: Create the new provider**

Write `Modules/Client/Providers/ClientAuthServiceProvider.php`:

```php
<?php

namespace Modules\Client\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Client\Entities\ClientContract;
use Modules\Client\Policies\ClientContractPolicy;

class ClientAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        ClientContract::class => ClientContractPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
```

- [ ] **Step 2: Register the provider from `ClientServiceProvider::register`**

Edit `Modules/Client/Providers/ClientServiceProvider.php`. Find the `register()` method (currently:

```php
public function register()
{
    $this->app->register(RouteServiceProvider::class);
}
```

) and replace it with:

```php
public function register()
{
    $this->app->register(RouteServiceProvider::class);
    $this->app->register(ClientAuthServiceProvider::class);
}
```

The existing `ClientPolicy` registration via `ClientServiceProvider::$policies` and `registerPolicies()` is left untouched — both providers call `Gate::policy()` with disjoint resource keys, so there is no conflict.

- [ ] **Step 3: Sanity check from tinker**

Run:
```bash
php artisan tinker --env=testing --execute="\$c = \Modules\Client\Entities\ClientContract::factory()->create(); \$u = \Modules\User\Entities\User::factory()->create(); echo \Gate::forUser(\$u)->check('view', \$c) ? 'true' : 'false';"
```

Expected: `false`. The policy is wired up and a permissionless user is denied. (If this errors with "policy not found", the new provider isn't being registered — re-check Step 2.)

- [ ] **Step 4: Commit**

```bash
git add Modules/Client/Providers/ClientAuthServiceProvider.php \
        Modules/Client/Providers/ClientServiceProvider.php
git commit -m "feat(client): register ClientContractPolicy via new ClientAuthServiceProvider"
```

---

## Task 7: Convert `ClientController::showPdf` and add feature tests

**Files:**
- Modify: `Modules/Client/Http/Controllers/ClientController.php`
- Create: `Modules/Client/Tests/Feature/ClientContractPdfAccessTest.php`

- [ ] **Step 1: Write the full failing feature-test matrix**

Create `Modules/Client/Tests/Feature/ClientContractPdfAccessTest.php`:

```php
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
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Client/Tests/Feature/ClientContractPdfAccessTest.php
```

Expected: most cases fail. The current static `showPdf` has no auth and reads files via `storage_path` + `file_get_contents`, neither of which works under `Storage::fake`.

- [ ] **Step 3: Rewrite `ClientController::showPdf`**

In `Modules/Client/Http/Controllers/ClientController.php`:

1. Add imports near the existing `use` block:

```php
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
```

2. Replace the existing static `showPdf` (currently at `Modules/Client/Http/Controllers/ClientController.php:83-94`) with:

```php
public function showPdf(ClientContract $contract)
{
    try {
        $this->authorize('view', $contract);
    } catch (AuthorizationException $e) {
        Log::notice('client contract pdf access denied', [
            'contract_uuid' => $contract->uuid,
            'user_id' => auth()->id(),
        ]);
        throw $e;
    }

    $path = $contract->contract_file_path;
    if (! $path || ! Storage::disk('local')->exists($path)) {
        Log::warning('client contract pdf missing', [
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
- Method is now non-static; `$this->authorize` is available because `ClientController` already extends `ModuleBaseController`, which extends Laravel's base controller using the `AuthorizesRequests` trait (consistent with the existing `$this->authorize(...)` calls elsewhere in this file).
- The `try/catch` re-throws so Laravel's default handler still produces the 403 — we are only inserting the `Log::notice` side effect.

- [ ] **Step 4: Run feature tests, confirm pass**

Run:
```bash
vendor/bin/phpunit Modules/Client/Tests/Feature/ClientContractPdfAccessTest.php
```

Expected: 11 passing.

- [ ] **Step 5: Run the whole client-module test suite**

Run:
```bash
vendor/bin/phpunit Modules/Client
```

Expected: green. Investigate any regressions before committing.

- [ ] **Step 6: Commit**

```bash
git add Modules/Client/Http/Controllers/ClientController.php \
        Modules/Client/Tests/Feature/ClientContractPdfAccessTest.php
git commit -m "fix(client): authorize and stream client contract pdf downloads"
```

---

# PHASE 2 — PROJECT DELIVERY REPORT

## Task 8: Add `ProjectInvoiceTermFactory`

**Files:**
- Create: `Modules/Project/Database/Factories/ProjectInvoiceTermFactory.php`

- [ ] **Step 1: Write the factory**

```php
<?php

namespace Modules\Project\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectInvoiceTerm;

class ProjectInvoiceTermFactory extends Factory
{
    protected $model = ProjectInvoiceTerm::class;

    public function definition()
    {
        return [
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'invoice_date' => now()->addMonth()->toDateString(),
            'amount' => 1000.00,
            'status' => 'sent',
            'client_acceptance_required' => false,
            'is_accepted' => false,
            'report_required' => true,
            'delivery_report' => 'delivery_report/2026/04/sample.pdf',
        ];
    }
}
```

- [ ] **Step 2: Commit**

```bash
git add Modules/Project/Database/Factories/ProjectInvoiceTermFactory.php
git commit -m "feat(project): add ProjectInvoiceTermFactory for tests"
```

---

## Task 9: Migration A — add nullable `uuid` to `project_invoice_terms`

**Files:**
- Create: `Modules/Project/Database/Migrations/2026_04_25_000003_add_uuid_to_project_invoice_terms_table.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddUuidToProjectInvoiceTermsTable extends Migration
{
    public function up()
    {
        Schema::table('project_invoice_terms', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        DB::table('project_invoice_terms')
            ->whereNull('uuid')
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('project_invoice_terms')
                        ->where('id', $row->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });
    }

    public function down()
    {
        Schema::table('project_invoice_terms', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
}
```

- [ ] **Step 2: Run + verify + rollback test (mirror Task 2)**

Run:
```bash
php artisan migrate --env=testing
php artisan tinker --env=testing --execute="echo Schema::hasColumn('project_invoice_terms','uuid') ? 'yes' : 'no';"
php artisan tinker --env=testing --execute="echo DB::table('project_invoice_terms')->whereNull('uuid')->count();"
php artisan migrate:rollback --env=testing --step=1
php artisan migrate --env=testing
```

Expected: `yes`, `0`, rollback ok, re-migrate ok.

- [ ] **Step 3: Commit**

```bash
git add Modules/Project/Database/Migrations/2026_04_25_000003_add_uuid_to_project_invoice_terms_table.php
git commit -m "feat(project): add uuid column to project_invoice_terms with backfill"
```

---

## Task 10: Update `ProjectInvoiceTerm` model

**Files:**
- Modify: `Modules/Project/Entities/ProjectInvoiceTerm.php`
- Create: `Modules/Project/Tests/Unit/ProjectInvoiceTermModelTest.php`

- [ ] **Step 1: Write failing unit tests**

Create `Modules/Project/Tests/Unit/ProjectInvoiceTermModelTest.php`:

```php
<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Tests\TestCase;

class ProjectInvoiceTermModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_auto_generated_on_create()
    {
        $term = ProjectInvoiceTerm::factory()->create();

        $this->assertNotNull($term->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $term->uuid
        );
    }

    public function test_uuids_are_unique_per_row()
    {
        $a = ProjectInvoiceTerm::factory()->create();
        $b = ProjectInvoiceTerm::factory()->create();

        $this->assertNotSame($a->uuid, $b->uuid);
    }

    public function test_explicit_uuid_is_not_overwritten()
    {
        $uuid = '22222222-2222-2222-2222-222222222222';
        $term = ProjectInvoiceTerm::factory()->create(['uuid' => $uuid]);

        $this->assertSame($uuid, $term->uuid);
    }

    public function test_route_key_name_is_uuid()
    {
        $this->assertSame('uuid', (new ProjectInvoiceTerm())->getRouteKeyName());
    }
}
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectInvoiceTermModelTest.php
```

Expected: failures — `factory()` undefined, `getRouteKeyName` returns `id`.

- [ ] **Step 3: Update the model**

Overwrite `Modules/Project/Entities/ProjectInvoiceTerm.php`:

```php
<?php

namespace Modules\Project\Entities;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Invoice\Entities\Invoice;
use Modules\Project\Database\Factories\ProjectInvoiceTermFactory;

class ProjectInvoiceTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'invoice_id', 'invoice_date', 'status',
        'client_acceptance_required', 'amount', 'is_accepted',
        'report_required', 'delivery_report', 'uuid',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function (ProjectInvoiceTerm $term) {
            if (empty($term->uuid)) {
                $term->uuid = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory()
    {
        return ProjectInvoiceTermFactory::new();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getCurrentStatusAttribute()
    {
        return Carbon::now() > $this->invoice_date ? 'overdue' : $this->status;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }
}
```

- [ ] **Step 4: Run tests, confirm pass**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectInvoiceTermModelTest.php
```

Expected: 4 passing.

- [ ] **Step 5: Commit**

```bash
git add Modules/Project/Entities/ProjectInvoiceTerm.php \
        Modules/Project/Tests/Unit/ProjectInvoiceTermModelTest.php
git commit -m "feat(project): auto-generate uuid on ProjectInvoiceTerm and use it as route key"
```

---

## Task 11: Migration B — make `project_invoice_terms.uuid` NOT NULL

**Files:**
- Create: `Modules/Project/Database/Migrations/2026_04_25_000004_make_uuid_not_null_on_project_invoice_terms_table.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUuidNotNullOnProjectInvoiceTermsTable extends Migration
{
    public function up()
    {
        Schema::table('project_invoice_terms', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('project_invoice_terms', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->change();
        });
    }
}
```

- [ ] **Step 2: Run + verify**

Run:
```bash
php artisan migrate --env=testing
php artisan tinker --env=testing --execute="var_export(DB::selectOne('SHOW COLUMNS FROM project_invoice_terms LIKE \"uuid\"'));"
```

Expected: `Null => NO`.

- [ ] **Step 3: Commit**

```bash
git add Modules/Project/Database/Migrations/2026_04_25_000004_make_uuid_not_null_on_project_invoice_terms_table.php
git commit -m "feat(project): make project_invoice_terms.uuid NOT NULL"
```

---

## Task 12: `ProjectInvoiceTermPolicy` + unit tests

**Files:**
- Create: `Modules/Project/Policies/ProjectInvoiceTermPolicy.php`
- Create: `Modules/Project/Tests/Unit/ProjectInvoiceTermPolicyTest.php`

- [ ] **Step 1: Write failing unit tests**

Create `Modules/Project/Tests/Unit/ProjectInvoiceTermPolicyTest.php`:

```php
<?php

namespace Modules\Project\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Entities\Client;
use Modules\Project\Database\Seeders\ProjectPermissionsTableSeeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\Project\Policies\ProjectInvoiceTermPolicy;
use Modules\User\Entities\User;
use Tests\TestCase;

class ProjectInvoiceTermPolicyTest extends TestCase
{
    use RefreshDatabase;

    private ProjectInvoiceTermPolicy $policy;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->artisan('db:seed', ['--class' => ProjectPermissionsTableSeeder::class]);
        $this->policy = new ProjectInvoiceTermPolicy();
    }

    public function test_denies_user_without_projects_view_permission()
    {
        $user = User::factory()->create();
        $term = ProjectInvoiceTerm::factory()->create();

        $this->assertFalse($this->policy->view($user, $term));
    }

    public function test_denies_user_with_permission_but_no_relationship()
    {
        $user = $this->userWithProjectsView();
        $term = ProjectInvoiceTerm::factory()->create();

        $this->assertFalse($this->policy->view($user, $term));
    }

    public function test_allows_active_team_member()
    {
        $user = $this->userWithProjectsView();
        $term = ProjectInvoiceTerm::factory()->create();

        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::yesterday(),
            'ended_on' => null,
        ]);

        $this->assertTrue($this->policy->view($user, $term));
    }

    public function test_denies_ended_team_member()
    {
        $user = $this->userWithProjectsView();
        $term = ProjectInvoiceTerm::factory()->create();

        $term->project->teamMembers()->attach($user->id, [
            'designation' => 'developer',
            'started_on' => Carbon::now()->subMonth(),
            'ended_on' => Carbon::yesterday(),
        ]);

        $this->assertFalse($this->policy->view($user->fresh(), $term->fresh()));
    }

    public function test_allows_client_key_account_manager()
    {
        $kam = $this->userWithProjectsView();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $project = Project::factory()->create(['client_id' => $client->id]);
        $term = ProjectInvoiceTerm::factory()->create(['project_id' => $project->id]);

        $this->assertTrue($this->policy->view($kam, $term));
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
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectInvoiceTermPolicyTest.php
```

Expected: fails — `Modules\Project\Policies\ProjectInvoiceTermPolicy` undefined.

- [ ] **Step 3: Create the policy**

Write `Modules/Project/Policies/ProjectInvoiceTermPolicy.php`:

```php
<?php

namespace Modules\Project\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\User\Entities\User;

class ProjectInvoiceTermPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ProjectInvoiceTerm $term)
    {
        if (! $user->hasPermissionTo('projects.view')) {
            return false;
        }

        $project = $term->project;
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

- [ ] **Step 4: Run tests, confirm pass**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Unit/ProjectInvoiceTermPolicyTest.php
```

Expected: 5 passing.

The "missing project relation" defensive guard in the policy is intentionally not unit-tested: the schema's `onDelete('cascade')` on `project_invoice_terms.project_id` (see migration `2024_06_21_103448_create_project_invoice_terms.php`) means a dangling term cannot exist in production. The guard remains as defensive code.

- [ ] **Step 5: Commit**

```bash
git add Modules/Project/Policies/ProjectInvoiceTermPolicy.php \
        Modules/Project/Tests/Unit/ProjectInvoiceTermPolicyTest.php
git commit -m "feat(project): add ProjectInvoiceTermPolicy gating delivery report views"
```

---

## Task 13: Register `ProjectInvoiceTermPolicy` in existing auth provider

**Files:**
- Modify: `Modules/Project/Providers/ProjectAuthServiceProvider.php`

- [ ] **Step 1: Update the provider**

Replace the `$policies` array. Current:

```php
protected $policies = [
    Project::class => ProjectPolicy::class,
    ProjectContract::class => ProjectContractPolicy::class,
];
```

becomes:

```php
protected $policies = [
    Project::class => ProjectPolicy::class,
    ProjectContract::class => ProjectContractPolicy::class,
    ProjectInvoiceTerm::class => ProjectInvoiceTermPolicy::class,
];
```

Add the corresponding `use` statements at the top:

```php
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\Project\Policies\ProjectInvoiceTermPolicy;
```

- [ ] **Step 2: Sanity check from tinker**

Run:
```bash
php artisan tinker --env=testing --execute="\$t = \Modules\Project\Entities\ProjectInvoiceTerm::factory()->create(); \$u = \Modules\User\Entities\User::factory()->create(); echo \Gate::forUser(\$u)->check('view', \$t) ? 'true' : 'false';"
```

Expected: `false`.

- [ ] **Step 3: Commit**

```bash
git add Modules/Project/Providers/ProjectAuthServiceProvider.php
git commit -m "feat(project): register ProjectInvoiceTermPolicy"
```

---

## Task 14: Convert `ProjectController::showDeliveryReport`, drop service method, add feature tests

**Files:**
- Modify: `Modules/Project/Http/Controllers/ProjectController.php`
- Modify: `Modules/Project/Services/ProjectService.php`
- Create: `Modules/Project/Tests/Feature/DeliveryReportAccessTest.php`

- [ ] **Step 1: Write the full failing feature-test matrix**

Create `Modules/Project/Tests/Feature/DeliveryReportAccessTest.php`:

```php
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
        $term = $this->termWithFile();

        $this->get(route('delivery-report.show', $term));
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
        $term = $this->termWithFile();

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
}
```

- [ ] **Step 2: Run tests, confirm failure**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Feature/DeliveryReportAccessTest.php
```

Expected: most cases fail (current handler delegates to a service method that uses `storage_path` + `file_get_contents`, no auth).

- [ ] **Step 3: Rewrite `ProjectController::showDeliveryReport`**

In `Modules/Project/Http/Controllers/ProjectController.php`:

1. Ensure these imports are present (add any that are missing):

```php
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Project\Entities\ProjectInvoiceTerm;
```

2. Replace the existing method (currently `showDeliveryReport($invoiceId)` at `Modules/Project/Http/Controllers/ProjectController.php:217-220`) with:

```php
public function showDeliveryReport(ProjectInvoiceTerm $invoice)
{
    try {
        $this->authorize('view', $invoice);
    } catch (AuthorizationException $e) {
        Log::notice('delivery report access denied', [
            'invoice_term_uuid' => $invoice->uuid,
            'user_id' => auth()->id(),
        ]);
        throw $e;
    }

    $path = $invoice->delivery_report;
    if (! $path || ! Storage::disk('local')->exists($path)) {
        Log::warning('delivery report missing', [
            'invoice_term_uuid' => $invoice->uuid,
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

The route parameter name in `Modules/Project/Routes/web.php:21` is `{invoice}`, so the controller parameter must remain named `$invoice` for route-model-binding to resolve. Type-hint flips from untyped int to `ProjectInvoiceTerm`.

- [ ] **Step 4: Delete `ProjectService::showDeliveryReport`**

In `Modules/Project/Services/ProjectService.php`, remove the method at lines 425–436 (the `showDeliveryReport` definition). Leave `saveOrUpdateDeliveryReport` (the writer above it) intact.

- [ ] **Step 5: Run feature tests, confirm pass**

Run:
```bash
vendor/bin/phpunit Modules/Project/Tests/Feature/DeliveryReportAccessTest.php
```

Expected: 11 passing.

- [ ] **Step 6: Run the whole project-module test suite**

Run:
```bash
vendor/bin/phpunit Modules/Project
```

Expected: green. Pre-existing tests like `ContractPdfAccessTest` should still pass.

- [ ] **Step 7: Commit**

```bash
git add Modules/Project/Http/Controllers/ProjectController.php \
        Modules/Project/Services/ProjectService.php \
        Modules/Project/Tests/Feature/DeliveryReportAccessTest.php
git commit -m "fix(project): authorize and stream delivery report downloads"
```

---

## Task 15: Update blade callers to pass the model instead of the integer id

The route key is now `uuid`. Existing callers pass `$invoice->id` (integer); after this change they must pass the `ProjectInvoiceTerm` model instance so `route(...)` emits the UUID.

**Files:**
- Modify: `Modules/Invoice/Resources/views/index.blade.php`
- Modify: `Modules/Invoice/Resources/views/mail/upcoming-invoice-list.blade.php`
- Modify: `Modules/Project/Resources/views/edit.blade.php`

- [ ] **Step 1: Update `Modules/Invoice/Resources/views/index.blade.php`**

At line 398 the current code is:

```blade
<a id="delivery_report_{{ $index }}" href="{{ route('delivery-report.show', $invoice->id) }}" target="_blank">
```

Change `$invoice->id` to `$invoice`:

```blade
<a id="delivery_report_{{ $index }}" href="{{ route('delivery-report.show', $invoice) }}" target="_blank">
```

(`$invoice` here is already a `ProjectInvoiceTerm` model based on the surrounding context — it has `report_required`, `delivery_report`, `invoice_date` all of which live on `ProjectInvoiceTerm`.)

- [ ] **Step 2: Update `Modules/Invoice/Resources/views/mail/upcoming-invoice-list.blade.php`**

At line 47, same change: `route('delivery-report.show', $invoice->id)` → `route('delivery-report.show', $invoice)`.

- [ ] **Step 3: Update `Modules/Project/Resources/views/edit.blade.php` Vue helper**

The Vue page builds the URL client-side from a per-term identifier passed by the page's controller-rendered data array. Currently it uses the numeric `id`. We need to switch to `uuid`.

a. At line 295, change the helper signature and replacement:

```js
getDeliveryReportUrl(invoiceTermUuid) {
    return `{{ route('delivery-report.show', ':uuid') }}`.replace(':uuid', invoiceTermUuid);
},
```

b. Update the call site in `Modules/Project/Resources/views/subviews/edit-project-inoice-terms.blade.php:48`. Current:

```blade
<a :id="`delivery_report_${index}`" :href="getDeliveryReportUrl(invoiceTerm.id)" target="_blank">
```

Change `invoiceTerm.id` to `invoiceTerm.uuid`:

```blade
<a :id="`delivery_report_${index}`" :href="getDeliveryReportUrl(invoiceTerm.uuid)" target="_blank">
```

c. Verify the Vue data array carries `uuid` per term. Inspect the page's `data()` and any controller-rendered JSON that hydrates `invoiceTerms`. The default Eloquent JSON serialization includes every model attribute, so `invoiceTerm.uuid` should be present automatically once the model has the column. Spot-check by running the page in dev and viewing the rendered template, **or** by adding a temporary `console.log(this.invoiceTerms)` line, loading the page, confirming `uuid` is there, then removing the log.

- [ ] **Step 4: Smoke-check the routes manually**

Run the dev server and a watcher:

```bash
php artisan serve &
npm run watch &
```

Then in a browser, log in as a user with `projects.view` who is on a project's team:

1. Open `Modules/Project/Resources/views/edit.blade.php` rendered at `/projects/{project}/edit` for a project that has at least one invoice term with a delivery report. Click the report link. Expect the PDF to render inline. URL must contain a UUID, not a numeric id.
2. Open `/invoices` (the page rendered by `Modules/Invoice/Resources/views/index.blade.php`). Click a delivery-report link. Same expectation.

Stop the servers when done.

- [ ] **Step 5: Confirm full module test suites still pass**

Run:
```bash
vendor/bin/phpunit Modules/Project Modules/Invoice
```

Expected: green.

- [ ] **Step 6: Commit**

```bash
git add Modules/Invoice/Resources/views/index.blade.php \
        Modules/Invoice/Resources/views/mail/upcoming-invoice-list.blade.php \
        Modules/Project/Resources/views/edit.blade.php \
        Modules/Project/Resources/views/subviews/edit-project-inoice-terms.blade.php
git commit -m "fix(project): pass ProjectInvoiceTerm model to delivery-report URL helpers"
```

---

# PHASE 3 — VERIFICATION

## Task 16: Full test suite + linters

**Files:** none modified (style fixes optional commit).

- [ ] **Step 1: Run the full PHPUnit suite**

Run:
```bash
vendor/bin/phpunit
```

Expected: green. Investigate any regressions before continuing.

- [ ] **Step 2: Run PHP-CS-Fixer**

Run:
```bash
php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --diff
```

Expected: no changes, or auto-fixes applied to files we edited.

- [ ] **Step 3: Run Larastan on touched modules**

Run:
```bash
./vendor/bin/phpstan analyse Modules/Client Modules/Project
```

Expected: no new errors introduced. Pre-existing errors may remain — leave them alone.

- [ ] **Step 4: Run ESLint on touched JS/Blade**

Run:
```bash
./node_modules/.bin/eslint Modules/Project/Resources/views/edit.blade.php Modules/Project/Resources/views/subviews/edit-project-inoice-terms.blade.php --ext .js,.vue,.blade.php
```

(If ESLint complains about `.blade.php` extensions, skip — config may not include them. The change in those files is a single argument substitution and is unlikely to fail lint.)

- [ ] **Step 5: Commit any style fixes**

If Step 2 produced changes:

```bash
git add -u
git commit -m "style: apply php-cs-fixer auto-fixes"
```

Otherwise skip.

- [ ] **Step 6: Push and open PR**

```bash
git push -u origin bugfix/3821/idor-client-contract-delivery-report
gh pr create --base main --title "fix: IDOR on client contract pdf and project delivery report (#3821)" --body "$(cat <<'EOF'
## Summary

- Fixes #3821 by replacing numeric IDs with UUIDs and adding policies on two file-serving endpoints (client contract PDF, project delivery report).
- Mirrors the pattern from #3820 (project contract PDF).
- Streams files via `Storage::disk('local')->response(...)` instead of `file_get_contents`.
- Logs `Log::notice` on policy denials and `Log::warning` on missing files.

## Test plan

- [ ] `vendor/bin/phpunit Modules/Client` is green.
- [ ] `vendor/bin/phpunit Modules/Project` is green.
- [ ] `vendor/bin/phpunit` (full suite) is green.
- [ ] Manually click a delivery-report link from the project edit page and from the invoice index — both render PDF inline and the URL contains a UUID.
- [ ] Manually click a client contract link from the client edit page and the finance project-contract report — both render PDF inline.
- [ ] Hitting `/client/contract/pdf/1` (numeric id) returns 404.
- [ ] Hitting `/projects/delivery-report/1` (numeric id) returns 404.

🤖 Generated with [Claude Code](https://claude.com/claude-code)
EOF
)"
```

---

## Self-review notes

- **Spec coverage:**
  - UUID route key for both resources — Tasks 2/4 (Client) and 9/11 (Project).
  - Auto-generation + `getRouteKeyName` — Tasks 3 and 10.
  - `ClientContractPolicy` (clients.view + KAM or any-project active team) — Task 5.
  - `ProjectInvoiceTermPolicy` (projects.view + KAM or active team) — Task 12.
  - Provider registrations — Tasks 6 and 13.
  - Controller authorize-and-stream — Tasks 7 and 14.
  - `ProjectService::showDeliveryReport` removal — Task 14 Step 4.
  - Blade caller updates (4 sites) — Task 15.
  - 403 `Log::notice` + 404 `Log::warning` for both endpoints — Tasks 7 and 14.
  - Full test matrix per endpoint — Tasks 5, 7, 12, 14.
  - Migration backfill correctness — Tasks 2 and 9 verification steps.
  - Full suite + linters — Task 16.
- **Placeholder scan:** every code block is full code; no "TBD" / "similar to above" / "implement later".
- **Type / name consistency:**
  - Policy method `view($user, $resource)` matches between policy file, registration array, and controller `authorize('view', $resource)` calls.
  - Permission strings: `clients.view` (Client side), `projects.view` (Project side) — consistent with existing seeders.
  - Log message keys: `'client contract pdf access denied'` / `'client contract pdf missing'` (Client); `'delivery report access denied'` / `'delivery report missing'` (Project) — assertion text in tests matches controller text.
  - Route names: `client.pdf.show` and `delivery-report.show` — matched in tests, blade callers, and routes file.
  - Route param name `{invoice}` for delivery report kept as-is — controller parameter `$invoice` matches.
- **Known pre-existing duplication:** `ClientPolicy` exists in both `app/Policies/` and `Modules/Client/Policies/`; `ProjectPolicy` similarly. Out of scope.
