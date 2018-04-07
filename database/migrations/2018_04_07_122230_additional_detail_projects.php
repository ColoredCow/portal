<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalDetailProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type')->nullable()->after('status');
            $table->date('end_date')->nullable()->after('type');
            $table->decimal('cost', 10, 2)->nullable()->after('end_date');
            $table->boolean('gst_applicable')->default(false)->after('cost');
            $table->boolean('cost_include_gst')->default(false)->after('gst_applicable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'end_date',
                'cost',
                'gst_applicable',
                'cost_include_gst'
            ]);
        });
    }
}
