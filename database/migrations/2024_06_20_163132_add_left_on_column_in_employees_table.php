<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\HR\Entities\Employee;

class AddLeftOnColumnInEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('termination_date')->nullable()->after('joined_on');
        });

        $inactiveEmployees = Employee::with('user')->whereHas('user', function ($query) {
            return $query->withTrashed()->whereNotNULL('deleted_at');
        })->get();

        foreach ($inactiveEmployees as $employee) {
            $employee->update([
                'termination_date' => $employee->user()->withTrashed()->first()->deleted_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['termination_date']);
        });
    }
}
