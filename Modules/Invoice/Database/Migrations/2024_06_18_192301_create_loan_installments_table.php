<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Invoice\Entities\EmployeeLoan;
use Modules\Invoice\Entities\LoanInstallment;

class CreateLoanInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->text('installment_amount');
            $table->text('remaining_amount');
            $table->date('installment_date');
            $table->foreign('loan_id')->references('id')->on('employees_loan');
            $table->timestamps();
        });

        Schema::create('loan_installments_analytics_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_installment_id');
            $table->text('installment_amount');
            $table->text('remaining_amount');
            $table->foreign('loan_installment_id')->references('id')->on('loan_installments');
            $table->timestamps();
        });

        $this->seedExistingLoansInstallment();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_installments_analytics_data');
        Schema::dropIfExists('loan_installments');
    }
    
    /**
     * Seed database with installments for existing loans.
     *
     * @return void
     */
    protected function seedExistingLoansInstallment()
    {
        $loans = EmployeeLoan::all();

        foreach ($loans as $loan) {
            $startDate = $loan->start_date;
            $remainingAmount = $loan->total_amount;
            $monthlyDeduction = $loan->monthly_deduction;
            $startDate->endOfMonth();
            while ($startDate <= today() && $remainingAmount > 0) {
                $remainingAmount -= $monthlyDeduction;
                LoanInstallment::create([
                    'loan_id' => $loan->id,
                    'installment_amount' => $remainingAmount < 0 ? $monthlyDeduction + $remainingAmount : $monthlyDeduction,
                    'remaining_amount' => $remainingAmount < 0 ? 0 : $remainingAmount,
                    'installment_date' => $startDate->endOfMonth(),
                ]);
                $startDate->addDay()->endOfMonth();
            }
        }
    }
}
