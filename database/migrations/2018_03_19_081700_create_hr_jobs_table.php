<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('posted_by');
            $table->string('link')->nullable();
            $table->string('facebook_post')->nullable();
            $table->string('twitter_post')->nullable();
            $table->string('linkedin_post')->nullable();
            $table->string('instagram_post')->nullable();
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
        Schema::dropIfExists('hr_jobs');
    }
}
