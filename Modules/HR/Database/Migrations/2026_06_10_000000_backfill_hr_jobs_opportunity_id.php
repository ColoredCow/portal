<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillHrJobsOpportunityId extends Migration
{
    /**
     * Known WordPress post ID mappings, keyed by exact job title.
     *
     * @var array<string, int>
     */
    private $mappings = [
        'UI-UX Designer' => 6139,
        'Internship' => 500,
    ];

    /**
     * Run the migrations.
     *
     * Backfills hr_jobs.opportunity_id with the matching WordPress post ID,
     * matched by exact title (case-insensitive, trimmed), ONLY for rows whose
     * opportunity_id is currently 0 or null. Existing non-zero values are never
     * overwritten, which also makes this migration safe to re-run.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->mappings as $title => $opportunityId) {
            DB::table('hr_jobs')
                ->whereRaw('LOWER(TRIM(title)) = ?', [mb_strtolower(trim($title))])
                ->where(function ($query) {
                    $query->whereNull('opportunity_id')
                        ->orWhere('opportunity_id', 0);
                })
                ->update(['opportunity_id' => $opportunityId]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * Resets opportunity_id back to 0 only for the rows this migration set
     * (matched title still carrying the exact value we wrote).
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->mappings as $title => $opportunityId) {
            DB::table('hr_jobs')
                ->whereRaw('LOWER(TRIM(title)) = ?', [mb_strtolower(trim($title))])
                ->where('opportunity_id', $opportunityId)
                ->update(['opportunity_id' => 0]);
        }
    }
}
