# ColoredCow Portal — Platform Upgrade Plan & Roadmap

**Laravel 8 → 13, PHP 7.4 → 8.3, MySQL 5.7 → 8.0, Vue 2 → 3, Bootstrap 4 → 5, Laravel Mix → Vite**

> Status: Draft for review · Owner: Engineering · Last updated: 2026-06-05
>
> 🗑️ **One-time-use document.** This plan exists solely to drive this upgrade. **Delete `docs/upgrade_plan.md` once the upgrade is complete and production is running the target stack** (Laravel 13 / PHP 8.3 / MySQL 8 / Vite). Before removing it, fold any lasting runbook content (OS / runtime / DB steps) into the permanent docs (`docs/deployment.md`, `docs/prerequisites.md`).
>
> ⚠️ **Accuracy & verification.** This plan is a point-in-time assessment compiled from an automated codebase audit and external research as of June 2026, and may not be fully accurate or complete. **The owner/executor must independently verify the current state of each area — installed versions, package compatibility, server configuration, and per-version breaking changes — at the time of the actual upgrade.** Treat every version number, package target, and finding here as a starting point to confirm, not a guarantee. Confirm exact compatible releases on Packagist/npm and re-check each Laravel upgrade guide when you begin each phase, because the ecosystem moves.

---

## 1. Executive summary

The portal runs **Laravel 8.83.29** (final v8) on **PHP 7.4**, with a Vue 2.6 / Bootstrap 4 / Laravel Mix frontend, deployed by SSH to a self-managed Ubuntu server, against a **MySQL 5.7** database **shared with the `coloredcow-os-platform` service**. Every layer is end-of-life.

