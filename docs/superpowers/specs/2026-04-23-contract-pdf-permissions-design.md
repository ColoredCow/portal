# Contract PDF Permissions — Design

Date: 2026-04-23
Branch: `hotfix/contract-permissions`
Scope: `Modules/Project` — contract PDF viewing endpoint.

## Problem

The route `GET /projects/contract/pdf/{contract}` streams a project's signed contract PDF to any authenticated user. The `{contract}` segment is a sequential auto-increment primary key, so any logged-in user can iterate IDs and read contracts that belong to projects they have no relationship to.

**Affected code**

- Route: `Modules/Project/Routes/web.php:22`
- Controller: `Modules/Project/Http/Controllers/ProjectController.php:132` (`showPdf`)
- Model: `Modules/Project/Entities/ProjectContract.php`
- Callers (blade): `Modules/Project/Resources/views/subviews/edit-project-details.blade.php:109`, `Modules/Project/Resources/views/show.blade.php:296`, `Modules/Project/Resources/views/show.blade.php:323`

**Existing defences**

- `auth` middleware on the `projects` route group — prevents unauthenticated access only.
- No policy, no ownership check, no permission check.
- `showPdf` is a `public static` method using `file_get_contents` (entire file loaded into memory).

## Goals

1. Only users with a legitimate relationship to the project can fetch its contract PDF.
2. Contract URLs are not enumerable.
3. Existing legitimate flows (project show/edit pages) keep working without blade changes.
4. Contract file streaming does not load the whole file into PHP memory.

## Non-goals

- Signed/expiring URLs (explicitly rejected in favour of UUID + policy).
- New admin UI for contract access management.
- Audit logging of PDF views (can be added later if requested).
- Moving files to a different disk or introducing S3.

## Access rule

A user may view a project's contract PDF **if and only if** *both* conditions hold:

1. The user has the `projects.view` Spatie permission; **AND**
2. The user is either:
   - an **active** team member on the project (`project_team_members.ended_on IS NULL`), **or**
   - the key account manager of the project's client (`clients.key_account_manager_id = users.id`).

Users with `projects.view` but no team/KAM relationship are denied. Former team members (`ended_on` set) are denied.

## Architecture

Policy-based authorization at the controller, combined with an opaque UUID route key that replaces the numeric PK in URLs.

- `project_contracts` gains a `uuid` column (unique, indexed, NOT NULL after backfill).
- `ProjectContract` model exposes `uuid` as the route key via `getRouteKeyName()`.
- A new `ProjectContractPolicy::view` encodes the access rule.
- `ProjectController::showPdf` runs `$this->authorize('view', $contract)` then streams the file via `Storage::disk('local')->response(...)`.

Blade callers are unchanged — `route('pdf.show', $contract)` emits the uuid automatically once `getRouteKeyName` returns `'uuid'`.

## Components

### 1. Migration A — add uuid column (nullable)

`add_uuid_to_project_contracts_table`

```php
Schema::table('project_contracts', function (Blueprint $table) {
    $table->uuid('uuid')->nullable()->unique()->after('id');
});
```

Same migration's `up()` backfills existing rows in chunks:

```php
ProjectContract::whereNull('uuid')->chunkById(500, function ($rows) {
    foreach ($rows as $row) {
        $row->uuid = (string) Str::uuid();
        $row->save();
    }
});
```

`down()` drops the column.

### 2. Migration B — enforce NOT NULL

