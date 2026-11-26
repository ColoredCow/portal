<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameRoundNameColumnOfCodeTrekApplicantsTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE `code_trek_applicants` CHANGE `round_name` `latest_round_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'level-1'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `code_trek_applicants` CHANGE `latest_round_name` `round_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'level-1'");
    }
}
