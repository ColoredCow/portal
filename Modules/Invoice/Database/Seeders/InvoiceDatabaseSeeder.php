<?php

namespace Modules\Invoice\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeds the finance_invoices.* permissions AND a graph of demo invoices +
 * currency rates on top of the existing client/project/effort graph, so a
 * downstream read-only finance view can be built and verified locally.
 *
 * Runnable standalone, additively, without a full re-seed:
 *   php artisan db:seed --class="Modules\Invoice\Database\Seeders\InvoiceDatabaseSeeder"
 *
 * Amounts are inserted via the query builder (DB::table) but the encryptable
 * columns (`amount`, `amount_paid`, `sent_conversion_rate`) are wrapped in
 * Crypt::encrypt() — the SAME encryption the Invoice model's Encryptable trait
 * applies — so the seeded data matches how production stores it (AES-256-CBC,
 * serialized). `conversion_rate` (decimal) is NOT encryptable and stays plain.
 * A few legacy rows are stored as plaintext to mirror pre-Encryptable data and
 * exercise a consumer's decrypt-else-use-raw path.
 */
class InvoiceDatabaseSeeder extends Seeder
{
    /** Blended cost rate + USD->INR, mirroring the finance v1 assumptions (ADR-15). */
    const COST_RATE_USD = 50;
    const USD_INR = 83.0;

    public function run()
    {
        Model::unguard();

        $this->seedPermissions();

        // Demo DATA only outside production, and only when there are no invoices
        // yet — idempotent and non-destructive, so it is safe to run on top of an
        // existing local database.
        if (app()->environment('production')) {
            return;
        }
        if (DB::table('invoices')->exists()) {
            return;
        }

        DB::transaction(function () {
            $this->seedCurrencyRates();
            $this->seedInvoices();
        });
    }

    private function seedPermissions(): void
    {
        $permissions = [
            'finance_invoices.create',
            'finance_invoices.view',
            'finance_invoices.update',
            'finance_invoices.delete',
            'finance_invoices_settings.create',
            'finance_invoices_settings.view',
            'finance_invoices_settings.update',
            'finance_invoices_settings.delete',
        ];

        foreach ($permissions as $name) {
            Permission::updateOrCreate(['name' => $name]);
        }

        // Grant to admin + finance-manager when present. Null-guarded so a
        // standalone run can't crash if a role isn't seeded on this database.
        foreach (['admin', 'finance-manager'] as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if (! $role) {
                continue;
            }
            $role->givePermissionTo($permissions);
        }
    }

