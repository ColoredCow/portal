<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrUniversitiesContactsTable extends Migration
{
    public function up()
    {
        Schema::create('hr_universities_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->foreignId('hr_university_id')->constrained('hr_universities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hr_universities_contacts');
    }
}
