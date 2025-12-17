<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_health', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('project_id');
            $table->string('staging_url')->nullable();
            $table->string('onboarding_documents_url')->nullable();
            $table->boolean('has_issue_templates')->default(false);
            $table->boolean('has_unit_testing')->default(false);
            $table->boolean('has_ci_check')->default(false);
            $table->boolean('has_site_monitoring')->default(false);
            $table->boolean('has_error_logging')->default(false);
            $table->boolean('has_error_reporting')->default(false);

            $table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_health');
    }
}