    private function seedCurrencyRates(): void
    {
        // USD averages for the last 6 months + current month, so INR normalization
        // has a fallback even for foreign invoices that carry no per-invoice rate.
        $rows = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonths($i);
            $rows[] = [
                'currency' => 'USD',
                'captured_for' => $month->toDateString(),
                'avg_rate' => self::USD_INR + (($i % 3) - 1), // ~82-84
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('currency_avg_rate')->insert($rows);
    }

    private function seedInvoices(): void
    {
        $clients = DB::table('clients')->orderBy('id')->get();
        $projects = DB::table('projects')->orderBy('id')->get();
        if ($clients->isEmpty() || $projects->isEmpty()) {
            return; // nothing to attach to
        }

        // billed hours per project = SUM(actual_effort) (per-project, ADR-14) — the cost input.
        $billedByProject = DB::table('project_team_members_effort as e')
            ->join('project_team_members as m', 'm.id', '=', 'e.project_team_member_id')
            ->select('m.project_id', DB::raw('SUM(e.actual_effort) as hours'))
            ->groupBy('m.project_id')
            ->pluck('hours', 'm.project_id');

        // Deterministic roles for the planted edge cases.
        $usdClientId = (int) $clients->first()->id;                 // one foreign-currency client
        $leakerProjectId = (int) $projects->first()->id;            // a fixed-budget leaker
        $clientLevelClientId = (int) ($clients->count() > 1 ? $clients->values()->get(1)->id : $usdClientId);

        // Make the leaker a fixed-budget project (narrative realism; leakage itself
        // is just cost > revenue, which the small invoice below guarantees).
        DB::table('projects')->where('id', $leakerProjectId)->update(['type' => 'fixed-budget']);

        $rows = [];
        $seq = 1;

        // 1) One current-month, project-level invoice per project (revenue for margin),
        //    sized as a multiple of that project's effort-cost so the sign is deterministic.
        foreach ($projects as $i => $project) {
            $isUsd = ((int) $project->client_id === $usdClientId);
            $costInr = (float) ($billedByProject[$project->id] ?? 0) * self::COST_RATE_USD * self::USD_INR;

            if ((int) $project->id === $leakerProjectId) {
                $factor = 0.4;                       // leaker: revenue well below cost
            } elseif ($i === 1) {
                $factor = 1.6;                       // clearly healthy
            } else {
                $factor = 0.9 + (($i % 4) * 0.15);   // mixed 0.90 .. 1.35
            }
            $targetInr = max(50000.0, round($costInr * $factor, -2));

            $rows[] = $this->invoiceRow($seq++, $project->client_id, $project->id, $targetInr, $isUsd, [
                'sent_on' => Carbon::today()->startOfMonth()->addDays(3)->toDateString(),
                'due_on' => Carbon::today()->startOfMonth()->addDays(33)->toDateString(),
            ]);
        }

        // 2) Receivables / aging: unpaid invoices across buckets for the first two clients.
        foreach ($clients->take(2) as $client) {
            $proj = $projects->firstWhere('client_id', $client->id);
            $isUsd = ((int) $client->id === $usdClientId);
            foreach ([15, 45, 75, 120] as $daysPastDue) {
                $rows[] = $this->invoiceRow($seq++, $client->id, optional($proj)->id, 80000.0 + $daysPastDue * 1000, $isUsd, [
                    'sent_on' => Carbon::today()->subDays($daysPastDue + 30)->toDateString(),
                    'due_on' => Carbon::today()->subDays($daysPastDue)->toDateString(),
                ]);
            }
        }

        // 3) A couple of PAID invoices (collected) for contrast with the unpaid ones.
        foreach ($clients->take(2) as $client) {
            $proj = $projects->firstWhere('client_id', $client->id);
            $isUsd = ((int) $client->id === $usdClientId);
            $rows[] = $this->invoiceRow($seq++, $client->id, optional($proj)->id, 120000.0, $isUsd, [
                'sent_on' => Carbon::today()->subDays(80)->toDateString(),
                'due_on' => Carbon::today()->subDays(50)->toDateString(),
                'payment_at' => Carbon::today()->subDays(55)->toDateString(),
                'status' => 'paid',
            ]);
        }

        // 4) One CLIENT-LEVEL invoice (project_id NULL) to exercise the billing_level split.
        $rows[] = $this->invoiceRow($seq++, $clientLevelClientId, null, 250000.0, $clientLevelClientId === $usdClientId, [
            'billing_level' => 'client',
            'sent_on' => Carbon::today()->startOfMonth()->addDays(5)->toDateString(),
            'due_on' => Carbon::today()->startOfMonth()->addDays(35)->toDateString(),
        ]);

        // 5) A couple of LEGACY plaintext invoices (pre-Encryptable era), stored
        //    unencrypted to mirror prod's mixed data and exercise a consumer's
        //    decrypt-else-use-raw path.
        foreach ($clients->slice(2, 2) as $client) {
            $proj = $projects->firstWhere('client_id', $client->id);
            $rows[] = $this->invoiceRow($seq++, $client->id, optional($proj)->id, 90000.0, false, [
                'sent_on' => Carbon::today()->subDays(200)->toDateString(),
                'due_on' => Carbon::today()->subDays(170)->toDateString(),
            ], false);
        }

        DB::table('invoices')->insert($rows);
    }

    /**
     * Build one invoice row. The encryptable columns (amount / amount_paid /
     * sent_conversion_rate) are Crypt::encrypt()ed when $encrypt is true (the
     * default — matching how the Invoice model writes production data); legacy
     * rows pass $encrypt = false to store plaintext. For the USD client the amount
     * is stored in USD and the rate is carried three ways to exercise each branch
     * of a consumer's INR normalization:
     *   seq % 3 == 0 -> per-invoice sent_conversion_rate (encrypted)
     *   seq % 3 == 1 -> decimal conversion_rate (plain)
     *   seq % 3 == 2 -> neither (forces the currency_avg_rate fallback)
     */
    private function invoiceRow(int $seq, $clientId, $projectId, float $amountInr, bool $isUsd, array $overrides, bool $encrypt = true): array
    {
        $currency = $isUsd ? 'USD' : 'INR';
        $amount = $isUsd ? round($amountInr / self::USD_INR, 2) : round($amountInr, 2);

        $sentRate = null;
        $convRate = null;
        if ($isUsd) {
            $mode = $seq % 3;
            if ($mode === 0) {
                $sentRate = self::USD_INR;
            } elseif ($mode === 1) {
                $convRate = self::USD_INR;
            }
        }

        // Encrypt the encryptable columns exactly as the Invoice model would, so the
        // seeded rows are byte-for-byte the shape production stores. conversion_rate
        // is a plain decimal column (not encryptable) and is never wrapped.
        $enc = fn ($v) => $v === null ? null : ($encrypt ? Crypt::encrypt((string) $v) : (string) $v);

        $base = [
            'invoice_number' => sprintf('INV-DEMO-%04d', $seq),
            'client_id' => $clientId,
            'project_id' => $projectId,
            'billing_level' => 'project',
            'currency' => $currency,
            'amount' => $enc($amount),
            'amount_paid' => null,
            'sent_conversion_rate' => $enc($sentRate),
            'conversion_rate' => $convRate,
            'status' => 'sent',
            'sent_on' => Carbon::today()->toDateString(),
            'due_on' => Carbon::today()->addDays(30)->toDateString(),
            'receivable_date' => null,
            'payment_at' => null,
            'reminder_mail_count' => 0,
            'payment_confirmation_mail_sent' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $row = array_merge($base, $overrides);

        // receivable_date mirrors due_on (as InvoiceService::store does).
        $row['receivable_date'] = $row['receivable_date'] ?? $row['due_on'];

        // a paid invoice has amount_paid = amount (encrypted to match).
        if (! empty($row['payment_at']) && empty($row['amount_paid'])) {
            $row['amount_paid'] = $enc($amount);
        }

        return $row;
    }
}
