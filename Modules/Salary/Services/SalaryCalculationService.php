<?php

namespace Modules\Salary\Services;

use Modules\Salary\Entities\SalaryConfiguration;

class SalaryCalculationService
{
    protected $grossSalary;

    public function __construct($grossSalary)
    {
        $this->grossSalary = $grossSalary;
        $this->salaryConfig = SalaryConfiguration::formatAll();
    }

    public function basicSalary()
    {
        $basicSalaryConfig = $this->salaryConfig->get('basic_salary');
        $percentage = $basicSalaryConfig->percentage_rate;

        return $this->grossSalary * $percentage / 100;
    }

    public function hra()
    {
        $basicSalaryConfig = $this->salaryConfig->get('hra');
        $percentage = $basicSalaryConfig->percentage_rate;

        return $this->basicSalary() * $percentage / 100;
    }
}
