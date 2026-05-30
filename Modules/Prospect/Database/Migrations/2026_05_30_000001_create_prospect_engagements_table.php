<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectEngagementsTable extends Migration
{
    public function up()
    {
        Schema::create('prospect_engagements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prospect_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('short_descriptor');
            $table->integer('year');
            $table->string('stage')->default('inquiry');
            $table->integer('owner_user_id')->unsigned()->nullable();
            $table->date('submission_due_date')->nullable();
            $table->date('proposal_sent_date')->nullable();
            $table->date('last_touch_date')->nullable();
            $table->text('next_action')->nullable();
            $table->boolean('drift_flag')->default(false);
            $table->timestamp('closed_at')->nullable();
            $table->string('close_reason')->nullable();
            $table->string('notes_path')->nullable();
            $table->timestamps();

            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('owner_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prospect_engagements');
    }
}
