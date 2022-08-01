<?php

namespace Modules\Salary\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;
use App\Traits\Encryptable;

class EmployeeSalary extends Model
{
    use Encryptable;

    protected $fillable = ['employee_id', 'monthly_gross_salary'];

    protected $encryptable = ['monthly_gross_salary'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getBasicSalaryAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($this->monthly_gross_salary * $salaryConfig->basicSalary() / 100);
    }

    public function getHraAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($this->basic_salary * $salaryConfig->hra() / 100);
    }

    public function getTransportAllowanceAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($salaryConfig->transportAllowance());
    }

    public function getOtherAllowanceAttribute()
    {
        return ceil($this->monthly_gross_salary - $this->basic_salary - $this->hra - $this->transport_allowance - $this->food_allowance);
    }

    public function getFoodAllowanceAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($salaryConfig->foodAllowance());
    }

    public function getTotalSalaryAttribute()
    {
        return ceil($this->basic_salary + $this->hra + $this->transport_allowance + $this->other_allowance + $this->food_allowance);
    }

    public function getEmployeeEsiAttribute()
    {
        $salaryConfig = new SalaryConfiguration;
        if ($this->monthly_gross_salary > $salaryConfig->employeeEsiLimit()) {
            return 0;
        }

        return ceil($this->monthly_gross_salary * $salaryConfig->employeeEsi() / 100);
    }

    public function getEmployeeEpfAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($this->basic_salary * $salaryConfig->employeeEpf() / 100);
    }

    // public function getTdsAttribute()
    // {

    // }

    public function getTotalDeductionAttribute()
    {
        return ceil($this->employee_esi + $this->employee_epf + $this->food_allowance);
    }

    public function getNetPayAttribute()
    {
        return ceil($this->total_salary - $this->total_deduction);
    }

    public function getEmployerEsiAttribute()
    {
        $salaryConfig = new SalaryConfiguration;
        if ($this->monthly_gross_salary > $salaryConfig->employerEsiLimit()) {
            return 0;
        }

        return ceil($this->monthly_gross_salary * $salaryConfig->employerEsi() / 100);
    }

    public function getEmployerEpfAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($this->basic_salary * $salaryConfig->employerEpf() / 100);
    }

    public function getAdministrationChargesAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil($this->basic_salary * $salaryConfig->administrationCharges() / 100);
    }

    public function getEdliChargesAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return ceil(min($this->basic_salary * $salaryConfig->edliCharges() / 100, $salaryConfig->edliChargeslimit() * $salaryConfig->edliCharges() / 100));
    }

    public function getCtcAttribute()
    {
        return ceil($this->total_salary + $this->employer_esi + $this->employer_epf + $this->administration_charges + $this->edli_charges);
    }

    public function getCtcAnnualAttribute()
    {
        return $this->ctc * 12;
    }

    public function getHealthInsuranceAttribute()
    {
        $salaryConfig = new SalaryConfiguration;

        return $salaryConfig->healthInsurance();
    }

    public function getCtcAggreedAttribute()
    {
        return $this->ctc_annual + $this->health_insurance;
    }
}
