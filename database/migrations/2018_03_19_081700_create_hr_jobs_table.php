<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('link');
            $table->string('facebook_post');
            $table->string('twitter_post');
            $table->string('linkedin_post');
            $table->string('instagram_post');
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
