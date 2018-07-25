<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNumberOfCopies extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('library_books', function (Blueprint $table) {
			$table->unsignedInteger('number_of_copies')->default(1)->after('isbn');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('library_books', function (Blueprint $table) {
			$table->dropColumn(['number_of_copies']);
		});
	}
}
