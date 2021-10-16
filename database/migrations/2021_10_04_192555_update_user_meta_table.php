<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_meta', function (Blueprint $table) {
            // Add new columns.
            $table->string('meta_key')->default(null)->after('user_id');
            $table->text('meta_value')->after('meta_key');

            // Remove column.
            $table->dropColumn('max_interviews_per_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_meta', function (Blueprint $table) {
            $table->unsignedInteger('max_interviews_per_day')->nullable()->after('user_id');
            $table->dropColumn(['meta_key', 'meta_value']);
        });
    }
}
