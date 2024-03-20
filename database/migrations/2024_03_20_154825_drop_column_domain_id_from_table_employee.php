<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnDomainIdFromTableEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_domain_id_foreign');
            $table->dropColumn('domain_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('domain_id')->nullable()->after('name');
            $table->foreign('domain_id')->references('id')->on('hr_job_domains');
        });
    }
}
