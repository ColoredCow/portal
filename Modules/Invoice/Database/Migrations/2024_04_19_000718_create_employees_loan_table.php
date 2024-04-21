<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateEmployeesLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_loan', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->text('total_amount');
            $table->text('monthly_deduction');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees');
        });

        Schema::create('employees_loan_analytics_encrypted_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->text('total_amount');
            $table->text('monthly_deduction');
            $table->timestamps();
            $table->foreign('loan_id')->references('id')->on('employees_loan');
        });

        $employeeLoanPermissions = [
            ['name' => 'employee_loan.view'],
            ['name' => 'employee_loan.create'],
            ['name' => 'employee_loan.update'],
            ['name' => 'employee_loan.delete'],
        ];

        foreach ($employeeLoanPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_loan_analytics_encrypted_data');
        Schema::dropIfExists('employees_loan');
    }
}
