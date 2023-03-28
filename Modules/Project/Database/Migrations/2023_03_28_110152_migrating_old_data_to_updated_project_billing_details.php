<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigratingOldDataToUpdatedProjectBillingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $typesData = DB::table('projects')->select('id', 'type')->get();
        $valuesData = DB::table('project_meta')->select('project_id', 'value')->get();

        foreach ($typesData as $project) {
            DB::table('project_billing_details')->where('project_id', $project->id)->update([
                'billing_frequency' => $project->type
            ]);
        }

        foreach ($valuesData as $meta) {
            DB::table('project_billing_details')->where('project_id', $meta->project_id)->update([
                'billing_level' => $meta->value
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('project_billing_details')->update([
            'billing_frequency' => null,
            'billing_level' => null
        ]);
    }
}
