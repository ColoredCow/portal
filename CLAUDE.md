# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

ColoredCow Portal is an internal employee portal built with **Laravel 8** (PHP 7.4+), **Vue.js 2.6**, and **Bootstrap 4.4**. It uses **MySQL 5.7+** and authenticates via **Google OAuth** (Laravel Socialite) with GSuite domain restriction.

## Common Commands

### Development Server
```sh
php artisan serve          # Start Laravel dev server
npm run watch              # Watch and compile assets (JS/SASS)
npm run dev                # One-time development build
```

### Testing
```sh
vendor/bin/phpunit                    # Run all PHPUnit tests
vendor/bin/phpunit --filter=TestName  # Run a specific test
npm run cypress                       # Run Cypress e2e tests (headless)
npm run cypress-open                  # Run Cypress in GUI mode
```

### Linting & Code Style
```sh
# PHP - PSR-12 via PHP-CS-Fixer (auto-runs on pre-commit via Husky)
php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --diff
php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --dry-run --verbose --diff  # dry run

# JS/Vue - ESLint with airbnb-base (auto-runs on pre-commit via Husky)
./node_modules/.bin/eslint resources/js/ Modules/*/Resources/assets/js/ --ext .js,.vue --fix

# Static analysis - Larastan (NOT auto-triggered on commit)
./vendor/bin/phpstan analyse

# Run all pre-commit fixers manually on staged files
npx lint-staged
```

### Database
```sh
php artisan migrate              # Run migrations
php artisan migrate:rollback     # Rollback last migration batch
php artisan db:seed              # Run seeders
```

## Architecture

### Modular Structure (nwidart/laravel-modules)

The app is organized into **25+ feature modules** under `Modules/`. Each module is self-contained with its own Controllers, Models, Routes, Views, Assets, Migrations, Seeders, and Tests.

Key modules: `User`, `HR`, `Invoice`, `Project`, `Client`, `Salary`, `Payment`, `EffortTracking`, `SalesAutomation`, `Communication`, `CodeTrek`, `Prospect`, `Report`, `AppointmentSlots`.

**When working in a specific module, create migrations and seeders inside that module's directory**, not in the root `database/` directory.

Each module compiles its own JS/CSS bundle via `webpack.mix.js` (e.g., `Modules/HR/Resources/assets/js/app.js` → `public/js/hr.js`).

### Core App Layer (`app/`)

- `Services/` — Business logic (GSuiteUserService, EmployeeService, etc.)
- `Models/` — Eloquent models (core, non-module models)
- `Policies/` — Authorization policies
- `Observers/` — Model event observers
- `Traits/` — Shared functionality
- `Helpers/` — Helper functions

### Authorization

Uses **Spatie Laravel Permission** for role-based access control (RBAC). Authorization policies live in `app/Policies/`.

### Key Integrations

- **Google OAuth** — Primary authentication via Socialite
- **GSuite/Google API** — Calendar, user sync
- **AWS SES** — Email delivery
- **Sentry** — Error tracking
- **owen-it/laravel-auditing** — Model change auditing
- **Maatwebsite Excel** — Spreadsheet import/export

## Shared database — `coloredcow-os-platform` (MCP service)

A separate service, [`coloredcow-os-platform`](https://github.com/ColoredCow/coloredcow-os-platform), connects to **this same MySQL database** to expose portal data to Claude over MCP (reads + structured writes), authenticated via Google sign-in. It is decoupled from this codebase but shares the database, so two things matter when working here:

- **`osp_*` tables belong to that service.** It creates and owns `osp_audits` and `osp_oauth_kv` (plus its own `django_migrations`) via its own migrations — Laravel does **not** manage them. Don't treat them as orphans or drop them; they're not part of any Laravel migration. (And never run `php artisan migrate:fresh` against a shared/production database — it would drop them along with everything else.)
- **Flag schema changes to the shared tables.** That service reads/writes a fixed set of existing tables: `prospects`, `prospect_comments`, `prospect_insights`, `clients`, `projects`, `invoices`, `users`. If a migration here **renames, drops, or restructures columns** on any of those, note it in the PR so the platform's data models can be updated in lockstep — otherwise its read/write tools break silently. Additive changes (new columns) are safe.

## Branch Naming Convention

- `feature/{issue-id}/{description}` — New features (base: `develop`)
- `bugfix/{issue-id}/{description}` — Bug fixes (base: `develop`)
- `hotfix/{description}` — Urgent production fixes (base: `main`)
- `doc/{description}` — Documentation changes (base: `develop`)

Production branch is `main`. Development branch is `develop`.

## Naming Conventions

- **PHP**: variables/functions in `camelCase`, classes in `TitleCase`
- **Blade**: variables in `camelCase`, CSS classes in `snake-case`, IDs in `camelCase`
- **JavaScript**: CSS classes in `snake-case`, IDs in `camelCase`
- **Routes & DB tables**: Follow standard Laravel conventions

## CI/CD

GitHub Actions workflows in `.github/workflows/`:
- `unit-testing.yml` — PHPUnit tests (PHP 7.4, MySQL 5.7)
- `coding-standards.yml` — PHP-CS-Fixer + ESLint validation
- `integration-testing.yml` — Integration tests
- `staging-deployment.yml` / `production-deployment.yml` — Deployments

## Configuration

- Timezone: `Asia/Kolkata`
- `.env.example` has ~140 environment variables
- `.env.testing` configures test database (`portal_test`)
- `config/constants.php` holds app-specific constants
- `config/google.php` holds Google API config

## Custom Agents

Custom agents are defined in `.claude/agents/`. They are automatically invoked based on your request.

| Agent | When to Use |
|-------|-------------|
| implementation-planner | When the user asks for an implementation plan, technical breakdown, or task planning for a feature or issue. Explores the codebase, creates a phased plan with 4-hour task breakdowns, and posts it as a GitHub issue comment. |
| implementation-executor | When the user wants to execute an existing implementation plan — reads the plan from a GitHub issue, implements each task sequentially, commits after each task, pushes, and opens a PR. |
| business-analyst | When the user shares rough or ambiguous requirements and needs them refined into clear, business-readable, testable requirement docs without technical implementation details. |
