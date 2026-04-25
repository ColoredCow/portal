# IDOR Fix: Client Contract PDF & Project Delivery Report — Design

Date: 2026-04-25
Issue: [ColoredCow/portal#3821](https://github.com/ColoredCow/portal/issues/3821)
Branch (target): `bugfix/3821/idor-client-contract-delivery-report` (off `main`)
Scope: `Modules/Client` and `Modules/Project` — two file-serving endpoints.
Precedent: `docs/superpowers/specs/2026-04-23-contract-pdf-permissions-design.md` (project contract PDF, PR #3820).

## Problem

Two endpoints stream sensitive documents keyed by sequential auto-increment IDs with no authorization beyond `auth` middleware. Any authenticated portal user can iterate IDs and fetch documents belonging to other clients/projects.

| # | Route | Controller | Resource served |
|---|-------|------------|-----------------|
| 1 | `GET /client/contract/pdf/{contract}` | `Modules\Client\Http\Controllers\ClientController::showPdf` (static) | `Modules\Client\Entities\ClientContract` (signed client agreement) |
| 2 | `GET /projects/delivery-report/{invoice}` | `Modules\Project\Http\Controllers\ProjectController::showDeliveryReport` → `Modules\Project\Services\ProjectService::showDeliveryReport` | file at `project_invoice_terms.delivery_report` (project delivery acceptance report) |

Both share the same defect class as PR #3820 (project contract PDF). Both are fixed in **one PR** using the same remediation pattern. This spec specifies that pattern applied twice.

## Goals

1. Only users with a legitimate relationship to the underlying client or project can fetch the document.
2. URLs are not enumerable (opaque UUID, not numeric PK).
3. Existing legitimate flows (Client edit page, Report finance view, Invoice index, Project edit) keep working — with the minimum view changes needed for the delivery-report URL helpers to emit UUIDs (see Resource B blade audit). The client-contract flow needs no view changes.
4. File streaming does not load the whole file into PHP memory.
5. Sensitive-document access events (denials and missing-file fetches) are observable in logs.

## Non-goals

- Signed/expiring URLs.
- Audit logging of every successful view (separate follow-up issue).
- Moving files to S3 or a non-public disk (separate issue).
- Sweep of other numeric-ID file endpoints across the codebase (separate audit).
- Backwards-compatible redirect from old numeric URLs (the numeric URL was the vulnerability — broken bookmarks acceptable).

## Access rules

### `ClientContractPolicy::view($user, ClientContract $contract)`

A user may view a client's contract PDF iff **both** hold:

1. `$user` has the `clients.view` Spatie permission; AND
2. Either:
   - `$user->id === $contract->client->key_account_manager_id` (KAM of the client), OR
   - `$user` is an **active** team member (`project_team_members.ended_on IS NULL`) on **at least one** project belonging to `$contract->client`.

Active relationship traversal: `client → projects (Client::projects hasMany) → teamMembers (Project::teamMembers belongsToMany via project_team_members)`. The existing `Project::teamMembers` relation already scopes `whereNull('project_team_members.ended_on')`, so former members are automatically excluded.

### `ProjectInvoiceTermPolicy::view($user, ProjectInvoiceTerm $term)`

A user may view a project's delivery report iff **both** hold:

1. `$user` has the `projects.view` Spatie permission; AND
2. Either:
   - active team member on `$term->project` (same `Project::teamMembers` relation, `ended_on IS NULL`), OR
   - `$user->id === $term->project->client->key_account_manager_id` (KAM of the project's client).

Identical shape to the existing `ProjectContractPolicy::view`, swapping the contract resource for the invoice term resource.

## Architecture

Same template applied to two resources:

1. Add a `uuid` column to the resource's table (unique, indexed, NOT NULL after backfill).
2. Add `uuid` to the model's `$fillable`, auto-generate on `creating` via `booted()`, expose as route key via `getRouteKeyName()`.
3. Add a policy with a `view` method encoding the access rule above.
4. Register the policy in the module's `AuthServiceProvider`.
5. Convert the controller method to an instance method, run `$this->authorize('view', $resource)` first, stream via `Storage::disk('local')->response(...)`. Log on policy denial and on missing file. Never read the whole file into PHP memory.

Blade callers that already pass the model instance (the three `client.pdf.show` call sites) continue to work without view changes — `route(...)` emits the UUID once `getRouteKeyName` returns `'uuid'`. The four `delivery-report.show` call sites currently pass `$invoice->id` (an integer); they must be updated to pass the `ProjectInvoiceTerm` model instance so route-model-binding resolves correctly under the new key. See **Per-resource components → Resource B → Blade**.

## Per-resource components

### Resource A — `ClientContract` (`Modules/Client`)

| Item | Location | Action |
|------|----------|--------|
| Table | `client_contracts` | Two migrations: nullable+backfill, then NOT NULL |
| Model | `Modules/Client/Entities/ClientContract.php` | Add `uuid` to `$fillable`; `booted()` UUID generator; `getRouteKeyName() = 'uuid'`; add `HasFactory` |
| Factory | `Modules/Client/Database/Factories/ClientContractFactory.php` | Create (does not exist today) |
| Policy | `Modules/Client/Policies/ClientContractPolicy.php` | Create. `view($user, $contract)` per access rule above |
| Provider | `Modules/Client/Providers/ClientAuthServiceProvider.php` | **Create** (does not exist). Register `ClientContract => ClientContractPolicy`. Register the new provider in `Modules/Client/Providers/ClientServiceProvider::register` |
| Controller | `Modules/Client/Http/Controllers/ClientController::showPdf` | Convert from `public static` to `public` instance method. `$this->authorize('view', $contract)` first. Stream via `Storage::disk('local')->response(...)` |
| Route | `Modules/Client/Routes/web.php:20` | No structural change |
| Blade | `Modules/Client/Resources/views/subviews/edit-client-contract.blade.php` (lines 45, 81), `Modules/Report/Resources/views/finance/project-contract/index.blade.php:105` | No change — already use `route('client.pdf.show', ...)` |

### Resource B — `ProjectInvoiceTerm` (`Modules/Project`)

| Item | Location | Action |
|------|----------|--------|
| Table | `project_invoice_terms` | Two migrations: nullable+backfill, then NOT NULL |
| Model | `Modules/Project/Entities/ProjectInvoiceTerm.php` | Add `uuid` to `$fillable`; `booted()` UUID generator; `getRouteKeyName() = 'uuid'`; add `HasFactory` |
| Factory | `Modules/Project/Database/Factories/ProjectInvoiceTermFactory.php` | Create if missing |
| Policy | `Modules/Project/Policies/ProjectInvoiceTermPolicy.php` | Create. `view($user, $term)` per access rule above |
| Provider | `Modules/Project/Providers/ProjectAuthServiceProvider.php` | Register `ProjectInvoiceTerm => ProjectInvoiceTermPolicy` (provider already exists; just add the entry) |
| Controller | `Modules/Project/Http/Controllers/ProjectController::showDeliveryReport` | Take `ProjectInvoiceTerm $term` via route-model-binding (currently takes `$invoiceId` and delegates to service). `$this->authorize('view', $term)` first. Stream via `Storage::disk('local')->response(...)` directly in the controller |
| Service | `Modules/Project/Services/ProjectService::showDeliveryReport` | **Delete**. File serve moves to controller. `saveOrUpdateDeliveryReport` (the writer) is unrelated and stays |
| Route | `Modules/Project/Routes/web.php:21` | Rename binding parameter for clarity (`{invoice}` → `{term}`) is optional and out of scope for this fix. Keep `{invoice}` to avoid blade churn |
| Blade | `Modules/Project/Resources/views/edit.blade.php:295`, `Modules/Project/Resources/views/subviews/edit-project-inoice-terms.blade.php:48`, `Modules/Invoice/Resources/views/index.blade.php:398`, `Modules/Invoice/Resources/views/mail/upcoming-invoice-list.blade.php:47` | All use `route('delivery-report.show', $invoice->id)` or similar. They pass the `id` integer today; after this fix they must pass the `ProjectInvoiceTerm` model (or its `uuid`). **Audit and update each call site to pass the model instance** so Laravel emits the UUID. |

> **Note on blade callers for delivery report.** Unlike the project contract case (#3820) where callers passed the model directly, the existing delivery-report callers pass `$invoice->id` (a raw integer). Once the route key changes to `uuid`, passing an integer would produce a 404. Each call site must be updated to pass the `ProjectInvoiceTerm` model instance (the same row already in scope as `$invoice` in those views) so route-model-binding resolves it to a uuid in the URL.

## Data flow (per endpoint, identical shape)

1. User clicks link → `GET /<route>/<uuid>`.
2. `auth` middleware → guest redirected to login.
3. Route-model-binding resolves the model by `uuid` → 404 if not found.
4. Controller calls `$this->authorize('view', $resource)`:
   - On deny: 403 returned; controller logs `Log::notice(...)` with user id, resource uuid (see Logging).
5. On allow: controller verifies file path is non-null and file exists on `local` disk:
   - On miss: 404 returned; controller logs `Log::warning(...)` with user id, resource uuid, path.
6. On file present: streamed response via `Storage::disk('local')->response($path, $filename, ['Content-Disposition' => 'inline; filename="…"'])`. No `file_get_contents`.

## Error handling and logging

| Case | Response | Log |
|------|----------|-----|
| Guest | 302 → login | — |
| Unknown / malformed UUID (numeric-id guess too) | 404 | — |
| Authenticated, policy denied | 403 | `Log::notice('client contract pdf access denied', [user_id, contract_uuid])` / `Log::notice('delivery report access denied', [user_id, invoice_term_uuid])` |
| `contract_file_path` / `delivery_report` is null | 404 | `Log::warning('client contract pdf missing', …)` / `Log::warning('delivery report missing', …)` |
| File not present on disk | 404 | same warning, with `path` field |
| Other storage exceptions | 500 | Sentry (default) |

Never leak file paths, filenames, or stack traces to the client. Log full context (resource uuid, user id, path) server-side.

The `Log::notice` on policy denial is **net new vs precedent** (PR #3820 only logs on missing file). Rationale: these are sensitive cross-tenant documents; if an authenticated user iterates UUIDs, log volume is the only signal we'll see.

## Migrations

Per resource, two sequential migrations (four total in this PR):

1. **A — Add nullable UUID column + backfill.**
   - Adds `uuid` (UUID type, unique, indexed, nullable, after `id`).
   - Backfills existing rows in chunks of 500 using `DB::table(...)->chunkById(...)` (raw query — does not depend on model `booted()` hooks added later in the PR).
2. **B — Tighten to NOT NULL.**
   - `Schema::table(...)->uuid('uuid')->nullable(false)->change();` (uses `doctrine/dbal`, already a transitive dependency in this codebase based on the precedent plan).

A and B run in the same `php artisan migrate` (sequential), so a single deploy is sufficient. Tables are small (internal portal). No maintenance window required.

If `client_contracts` or `project_invoice_terms` row counts are unexpectedly large (>100k) at implementation time, the chunked backfill still bounds memory; the only consideration becomes wall-clock duration of the deploy migrate step, which can be addressed by lowering chunk size or splitting the backfill into a console command run before B.

## Testing

Full feature + unit matrix for **both** resources. ~20 feature tests + ~10 policy unit tests total.

### Feature tests (per endpoint)

Mirror `Modules/Project/Tests/Feature/ContractPdfAccessTest.php`. Each endpoint:

1. Guest → 302 to `/login`.
2. Authenticated user without the resource permission → 403.
3. Authenticated, has permission, no relationship → 403.
4. Authenticated, has permission, active team member → 200, `Content-Disposition: inline`, correct content-type.
5. Authenticated, has permission, KAM → 200.
6. Authenticated, has permission, ended team member (`ended_on` set) → 403.
7. Nonexistent UUID → 404.
8. Numeric-id guess (pre-fix URL shape) → 404.
9. Authorized but file path column null → 404, warning logged.
10. Authorized but file missing on disk → 404, warning logged.

For `ClientContract` test 4 (active team member): the user must be an active member on at least one of the contract's client's projects. The test seeds: client → project (belonging to client) → contract (on client) → team member (on project, `ended_on = null`).

Use `Storage::fake('local')`, write dummy PDF bytes via `UploadedFile::fake()->create(...)`, factory rows via the new factories.

Add a feature-level assertion that `Log::notice` is captured in the 403 cases (e.g., `Log::shouldReceive('notice')->once()->with(...)` or `Log::spy()`).

### Unit tests — policy matrix (per policy)

For each of `ClientContractPolicy` and `ProjectInvoiceTermPolicy`, matrix:

- permission ∈ {true, false}
- relationship ∈ {KAM, active team member, ended team member, stranger}

Plus an explicit test for the missing-relation case (`$contract->client` null / `$term->project` null) returning false.

### Migration tests

Two short tests (one per resource): seed rows pre-migration, run migration A, assert each row has a unique non-null uuid; run migration B, assert column is `NOT NULL`.

## Risks and mitigations

- **Blade caller breakage on delivery-report side.** Existing callers pass `$invoice->id`; after the route key flips to `uuid`, integers will 404. **Mitigation:** Audit and update all four call sites (listed in the table above) within the same PR. Add a feature-test assertion that hitting one of those legitimate flows from a UI render returns 200 (or assert against the rendered href shape in a smoke test).
- **Backfill on a large table is slow.** Tables are small per current ops knowledge. `chunkById(500)` keeps memory bounded. Verify row count during implementation; if >100k, see Migrations section.
- **`doctrine/dbal` requirement for `->change()`.** Verify presence in `composer.json` before writing migration B; the precedent project-contract migration B already used this, so it should be available.
- **Two policies in one PR may diverge in implementation style.** Mitigation: implementation plan dictates a shared shape — one policy is implemented first, the second mirrors it.
- **Logging volume on `Log::notice` denials.** If an attacker iterates UUIDs, the log line is per-request. Acceptable: UUIDs are non-enumerable, so a sustained iteration attempt is itself a strong signal worth retaining. If volume becomes a concern post-deploy, reduce to sampled logging — out of scope for this fix.
- **Pre-existing duplicate policies (`ClientPolicy` lives in both `Modules/Client/Policies/` and `app/Policies/`).** Out of scope. New `ClientAuthServiceProvider` only registers `ClientContractPolicy`; the existing `ClientPolicy` discovery is unchanged.

## Rollout

1. Merge PR → single deploy.
2. Migrations run in order: client A, client B, project A, project B (or interleaved; order between resources does not matter — within each resource, A precedes B).
3. Verify post-deploy: `SELECT COUNT(*) FROM client_contracts WHERE uuid IS NULL;` and same for `project_invoice_terms` → both 0.
4. Smoke check: open one project edit page (delivery report link present) and one client edit page (contract link present), click both as a user with a relationship — both should stream PDFs.
5. Spot-check log stream for any unexpected `Log::warning('… missing')` entries triggered by background jobs touching these endpoints.
6. No cache clear, no user action required. Numeric-ID bookmarks 404 (acceptable per Non-goals).

## Out of scope / follow-ups

- Audit log of all successful PDF views (separate ticket).
- Moving these files off the `local` disk (e.g., to S3 with private ACLs).
- Sweep of other numeric-ID file-serving endpoints across the codebase.
- Removing the duplicate `ClientPolicy` and `ProjectPolicy` files (`app/Policies/` vs module `Policies/`).
- Renaming the route parameter `{invoice}` → `{term}` on the delivery-report route for clarity.

## Acceptance criteria

- [ ] UUID route key in place on `client_contracts` and `project_invoice_terms` (migrations + backfill + NOT NULL).
- [ ] `ClientContractPolicy` created, business rule per **Access rules** above, registered via new `ClientAuthServiceProvider`.
- [ ] `ProjectInvoiceTermPolicy` created, business rule per **Access rules** above, registered in existing `ProjectAuthServiceProvider`.
- [ ] `ClientController::showPdf` is an instance method, authorizes before any file read, streams via `Storage::disk('local')->response(...)`.
- [ ] `ProjectController::showDeliveryReport` takes a `ProjectInvoiceTerm` model, authorizes before any file read, streams via `Storage::disk('local')->response(...)`. `ProjectService::showDeliveryReport` removed.
- [ ] All four blade callers of `route('delivery-report.show', …)` pass the model instance (not the integer id).
- [ ] Logging: `Log::notice` on 403, `Log::warning` on missing file, both endpoints.
- [ ] Feature + unit tests cover the matrix per endpoint; full suite green.
- [ ] No view-template changes for the client contract endpoint; only the four delivery-report callers updated.
