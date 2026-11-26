<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameRoundNameColumnOfCodetrekApplicantRoundDetailsTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE `codetrek_applicant_round_details` CHANGE `round_name` `latest_round_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'level-1'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `codetrek_applicant_round_details` CHANGE `latest_round_name` `round_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'level-1'");
    }
}
