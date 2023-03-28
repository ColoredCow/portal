<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
        $projects = DB::table('projects')->select('id', 'billing_frequency')->get();
        $projects_meta = DB::table('project_meta')->select('project_id', 'value')->get();
        
        foreach ($projects as $project) {
            DB::table('project_billing_details')->where('project_id', $project->id)->update([
                'billing_frequency' => $project->billing_frequency
            ]);
        }

        foreach ($projects_meta as $meta) {
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
        //
    }
}