`make_uuid_not_null_on_project_contracts` (separate migration so Migration A's backfill is committed before the constraint tightens).

```php
$table->uuid('uuid')->nullable(false)->change();
```

Requires `doctrine/dbal` (already a Laravel 8 dev pattern; verify present in `composer.json` during implementation, add if not).

### 3. Model changes — `ProjectContract`

```php
protected $fillable = ['project_id', 'contract_file_path', 'uuid'];

protected static function booted()
{
    static::creating(function ($contract) {
        $contract->uuid ??= (string) Str::uuid();
    });
}

public function getRouteKeyName()
{
    return 'uuid';
}
```

### 4. Policy — `Modules\Project\Policies\ProjectContractPolicy`

```php
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
```

`teamMembers()` already scopes to `ended_on IS NULL` (see `Project::teamMembers` in `Modules/Project/Entities/Project.php:48`), so former members are automatically excluded.

### 5. Policy registration

Register in `Modules/Project/Providers/ProjectAuthServiceProvider.php` (the module's `$policies` array — same file where `Project => ProjectPolicy` is mapped):

```php
protected $policies = [
    Project::class => ProjectPolicy::class,
    ProjectContract::class => ProjectContractPolicy::class,
];
```

### 6. Controller — `ProjectController::showPdf`

Convert from `public static` to instance method. Use the `AuthorizesRequests` trait (already present in a base controller).

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

### 7. Route

No structural change. Still:

```php
Route::get('/contract/pdf/{contract}', 'ProjectController@showPdf')->name('pdf.show');
```

Route-model-binding now resolves via `uuid` (driven by `getRouteKeyName`).

### 8. Blade callers

No change. All three call sites use `route('pdf.show', $contract)` / `route('pdf.show', $project->projectContracts->first())`. Laravel emits `$contract->uuid` automatically.

## Data flow

1. User clicks PDF link on project show/edit page → `GET /projects/contract/pdf/{uuid}`.
2. `auth` middleware — guest redirected to login.
3. Route-model-bind: `ProjectContract` resolved by uuid → 404 if not found.
4. `ProjectController::showPdf` runs `$this->authorize('view', $contract)` → `ProjectContractPolicy::view`.
5. Policy: permission check, then KAM check, then active-team `exists()` query.
6. Pass → streamed response via `Storage::response` with `inline` disposition.
7. Fail → 403.

## Error handling

| Case | Response | Logging |
|------|----------|---------|
| Guest | 302 → login | — |
| Unknown / malformed uuid | 404 | — |
| Authenticated, policy fail | 403 | default Laravel handler |
| `contract_file_path` null | 404 | `Log::warning('contract pdf missing', …)` |
| File not on disk | 404 | `Log::warning('contract pdf missing', …)` |
| Other storage errors | 500 | Sentry |

Never leak paths, filenames, or stack traces to the client. Log full context (contract uuid, user id, path) server-side.

## Testing

### Feature tests — `Modules/Project/Tests/Feature/ContractPdfAccessTest.php`

1. Guest → 302 to login.
2. Authenticated user without `projects.view` → 403.
3. Authenticated, has `projects.view`, not on team, not KAM → 403.
4. Authenticated, has `projects.view`, active team member → 200, `content-type: application/pdf`.
5. Authenticated, is KAM of project's client → 200.
6. Authenticated team member whose `ended_on` is set → 403.
7. Nonexistent uuid → 404.
8. Numeric-id guess (pre-fix URL shape) → 404.
9. Authorized but `contract_file_path` null → 404, warning logged.
10. Authorized but file missing on disk → 404, warning logged.

Use `Storage::fake('local')` and write dummy PDF bytes at the contract's `contract_file_path`. Factory for `ProjectContract` (add if missing).

### Unit tests — `ProjectContractPolicy`

Matrix: `projects.view` ∈ {true, false} × relationship ∈ {KAM, active team, ended team, stranger}.

### Migration test

Seed rows into `project_contracts`, run Migration A, assert every row has a unique non-null uuid; run Migration B, assert column is NOT NULL.

## Risks and mitigations

- **Enumerable numeric IDs still exist in the database.** Not a security issue once the route binds by uuid and the policy enforces access — ID-based access vectors are removed.
- **Backfill on a large table could be slow.** `chunkById(500)` keeps memory bounded. Run in a maintenance window if the table is large; the table looks small (internal portal) but verify row count during implementation.
- **Pre-existing bookmarks using numeric IDs break.** Acceptable: the old URL was the vulnerability. KAMs and team members can re-obtain links from the project show page.
- **`doctrine/dbal` dependency for Migration B.** If not already installed, add it; otherwise rewrite Migration B as a raw `ALTER TABLE` for MySQL.
- **Policy calls `$project->teamMembers()->exists()` per request.** Single indexed query, negligible cost. No N+1 because we're not iterating.

## Rollout

1. Merge → deploy → Migration A runs, backfills.
2. Verify backfill completed (`SELECT COUNT(*) FROM project_contracts WHERE uuid IS NULL;` returns 0).
3. Deploy Migration B (NOT NULL).
4. No cache clear / no user action required. Blade helpers automatically emit uuid URLs after deploy.

## Out of scope / follow-ups

- Audit log of PDF views.
- Download vs inline toggle.
- Moving contracts to a non-public disk with different retention.
- UUID on other sequentially-ID'd file-serving endpoints in the codebase (separate audit).
