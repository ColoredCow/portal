<?php

namespace Modules\Salary\Entities;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;

class EmployeeSalary extends Model
{
    use Encryptable;

    protected $guarded = [];

    protected $dates = ['commencement_date'];

    protected $encryptable = ['monthly_gross_salary', 'tds', 'monthly_fee'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getMonthlyGrossSalaryAttribute($monthlyGrossSalary)
    {
        if (is_null($monthlyGrossSalary) || empty($monthlyGrossSalary)) {
            return 0;
        }

        $decryptedMonthlyGrossSalary = $monthlyGrossSalary !== null && $monthlyGrossSalary !== '' ? $this->decryptValue($monthlyGrossSalary) : 0;

        return (float) $decryptedMonthlyGrossSalary;
    }

    public function getBasicSalaryAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $basicSalaryPercentageFactor = $salaryConf->basicSalary();
        $grossSalary = $this->monthly_gross_salary ?? 0;

        return ceil(((int) $grossSalary) * $basicSalaryPercentageFactor);
    }

    public function getHraAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $hraConf = $salaryConf->formatAll()->get('hra');
        $grossSalary = $this->monthly_gross_salary ?? 0;

        $multiplier = (int) $this->gross_salary;

        if ($hraConf->percentage_applied_on == 'basic_salary') {
            $multiplier = $this->basic_salary;
        }

        $percentageRate = (float) $hraConf->percentage_rate;

        return ceil($multiplier * $percentageRate / 100);
    }

    public function getTransportAllowanceAttribute()
    {
        if (! $this->monthly_gross_salary) {
            return 0;
        }

        $salaryConf = new SalaryConfiguration;
        $transportAllowanceConf = $salaryConf->formatAll()->get('transport_allowance');

        return (int) ($transportAllowanceConf->fixed_amount ?? 0);
    }

    public function getFoodAllowanceAttribute()
    {
        if (! $this->monthly_gross_salary) {
            return 0;
        }
        $salaryConf = new SalaryConfiguration;
        $foodAllowanceConf = $salaryConf->formatAll()->get('food_allowance');

        return (int) ($foodAllowanceConf->fixed_amount ?? 0);
    }

    public function getOtherAllowanceAttribute()
    {
        return (float) $this->monthly_gross_salary - $this->basic_salary - $this->hra - $this->transport_allowance - $this->food_allowance;
    }

    public function getTotalSalaryAttribute()
    {
        if ($this->salary_type === config('salary.type.contractor_fee.slug')) {
            return $this->monthly_fee;
        }

        return $this->basic_salary + $this->hra + $this->transport_allowance + $this->food_allowance + $this->other_allowance;
    }

    public function getEmployeeEsiAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $employeeEsiLimitConf = $salaryConf->formatAll()->get('employee_esi_limit');
        $employeeEsiConf = $salaryConf->formatAll()->get('employee_esi');

        if ($this->monthly_gross_salary < ((int) ($employeeEsiLimitConf->fixed_amount ?? 0))) {
            $percentageRate = (float) $employeeEsiConf->percentage_rate;

            return ceil($this->monthly_gross_salary * $percentageRate / 100);
        }

        return 0;
    }

    public function getEmployeeEpfAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $employeeEpfConf = $salaryConf->formatAll()->get('employee_epf');

        $multiplier = $this->monthly_gross_salary;

        if ($employeeEpfConf->percentage_applied_on == 'basic_salary') {
            $multiplier = $this->basic_salary;
        }
        $percentageRate = (float) $employeeEpfConf->percentage_rate;

        return ceil($multiplier * $percentageRate / 100);
    }

    public function getTotalDeductionAttribute()
    {
        if ($this->salary_type === config('salary.type.contractor_fee.slug')) {
            return $this->employee->loan_deduction_for_month + $this->tds;
        }

        return $this->employee_esi + $this->employee_epf + $this->food_allowance + $this->employee->loan_deduction_for_month + $this->tds;
    }

    public function getNetPayAttribute()
    {
        return $this->total_salary - $this->total_deduction;
    }

    public function getEmployerEsiAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $employerEsiLimitConf = $salaryConf->formatAll()->get('employer_esi_limit');
        $employerEsiConf = $salaryConf->formatAll()->get('employer_esi');

        if ($this->monthly_gross_salary <= ((int) $employerEsiLimitConf->fixed_amount ?? 0)) {
            $percentageRate = (float) $employerEsiConf->percentage_rate;

            return ceil($this->monthly_gross_salary * $percentageRate / 100);
        }

        return 0;
    }

    public function getEmployerEpfAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $employerEpfConf = $salaryConf->formatAll()->get('employer_epf');

        $multiplier = $this->monthly_gross_salary;
        if ($employerEpfConf->percentage_applied_on == 'basic_salary') {
            $multiplier = $this->basic_salary;
        }

        $percentageRate = (float) $employerEpfConf->percentage_rate;

        return ceil($multiplier * $percentageRate / 100);
    }

    public function getAdministrationChargesAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $administrationChargesConf = $salaryConf->formatAll()->get('administration_charges');

        $multiplier = $this->monthly_gross_salary;
        if ($administrationChargesConf->percentage_applied_on == 'basic_salary') {
            $multiplier = $this->basic_salary;
        }

        $percentageRate = (float) $administrationChargesConf->percentage_rate;

        return ceil($multiplier * $percentageRate / 100);
    }

    public function getEdliChargesAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $edliChargesConf = $salaryConf->formatAll()->get('edli_charges');
        $edliChargesLimitConfig = $salaryConf->formatAll()->get('edli_charges_limit');

        $multiplier = $this->monthly_gross_salary;
        if ($edliChargesConf->percentage_applied_on == 'basic_salary') {
            $multiplier = $this->basic_salary;
        }
        $percentageRate = (float) $edliChargesConf->percentage_rate;

        return min(ceil($multiplier * $percentageRate / 100), ceil(((int) ($edliChargesLimitConfig->fixed_amount ?? 0)) * $percentageRate / 100));
    }

    public function getCtcAttribute()
    {
        if (! $this->monthly_gross_salary) {
            return 0;
        }

        return ceil($this->monthly_gross_salary + $this->employer_esi + $this->employer_epf + $this->administration_charges + $this->edli_charges);
    }

    public function getCtcAnnualAttribute()
    {
        if ($this->salary_type === config('salary.type.contractor_fee.slug')) {
            return $this->monthly_fee * 12;
        }

        return $this->ctc * 12;
    }

    public function getHealthInsuranceAttribute()
    {
        $salaryConf = new SalaryConfiguration;
        $healthInsuranceConf = $salaryConf->formatAll()->get('health_insurance');

        if ($this->monthly_gross_salary === '' || $this->employer_esi !== 0 || $this->employee_esi !== 0) {
            return 0;
        }

        return (int) $healthInsuranceConf->fixed_amount;
    }

    public function getTotalHealthInsuranceAttribute()
    {
        return $this->health_insurance * (optional($this->employee->user->profile)->insurance_tenants ?? 1);
    }

    public function getCtcAggregatedAttribute()
    {
        if ($this->salary_type === config('salary.type.contractor_fee.slug')) {
            return $this->monthly_fee * 12;
        }

        return $this->ctc_annual + $this->total_health_insurance;
    }
}
