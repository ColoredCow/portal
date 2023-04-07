<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_locations', function (Blueprint $table) {
            $table->id();  // Primary key, auto increment
            $table->string('centre_name');  // VARCHAR
            $table->unsignedBigInteger('centre_head');  // Integer (Foreign key to user_id)
            $table->integer('capacity');  // Integer
            $table->integer('current_people_count')->default(0);  // Integer with default value 0
            $table->timestamp('created_on')->nullable();  // Timestamp, nullable
            $table->timestamp('updated_on')->nullable();  // Timestamp, nullable
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
        Schema::dropIfExists('office_locations');
    }
}