- **Target end state:** Laravel **13.x** on **PHP 8.3**, MySQL **8.0**, Vue **3**, Bootstrap **5**, built with **Vite** on Node **24 LTS**.
- **Why Laravel 13:** Laravel 11 is already EOL (Mar 2026) and 12 EOLs Feb 2027; **13 is supported through ~Mar 2028**. It is the only landing point with real runway. ([support policy](https://laravel.com/docs/13.x/releases) · [endoflife.date](https://endoflife.date/laravel))
- **How we get there:** a **linear, phase-by-phase upgrade performed on staging** (one major Laravel version at a time, 8→9→10→11→12→13, plus OS/DB and frontend), then a **single all-at-once production cutover** once the full chain is proven green on staging. The phases are designed to be **AI-accelerated** — fast, gated steps rather than a slow crawl (see §2 → *Why incremental — even with AI*).

### How to use this document

- **§3 — Execution roadmap (staging)** is the **spine**: do the phases in order, top to bottom. Each phase has a goal, concrete action items, and a verification checklist to pass before moving on. **An executor starts at Phase 0.**
- **§4 — Production cutover** is the single release at the end.
- **§5–§8 + appendices** are **reference**: current-state detail, the full dependency matrix, and the risk register that the phases link into.

### Roadmap at a glance

| Phase | What | Where | Size |
|---|---|---|---|
| **0** | Preparation (cleanup, tests, factories) — *still on Laravel 8* | staging + CI | M |
| **1** | Staging server baseline: PHP 8.1/8.2/8.3 side-by-side, MySQL 8, Node 24 | staging | M |
| **2** | Laravel 8 → 9 | staging | L |
| **3** | Laravel 9 → 10 | staging | M |
| **4** | Laravel 10 → 11 | staging | M–L |
| **5** | Laravel 11 → 12 | staging | S |
| **6** | Laravel 12 → 13 | staging | S–M |
| **7** | Frontend: Vue 3 / Bootstrap 5 / Vite *(can run in parallel from Phase 1)* | staging | L |
| **8** | Full staging regression + cutover rehearsal | staging | S |
| **★** | **Production cutover** — OS + DB + code, all at once | production | — |

> **Parallelization:** the roadmap is written so **one person can follow it linearly**. If you have capacity, **Phase 7 (frontend)** is independent of the Laravel version and can be done in parallel by a second person any time after Phase 1 — it just has to land before Phase 8.

---

## 2. Before you start — ground rules

1. **Branch model.** Create a long-lived `feature/laravel-upgrade` branch off `develop`. Each phase is **one PR** into that branch (reviewable, revertible). Rebase onto `develop` periodically so it doesn't drift from ongoing feature work.
2. **Staging is the proving ground.** Production is NOT touched until every phase below is green on staging. Then production gets one coordinated release (§4).
3. **The database is shared — coordinate.** The `coloredcow-os-platform` (Django) service uses this same MySQL DB. **Never run `migrate:fresh`** against staging/production. It owns the `osp_*` tables. Any migration that **renames/drops/restructures** columns on `prospects`, `prospect_comments`, `prospect_insights`, `clients`, `projects`, `invoices`, `users` must be flagged to the platform team in lockstep. Additive changes are safe. The **MySQL 8 upgrade must be validated by both services** (Phase 1).
4. **Verify at execution.** Versions in this doc are guidance — confirm each package's compatible release on Packagist/npm when you reach its phase (`composer why-not laravel/framework <target>`).
5. **Tooling you can lean on:** [Laravel Shift](https://laravelshift.com) for mechanical per-version diffs; [Laravel Boost](https://github.com/laravel/boost) (`/upgrade-laravel-v13`) for the 12→13 step. Manual + official upgrade guides remain the backbone because of the module system and custom packages.

### Why incremental — even with AI in the loop

A fair question: since an AI assistant can write the diffs, update the tests, and apply each upgrade guide, why not do a single 8→13 jump and test once at the end? Because **AI lowers the *cost* of the work, not the *risk structure* of the change.** Four constraints don't go away:

- **Composer must resolve a working graph.** A one-shot 8→13 update must satisfy all ~30 third-party packages against Laravel 13 *simultaneously*; if an abandoned/lagging package (`jgrossi/corcel`, `jordikroon/google-vision`, `codegreencreative/laravel-samlidp`, the PDF stack) has no L13 release, the graph **won't resolve at all** — and no AI can publish a compatibility a maintainer never shipped. Stepping finds each package's breaking point against a working baseline.
- **Failure localization.** A regression in a big-bang spans 5 framework versions + PHP + MySQL + the frontend at once; stepping pins it to one rung. A large AI-generated diff is *harder* to bisect, not easier.
- **Verification is the bottleneck, and the net is thin** (~114 tests, 1 Cypress spec). The most trustworthy check is *differential* — does the upgraded app behave like the old one? — which needs incremental reference points. AI-written tests for legacy behaviour can silently encode existing bugs as "correct."
- **Tight feedback loops are AI-optimal too.** Claude is most reliable with `change → run tests → observe → fix`. A five-version one-shot with no intermediate feedback is exactly where an AI errs.

So the model is **AI-accelerated incremental**: keep the rungs and their checkpoints, but let AI compress each into hours instead of days. Big-bang would only be defensible if *every* dependency already had an L13 release **and** a strong characterization suite existed first — neither holds here. The single "thorough test at the end" still happens (Phase 8); incremental just adds cheap, localized confidence on the way there.

### Testing, CI & module sanity (closes every phase)

Each phase closes with **two gates** — automated first, then manual.

**Gate 1 — Automated (CI).** The upgrade branch runs the existing GitHub Actions (`unit-testing.yml`, `integration-testing.yml`, `coding-standards.yml`) as the objective gate: the full **PHPUnit suite + Larastan + PHP-CS-Fixer/Pint** must be green before manual QA and before a phase PR merges. **CI is upgraded *with* the app, not left behind** — Phase 0 unifies it onto one PHP matrix, Phase 1 switches its MySQL service image to **8.0** and PHP to **8.1**, and each Laravel phase bumps the CI PHP version in lockstep (**8.2** at Phase 4, **8.3** at Phase 6); Phase 7 adds the Vite / Node 24 build.

**Test code will need updating — budget for it.** This is not just the harness:
- **PHPUnit majors:** 9 → 10/11 (Phase 4) needs `--migrate-configuration` *and* data providers converted to `public static`; → 12 (Phase 6) needs doc-comment annotations (`@test`, `@dataProvider`, `@depends`) replaced with attributes (`#[Test]`, `#[DataProvider]`, `#[Depends]`).
- **Framework test helpers:** assertion/method renames and deprecations across versions (follow each upgrade guide). Tests that assert changed behaviour may need real edits, not just renames.
- The expanded **Phase 0** suite is the regression net that makes all of this safe — which is why coverage comes first.

**Gate 2 — Module sanity (manual, on staging).** After CI is green and the phase is deployed to staging, smoke-test the core business areas. This is the **module sanity set** that every phase checklist below refers to:

| Business area | Code module(s) | Smoke check |
|---|---|---|
| **Finance** | `Invoice`, `Payment`, `Salary` | Generate an invoice (with PDF), record a payment, run a salary/payslip calc |
| **Hiring** | `HR` | Create a job/applicant, advance recruitment stages, generate an offer/joining letter (PDF) |
| **Project** | `Project`, `EffortTracking`, `ProjectContract` | Create/edit a project, log effort / sync the effort sheet, open the project dashboard |
| **Sales / Prospects** | `Prospect`, `SalesAutomation`, `Client` | Create a prospect, add a comment/insight, link/convert to a client |
| **User management** | `User` + Spatie permissions | Google OAuth login, role/permission gate enforcement, user CRUD |

> **Finance, Sales/Prospects, and User management touch the platform-shared tables** (`invoices`, `prospects`, `clients`, `users`) — sanity here doubles as shared-DB validation. After any DB-touching phase, have the platform team re-confirm its reads/writes.

---

## 3. Execution roadmap (staging)

> **Execution model: AI-accelerated, but still gated.** These phases are meant to be driven largely by Claude/an AI assistant — the mechanical diffs, test updates, and per-version guide application are fast, so expect to run **several phases back-to-back in a session**, not a months-long crawl. What stays fixed is the *gating*: do them **in order**, and each phase's exit checklist (green CI + the module sanity set, §2) must pass on staging before the next begins. **Speed comes from compressing each step; safety comes from never skipping a checkpoint.** Rationale: §2 → *Why incremental — even with AI*.

### Phase 0 — Preparation · Size: M · *App stays on Laravel 8*

**Goal:** Remove known landmines and build a test safety net **before** changing any framework version. Everything here is safe on Laravel 8.

**Action items**
1. **Unify CI on one PHP version + bump actions.** Align `unit-testing.yml` (7.4), `integration-testing.yml` (8.2), `coding-standards.yml` (7.4) onto a single matrix; bump `shivammathur/setup-php`, `actions/checkout@v4`, `codecov-action@v4`.
2. **Expand the test safety net** *(highest-leverage task in the whole plan)*. Today: ~114 PHPUnit methods (mostly `app/` + HR) and 1 Cypress spec — too thin for 18 modules. Add Feature tests for: Google OAuth login, invoice generation, salary/payment, effort-sheet sync, HR recruitment + PDF letters, prospect/client CRUD, role/permission gates.
3. **Remove dead packages** (all confirmed unused): `laravelcollective/html` (+ the `Form`/`HTML` aliases at `config/app.php:197,200`), `consoletvs/charts` (+ its git `repositories` block in `composer.json`), `bordoni/phpass`.
4. **Migrate factories to class-based** and drop `laravel/legacy-factories`. Convert the 22 old-style `$factory->define()` factories (6 in `database/factories`, ~16 in modules). Preserve `faker_locale => en_IN`. (Class factories work on Laravel 8, so this ships now.)
5. **PDF stack decision.** Standardize on **one pure-PHP renderer** (DomPDF or mPDF) and **drop `wkhtmltopdf` + `h4cc/wkhtmltopdf-amd64` + Snappy** — the binary is archived, amd64-only, and won't survive the OS upgrade. Re-test HR offer-letter output (`app/Helpers/FileHelper.php`, `Modules/HR/.../ApplicationController.php`).
6. **Prove the app on PHP 8.1 (code level).** Temporarily raise the `composer.json` platform pin and get the suite green on **8.1 in CI** while still on Laravel 8 — this separates "PHP problems" from "Laravel problems."
7. **Add runtime pins:** `.nvmrc` (Node 24) and document target PHP in `composer.json` `config.platform`.
8. **Seed a realistic staging DB** snapshot from production (respecting the shared `osp_*` tables); document the refresh procedure.

**✅ Exit checklist**
- [ ] Full PHPUnit suite green on **PHP 8.1**, Laravel 8.
- [ ] Critical-flow Feature tests added per module; coverage not dropping.
- [ ] `laravelcollective/html`, `consoletvs/charts`, `bordoni/phpass` removed; app boots.
- [ ] All 22 factories class-based; `laravel/legacy-factories` removed.
- [ ] PDF generation works through the chosen pure-PHP renderer; wkhtmltopdf gone.
- [ ] Staging DB seeded and refreshable.

---

### Phase 1 — Staging server baseline (OS / runtime / DB) · Size: M

**Goal:** Bring the **staging server** onto a modern runtime baseline that can host every later phase, *without breaking the still-Laravel-8 app*. New runtimes are installed **side-by-side** so switching is reversible.

**Prerequisites:** Phase 0 complete (app is 8.1-ready at the code level).

**Action items**
1. **Install PHP side-by-side** via the maintained repo:
   ```
   sudo add-apt-repository ppa:ondrej/php && sudo apt update
   sudo apt install php8.1-fpm php8.1-cli php8.1-mysql php8.1-gd php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip php8.1-bcmath php8.1-intl
   # repeat for php8.2-* and php8.3-* (you'll switch the active version as Laravel advances)
   ```
   (`ext-gd` is the only hard `composer.json` requirement; the rest are standard Laravel needs. Add `php8.x-redis` only if Redis is used.)
2. **Switch staging's active PHP to 8.1.** Point nginx `fastcgi_pass` (or Apache handler) at `php8.1-fpm.sock`; `update-alternatives --set php /usr/bin/php8.1`; update the **cron** scheduler line (`* * * * * /usr/bin/php8.1 .../artisan schedule:run`) and any **supervisor** queue workers; reload services.
3. **Install Node 24 LTS** (nvm or NodeSource); confirm `.nvmrc` is honored. (Laravel Mix still builds here via the existing `--openssl-legacy-provider` flag — leave it until Phase 7.)
4. **Stand up MySQL 8** (target 8.0, consider 8.4 LTS): dump the staging DB and restore into a fresh MySQL 8 instance (cleaner + reversible than in-place). **Coordinate with the platform team** — both services must pass against MySQL 8. Check the common breakages:
   - **`sql_mode` / `ONLY_FULL_GROUP_BY`** — audit `GROUP BY` queries (raw SQL, `Report`/`EffortTracking` modules).
   - **`caching_sha2_password`** default auth plugin — ensure the app's DB user authenticates (PHP 8.x mysqlnd handles it; legacy clients may need `mysql_native_password`).
   - **Reserved words** (`rank`, `groups`, `lead`, …) and **utf8mb4 collation** consistency across the shared tables (avoid "illegal mix of collations" on joins).
5. **Point staging at MySQL 8**; update the staging deploy workflow **and the CI workflows** (MySQL service image → 8.0, CI PHP → 8.1) for the new runtime.

**✅ Exit checklist**
- [ ] Laravel 8 app loads on staging on **PHP 8.1** (FPM, CLI, cron, queues all on 8.1).
- [ ] Full PHPUnit suite green **against the MySQL 8 instance**.
- [ ] Platform team confirms `osp_*` / shared-table reads & writes work on MySQL 8.
- [ ] PHP 8.2 and 8.3 installed and ready to switch to.
- [ ] Node 24 active; staging deploy workflow updated.

---

### Phase 2 — Laravel 8 → 9 (the big one) · Size: L · *active PHP 8.1*

**Goal:** Cross the largest breaking-change boundary in the ladder. ([L9 upgrade guide](https://laravel.com/docs/9.x/upgrade))

**Action items**
1. Bump `laravel/framework` → `^9.0`; let the cascade pull `guzzlehttp/guzzle` ^7, `doctrine/dbal` ^3, `league/flysystem` ^3, Symfony 6.
2. **Remove `fideloper/proxy`:** change `app/Http/Middleware/TrustProxies.php` to `extends Illuminate\Http\Middleware\TrustProxies`.
3. **Ignition:** remove `facade/ignition`, add `spatie/laravel-ignition` ^1.
4. **Move `resources/lang` → `lang/`** (4 root files). Module lang dirs are loaded by `nwidart` and are unaffected — but verify translations still resolve.
5. **Verify (low-risk, transparent):** mail (3 standard Mailables → Symfony Mailer; check `config/mail.php` transport keys), filesystem (standard disks → Flysystem 3; ensure `league/flysystem-aws-s3-v3` ^3 for S3), pagination (add `Paginator::useBootstrapFour()` only if Bootstrap pagination is rendered).
6. **Bump packages unlocking at L9** (verify each on Packagist): `nwidart/laravel-modules` ^9 · `spatie/laravel-permission` ^5 · `laravel/ui` ^4 · `nunomaduro/collision` ^6 · `nunomaduro/larastan` → **`larastan/larastan` ^2** (renamed) · `barryvdh/laravel-snappy` ^1 *(if PDF still uses it)* · confirm L9 releases of `owen-it/laravel-auditing`, `sentry/sentry-laravel`, `revolution/laravel-google-sheets`, `jordikroon/google-vision`, `jgrossi/corcel`. (Full matrix: §7.)

**⚠️ Watch closely:** `jgrossi/corcel` (WordPress/Eloquent coupling — test the HR `JobObserver` sync and `RemoveUserFromWebsite` listener end-to-end), Google Sheets effort sync, Vision OCR.

**✅ Exit checklist**
- [ ] App boots (`php artisan route:list` clean); full suite green; larastan clean.
- [ ] Corcel / Google Sheets / Vision / PDF flows smoke-tested on staging.
- [ ] No shared-table schema change (or flagged to platform team if any).
- [ ] CI green on PHP 8.1; **module sanity set (§2) passes** — esp. Finance (invoice PDF), Hiring (offer letter), Sales/Prospects.

---

### Phase 3 — Laravel 9 → 10 · Size: M · *active PHP 8.1*

**Goal:** Mostly mechanical; tighten types. ([L10 upgrade guide](https://laravel.com/docs/10.x/upgrade))

**Action items**
1. Bump `laravel/framework` → `^10.0`; `nunomaduro/collision` ^7; `spatie/laravel-permission` → `^6`; `nwidart/laravel-modules` ^10; larastan to its L10 line.
2. **Native return types:** the skeleton adds them — match types on any overridden framework methods in `app/` (providers, middleware).
3. Replace deprecated `$dates` model property with `$casts` (`'col' => 'datetime'`) where present.

**✅ Exit checklist**
- [ ] App boots; full suite green; larastan clean.
- [ ] CI green on PHP 8.1; **module sanity set (§2) passes**.

---

### Phase 4 — Laravel 10 → 11 (structural) · Size: M–L · *switch active PHP → 8.2*

**Goal:** Cross the structural boundary while minimizing churn. ([L11 upgrade guide](https://laravel.com/docs/11.x/upgrade))

**Action items**
1. **Switch staging active PHP to 8.2** (FPM/CLI/cron/supervisor) — L11 requires 8.2.
2. Bump `laravel/framework` → `^11.0`; `nwidart/laravel-modules` ^11; `nunomaduro/collision` ^8; re-verify `owen-it/laravel-auditing` (v14 line, drops PHP < 8.2) and `sentry/sentry-laravel`.
3. **Keep the classic skeleton.** L11 introduces a slim `bootstrap/app.php` skeleton (no `Http`/`Console` Kernel), but **existing apps may keep the old structure** — recommended here given 18 modules + custom providers. Adopt the slim skeleton later as optional cleanup.
4. **PHPUnit 10/11:** run `vendor/bin/phpunit --migrate-configuration` to update `phpunit.xml`, **convert data providers to `public static`** (required in PHPUnit 10), and bump **CI PHP to 8.2**. Test-code changes start landing here — see §2.
5. **Carbon 3** unlocks (`nesbot/carbon` ^3) — review the ~33 Carbon usages (notably `EffortTracking`); L11 also tolerates Carbon 2, so this can lag if needed.
6. Drop `doctrine/dbal` where possible (L11 has native schema methods).

**✅ Exit checklist**
- [ ] Staging on **PHP 8.2**; app boots; `phpunit.xml` migrated; full suite green.
- [ ] Date/time-heavy flows (effort sheets, invoices, scheduling) QA'd for Carbon changes.
- [ ] CI green on **PHP 8.2**; **module sanity set (§2) passes**.

---

### Phase 5 — Laravel 11 → 12 · Size: S · *active PHP 8.2*

**Goal:** Small, maintenance-oriented step. ([L12 upgrade guide](https://laravel.com/docs/12.x/upgrade))

**Action items**
1. Bump `laravel/framework` → `^12.0`; `nwidart/laravel-modules` ^12; bump dev tooling.

**✅ Exit checklist**
- [ ] App boots; full suite green. CI green on PHP 8.2; **module sanity set (§2) passes**.

---

### Phase 6 — Laravel 12 → 13 · Size: S–M · *switch active PHP → 8.3*

**Goal:** Reach the target. ([L13 upgrade guide](https://laravel.com/docs/13.x/upgrade)) — consider driving this with [Laravel Boost](https://github.com/laravel/boost) `/upgrade-laravel-v13`.

**Action items**
1. **Switch staging active PHP to 8.3** (FPM/CLI/cron/supervisor) — L13 requires 8.3.
2. Bump `laravel/framework` → `^13.0`, `laravel/tinker` → `^3.0`, `phpunit/phpunit` → `^12.0`, `nwidart/laravel-modules` ^13. **PHPUnit 12 removes doc-comment annotations** — convert `@test`/`@dataProvider`/`@depends` to attributes (`#[Test]`/`#[DataProvider]`/`#[Depends]`). Bump **CI PHP to 8.3**.
3. **CSRF middleware renamed** `VerifyCsrfToken` → `PreventRequestForgery` (adds `Sec-Fetch-Site` origin checks). Update `app/Http/Middleware/VerifyCsrfToken.php` and any test `withoutMiddleware([...])` references (deprecated aliases exist but update them).
4. **⚠️ `laravel/helpers` ↔ polyfill conflict:** L13 pulls `symfony/polyfill-php85`, which defines global `array_first()`/`array_last()` — semantics differ from the `laravel/helpers` versions this app depends on. Grep for `array_first(`/`array_last(`, switch to `Arr::first()`/`Arr::last()`, and consider dropping `laravel/helpers` entirely.
5. **Cache hardening:** L13 sets `serializable_classes => false` — allow-list any classes you cache as PHP objects.

**✅ Exit checklist**
- [ ] Staging on **PHP 8.3**; app boots; full suite green on PHPUnit 12.
- [ ] CSRF-protected POST flows verified; no `array_first`/`array_last` ambiguity.
- [ ] CI green on **PHP 8.3**; **module sanity set (§2) passes**. **Backend is now on Laravel 13.**

---

### Phase 7 — Frontend modernization · Size: L · *(independent — parallelizable from Phase 1)*

**Goal:** Vue 2→3, Bootstrap 4→5, Laravel Mix→Vite. Independent of the Laravel version (Mix builds regardless), so this can run as a parallel track by a second developer; in a single-threaded plan, do it here, before cutover.

**Action items (sub-steps, in order)**
1. **Mix → Vite:** add `vite`, `laravel-vite-plugin`, `@vitejs/plugin-vue`; author `vite.config.js` with a multi-entry `input` covering the root + 18 per-module bundles (currently 19 `webpack.mix.js` files); replace `mix()` in Blade with `@vite([...])`; convert `require('./x.vue').default` to ES `import`; **remove `--openssl-legacy-provider`** and switch scripts to `vite` / `vite build`; remove `laravel-mix`, `webpack`, `vue-template-compiler`.
2. **Vue 2 → 3:** use `@vue/compat` to run hybrid, then remove compat. Fix in `resources/js/app.js`: 19 `Vue.component()` → `app.component()`; `new Vue({el})` → `createApp().mount()`; 1 `Vue.filter('str_limit')` → method/computed. Bump `vue-toastification` → ^2; **replace `laue`** (no Vue 3 chart support; e.g., vue-chartjs/ECharts); remove unused `@cubejs-client/*` or bump if reactivated.
3. **Bootstrap 4 → 5:** ~143 jQuery/BS4 call sites. BS5 drops jQuery: `data-toggle`→`data-bs-toggle`, `data-target`→`data-bs-target`, `.modal('hide')`→`bootstrap.Modal.getInstance(el).hide()`, utility renames (`ml-*/mr-*`→`ms-*/me-*`, `*-left/right`→`*-start/end`). Decouple/remove jQuery where Bootstrap was its only consumer.
4. **JS deps:** `chart.js` 3→4, `axios` 0.21→1.x, `eslint` 7→9 + `eslint-plugin-vue` ^9.
5. Switch the staging build/deploy to `npm run build` (Vite).

**✅ Exit checklist**
- [ ] Vite build produces all bundles; `mix()`/Mix fully removed; openssl hack gone.
- [ ] All 29 Vue components render and function on Vue 3.
- [ ] Every Bootstrap modal/tooltip/dropdown re-tested (jQuery removal is the most regression-prone change).
- [ ] Cypress/e2e for top journeys pass.
- [ ] **Module sanity set (§2)** re-checked in the browser — each area's key screens render and submit.

---

### Phase 8 — Full staging regression + cutover rehearsal · Size: S

**Goal:** Prove the **complete** target stack on staging and rehearse production.

**Action items**
1. Confirm staging is the full target: **Laravel 13 + PHP 8.3 + MySQL 8 + Vite/Vue 3/Bootstrap 5 + Node 24**.
2. Full regression: entire PHPUnit suite + Cypress + a complete per-module manual QA pass.
3. Platform team re-confirms shared-DB behavior on the final stack.
4. **Rehearse the production cutover** (§4) on staging end-to-end; time it; finalize the rollback runbook.

**✅ Exit checklist**
- [ ] All automated suites green (CI on **PHP 8.3 + MySQL 8**); **full module sanity set (§2)** signed off by module owners (Finance, Hiring, Project, Sales/Prospects, User mgmt).
- [ ] Cutover steps rehearsed and timed; rollback runbook validated.
- [ ] Go/no-go decision recorded.

---

## 4. Production cutover (single, all-at-once release)

Because staging has proven the entire chain, production goes from Laravel 8 → 13 — **OS, DB, and code together — in one maintenance window**. No incremental production deploys.

**Pre-cutover checklist**
- [ ] Server has PHP 8.3 + extensions installed **side-by-side** with 7.4.
- [ ] MySQL 8 validated by **both** the portal and the platform team (or scheduled as step 3 below).
- [ ] Node 24 on the build host; deploy workflow uses Vite (`npm ci && npm run build`).
- [ ] **Full DB backup/snapshot** ready; release tagged; feature freeze on `main` during the window.
- [ ] Rollback runbook reviewed; stakeholders notified.

**Cutover sequence**
1. `php artisan down` (maintenance mode).
2. Final DB backup/snapshot.
3. MySQL 5.7 → 8.0 cutover (if not already migrated ahead of the window).
4. Switch PHP-FPM + CLI + cron + supervisor to **8.3**.
5. Deploy the upgrade branch; `composer install --no-dev --optimize-autoloader`.
6. `npm ci && npm run build` (Vite).
7. `php artisan migrate --force`.
8. `php artisan config:cache route:cache view:cache`.
9. `php artisan up`; run the production smoke checklist.

**Rollback**
- **Code/runtime:** switch PHP-FPM back to 7.4 and check out the previous release tag (keep the prior release dir intact) — fast.
- **Database:** if migrations ran, restore from the pre-cutover snapshot (step 2). Coordinate with the platform team — shared DB. Define a documented **point of no return** beyond which forward-fix is preferred.

**Post-cutover cleanup.** Once production has run stably on the target stack for an agreed bake-in period, **delete this document (`docs/upgrade_plan.md`)** — it is one-time-use. Fold any lasting runbook content into the permanent docs first.

---

# Reference

*The phases above link into the detail below. This half of the document is the gap analysis and look-up tables, not a sequence to execute.*

## 5. Current-state assessment

> *Snapshot from an automated audit on 2026-06-05. Re-verify the actual installed versions and configuration in each environment (local / staging / production) before acting — they may have drifted since, or differ from CI.*

### 5.1 Backend (locked versions)

| Component | Current | Notes |
|---|---|---|
| `laravel/framework` | **8.83.29** | Final Laravel 8 release |
| PHP | **7.4** | `composer.json` platform-pinned to 7.4; dev machines already run 8.3 |
| Symfony components | 5.4 | Laravel 8 baseline |
| `guzzlehttp/guzzle` | 6.5.8 | Needs 7.x |
| `nesbot/carbon` | 2.72 | Carbon 3 unlocks at L11 |
| `doctrine/dbal` | 2.13 | Needs 3.x at L10 |
| `phpunit/phpunit` | 9.6 | Needs 12.x at L13 |
| `nunomaduro/larastan` | **0.7.15** | Ancient; renamed to `larastan/larastan` |
| Modules | 18 under `Modules/` | `nwidart/laravel-modules` 7.4 |
| Composer | 2.2.23 | OK |

### 5.2 Frontend

| Component | Current | Notes |
|---|---|---|
| Vue | 2.6 | EOL; 29 single-file components |
| Bootstrap | 4.4 | EOL; ~143 jQuery/BS4 call sites |
| Build | Laravel Mix 5 + webpack | 19 `webpack.mix.js` (root + per module) |
| jQuery | 3.5 | Tightly coupled to Bootstrap 4 JS |
| Node hack | `--openssl-legacy-provider` | In all `npm` scripts |

### 5.3 Runtime / infrastructure

- **Deploy:** GitHub Actions → `appleboy/ssh-action` → SSH into **Ubuntu**. `git pull` + `composer install --no-dev` + `npm run production` + `artisan migrate --force` + caches. (`.github/workflows/{production,staging}-deployment.yml`)
- **No Docker.** Runtime = whatever is installed on the server.
- **CI inconsistency:** `unit-testing.yml` & `coding-standards.yml` → PHP **7.4**; `integration-testing.yml` → PHP **8.2**; all → MySQL **5.7**.
- **Scheduler:** 14 scheduled tasks in `app/Console/Kernel.php` → a server `schedule:run` cron entry must be re-pointed at the new PHP binary.

### 5.4 Shared-database constraint

See §2 rule 3. The `coloredcow-os-platform` (Django) service shares this MySQL DB, owns `osp_*` tables, and reads/writes `prospects`, `prospect_comments`, `prospect_insights`, `clients`, `projects`, `invoices`, `users`. No `migrate:fresh`; flag shared-table schema changes; coordinate the MySQL 8 upgrade.

### 5.5 Risk inventory — abandoned / blocking packages (from audit)

| Package | State | Exposure | Action (phase) |
|---|---|---|---|
| `laravelcollective/html` | Abandoned, breaks at L11 | **Unused** — aliases at `config/app.php:197,200`, no provider, 0 Blade uses | Remove (P0) |
| `fideloper/proxy` | Merged into framework at L9 | `app/Http/Middleware/TrustProxies.php:5`; `Kernel.php:21` | Re-point + remove (P2) |
| `fzaninotto/faker` | Replaced by `fakerphp/faker` at L9 | 22 old-style factories | Replace (P0) |
| `laravel/legacy-factories` | Bridge package | 6 + ~16 module factories | Convert + remove (P0) |
| `facade/ignition` | Becomes `spatie/laravel-ignition` at L9 | dev-only, no custom config | Swap (P2) |
| `h4cc/wkhtmltopdf-amd64` | Archived binary, amd64-only | OS binary behind Snappy | Remove (P0) |
| `barryvdh/laravel-snappy` | Needs ^1 for L9+ | Provider `config/app.php:166`, `PDF` alias `:221` | Consolidate PDF (P0) |
| `niklasravnsborg/laravel-pdf` | Verify L9+ | `app/Helpers/FileHelper.php:5,93`; HR letters | Consolidate (P0) |
| `consoletvs/charts` | Abandoned (custom git repo) | No usage | Remove (P0) |
| `bordoni/phpass` | `dev-main` pin | No usage | Remove (P0) |
| `jgrossi/corcel` | Targets L8; WP coupling | 9 files (HR `JobObserver`, `WebsiteUserService`, …) | Test each phase (P2+) |
| `revolution/laravel-google-sheets` | Verify per version | `EffortTracking/.../EffortTrackingService.php:14` | Verify each phase |
| `codegreencreative/laravel-samlidp` | Verify | `samlidp` disk in `config/filesystems.php`; no code refs | Confirm in use, else remove |
| `jordikroon/google-vision` | Verify Google-client compat | `app/Services/BookServices.php:5-7` (OCR) | Verify each phase |

### 5.6 What the audit cleared (low risk)

- **Mail:** 3 standard Mailables, no `Swift_*` → Symfony Mailer migration transparent.
- **Filesystem:** standard disks only, no custom Flysystem drivers.
- **Exception handler:** `app/Exceptions/Handler.php` uses `Throwable`; only Sentry customization.
- **Artisan:** 27 commands, modern `$signature` + `int` returns.
- **PHP 8 syntax:** no curly-brace access, no `each()`/`create_function()`, no obvious dynamic-property abuse; only `ext-gd` required.

---

## 6. Target state

| Layer | Target | Minimum |
|---|---|---|
| Framework | Laravel **13.x** | — |
| PHP | **8.3** | L13 requires 8.3+ (supports 8.3/8.4/8.5) |
| Symfony | 7.x | L11+ |
| Database | MySQL **8.0** (or 8.4 LTS) | utf8mb4, coordinated with platform |
| Node | **24 LTS** (Active LTS → Apr 2028) | drop `--openssl-legacy-provider`; **22 LTS** = conservative fallback (→ Apr 2027); **20 is EOL** |
| Build | **Vite** + `laravel-vite-plugin` | replaces Laravel Mix |
| Vue | **3.x** | `@vue/compiler-sfc` |
| CSS framework | **Bootstrap 5.x** | jQuery decoupled |
| Tests | PHPUnit **12** | L13 |
| Static analysis | `larastan/larastan` ^3 + Pint | renamed |

---

## 7. Dependency compatibility matrix

> Bump progressively at the phase that unlocks each. **Verify exact releases on Packagist/npm at execution.**

### Composer (production)

| Package | Current | Target | Unlock phase / action |
|---|---|---|---|
| php | 7.4 | **8.3+** | progressive: 8.1 (P1) → 8.2 (P4) → 8.3 (P6) |
| laravel/framework | 8.83 | **^13.0** | ladder P2–P6 |
| laravel/tinker | 2.10 | ^3.0 | P6 |
| laravel/socialite | 5.16 | ^5.x (current) | keep updated |
| laravel/ui | 3.4 | ^4.x | P2 |
| laravel/helpers | ^1.1 | **review / remove** | P6 (polyfill conflict) |
| laravel/legacy-factories | 1.1 | **remove** | P0 |
| nwidart/laravel-modules | 7.4 | **^13.0** | bump each phase (version parity) |
| spatie/laravel-permission | 3.18 | ^6.x | ^5 (P2) → ^6 (P3) |
| owen-it/laravel-auditing | 13.6 | ^14.x (verify) | P2 / P4 |
| maatwebsite/excel | 3.1.61 | ^3.1.69+ | supports L13; patch bump |
| nesbot/carbon | 2.72 | ^3.x | P4 |
| barryvdh/laravel-snappy | 0.4.7 | ^1.x **or remove** | P0 decision |
| niklasravnsborg/laravel-pdf | 4.1 | upgrade **or consolidate** | P0 decision |
| h4cc/wkhtmltopdf-amd64 | 0.12 | **remove** | P0 |
| sentry/sentry-laravel | 4.13 | latest (verify L13) | per phase |
| jgrossi/corcel | 5.0 | verify per Laravel | **test each phase** |
| revolution/laravel-google-sheets | 5.6 | verify per Laravel | per phase |
| codegreencreative/laravel-samlidp | 5.0 | verify **or remove** | confirm SAML usage |
| jordikroon/google-vision | 1.8 | verify | per phase |
| google/apiclient | 2.10 | ^2.x | OK |
| aws/aws-sdk-php | 3.121 | ^3.x | OK |
| guzzlehttp/guzzle | 6.5 | ^7.x | P2 |
| doctrine/dbal | 2.13 | ^3.x (or drop) | P2; drop at P4 |
| fideloper/proxy | 4.0 | **remove** | P2 (built-in) |
| laravelcollective/html | 6.2 | **remove** | P0 (unused) |
| consoletvs/charts | custom | **remove** | P0 (unused) |
| bordoni/phpass | dev-main | **remove if unused** | P0 |

### Composer (dev)

| Package | Current | Target | Action |
|---|---|---|---|
| phpunit/phpunit | 9.6 | ^12.0 | P6 (migrate config at P4) |
| nunomaduro/larastan | 0.7.15 | **larastan/larastan ^3** | renamed; P2 |
| nunomaduro/collision | 5.0 | ^8.x | P2→P4 |
| fzaninotto/faker | 1.4 | **fakerphp/faker ^1.x** | P0 |
| facade/ignition | 2.3 | **spatie/laravel-ignition** (then built-in) | P2 |
| friendsofphp/php-cs-fixer | 3.13 | ^3.x (or adopt **Pint**) | keep |
| barryvdh/laravel-debugbar | 3.2 | ^3.x | keep |
| nunomaduro/phpinsights | 2.8 | ^2.x (verify) | keep |
| mockery/mockery | ^1.0 | ^1.x | keep |

### npm

| Package | Current | Target | Phase |
|---|---|---|---|
| vue | 2.6 | ^3.x | P7 |
| vue-template-compiler | 2.6 | **remove** (`@vue/compiler-sfc`) | P7 |
| bootstrap | 4.4 | ^5.x | P7 |
| jquery | 3.5 | decouple/remove | P7 |
| laravel-mix | 5.0 | **remove → Vite** | P7 |
| vite + laravel-vite-plugin + @vitejs/plugin-vue | — | add | P7 |
| vue-toastification | 1.7 | ^2.x | P7 |
| laue | 0.2 | **replace** (no Vue 3) | P7 |
| chart.js | 3.5 | ^4.x | P7 |
| @cubejs-client/core + /vue | 0.28 | remove (unused) or bump | P7 |
| axios | 0.21 | ^1.x | P7 |
| eslint (+ plugin-vue) | 7 / 7 | ^9 / ^9 | P7 |
| node | (hack) | **24 LTS** | P1 / P7 |

---

## 8. Risk register

| Risk | Likelihood | Impact | Mitigation |
|---|---|---|---|
| MySQL 8 `ONLY_FULL_GROUP_BY` / collation breaks queries | High | High | Test suite + report QA against MySQL 8 staging from Phase 1 |
| Shared-DB coordination gap with platform team | Medium | High | Joint MySQL 8 validation; flag any shared-table schema change |
| `jgrossi/corcel` (WordPress) incompatibility at L9+ | Medium | High | Test HR `JobObserver` + website-user sync each phase; budget a decouple fallback |
| Sparse tests miss a regression | Medium | High | Phase 0 coverage expansion is a prerequisite, not optional |
| PHPUnit major-version test-code migration underestimated | Medium | Medium | Treat as phase work: static data providers (P4), annotations → attributes (P6); see §2 |
| Bootstrap 4→5 jQuery removal regressions (143 sites) | High | Medium | Dedicated Phase 7 + full visual QA of every interactive component |
| Long-lived upgrade branch drifts from `develop` | Medium | Medium | Per-phase PRs + scheduled rebases |
| wkhtmltopdf binary fails on new OS | High | Medium | Drop it in Phase 0 (pure-PHP renderer) |
| `laravel/helpers` ↔ L13 polyfill `array_first` semantics | Low | Medium | Migrate to `Arr::first/last`; drop the package (Phase 6) |
| PDF / Google Sheets / Vision third-party gaps | Medium | Medium | Verify each on Packagist per phase; have fallbacks |
| Single big-bang prod cutover failure | Low | High | Staging proves the full chain first; side-by-side runtimes + DB snapshot enable fast rollback |

---

## Appendix A — Reference links

- Laravel upgrade guides: [9.x](https://laravel.com/docs/9.x/upgrade) · [10.x](https://laravel.com/docs/10.x/upgrade) · [11.x](https://laravel.com/docs/11.x/upgrade) · [12.x](https://laravel.com/docs/12.x/upgrade) · [13.x](https://laravel.com/docs/13.x/upgrade)
- [Laravel support/EOL policy](https://laravel.com/docs/13.x/releases) · [endoflife.date/laravel](https://endoflife.date/laravel)
- [Laravel Shift](https://laravelshift.com) · [Laravel Boost](https://github.com/laravel/boost)
- [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules) · [Bootstrap 5 migration](https://getbootstrap.com/docs/5.3/migration/) · [Vue 3 migration](https://v3-migration.vuejs.org/) · [Laravel Mix → Vite](https://github.com/laravel/vite-plugin/blob/main/UPGRADE.md)

## Appendix B — Per-phase PR checklist (template)

```
[ ] Bump composer.json (framework + packages unlocking this phase — see §7)
[ ] composer update; resolve conflicts (composer why-not laravel/framework <v>)
[ ] Apply upgrade-guide code changes for this version
[ ] php artisan config:clear && route:list (boots clean)
[ ] vendor/bin/phpunit (full suite green)
[ ] vendor/bin/phpstan analyse (no new errors)
[ ] php-cs-fixer / Pint clean
[ ] Deploy to staging; per-module manual smoke signed off
[ ] (DB-touching) suite passes against MySQL 8; shared-table changes flagged to platform team
[ ] PR reviewed + merged into feature/laravel-upgrade
```

## Appendix C — Codebase audit snapshot (2026-06-05)

- 114 PHP files in `app/`; ~901 across 18 modules; 409 Blade templates; 29 Vue SFCs.
- 22 old-style factories (6 in `database/factories`, ~16 in modules) + 30 class-based.
- ~143 jQuery/Bootstrap-4 JS call sites; 19 `webpack.mix.js` files.
- ~114 PHPUnit test methods across 24 files; 1 Cypress spec.
- 27 Artisan commands; 14 scheduled tasks.
- Abandoned/blocking packages and exact locations: see §5.5.
