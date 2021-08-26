<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRepositoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'project_repositories',
			function ( Blueprint $table )
            {
				$table->id();
				$table->unsignedBigInteger('project_id');
				$table->string('url');
				$table->timestamps();
				$table->foreign('project_id')->references('id')->on('projects');
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
    {
		Schema::dropIfExists('project_repositories');
	}
}
