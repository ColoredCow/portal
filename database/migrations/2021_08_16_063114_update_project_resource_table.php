<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });
        Schema::rename( 'project_resource', 'project_resources' );
        Schema::table('project_resources', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_resources', function (Blueprint $table) {
            $table->dropForeign('project_resources_resource_id_foreign');
            $table->dropIndex('project_resources_resource_id_foreign');
            $table->dropForeign('project_resources_project_id_foreign');
            $table->dropIndex('project_resources_project_id_foreign');
        });
        Schema::rename( 'project_resources', 'project_resource' );
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->change();
        });
    }
}
