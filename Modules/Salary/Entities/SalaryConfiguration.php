<?php

namespace Modules\Salary\Entities;

use Illuminate\Database\Eloquent\Model;

class SalaryConfiguration extends Model
{
    protected $guarded = [];

    public static function formatAll()
    {
        return self::all()->keyBy('slug');
    }

    public function basicSalary()
    {
        $basicSalaryConfig = $this->formatAll()->get('basic_salary');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function medicalAllowance()
    {
        $basicSalaryConfig = $this->formatAll()->get('medical_allowance');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function employeeEsi()
    {
        $basicSalaryConfig = $this->formatAll()->get('employee_esi');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function employerEsi()
    {
        $basicSalaryConfig = $this->formatAll()->get('employer_esi');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function transportAllowance()
    {
        $basicSalaryConfig = $this->formatAll()->get('transport_allowance');

        return $basicSalaryConfig->fixed_amount;
    }

    public function employeeEsiLimit()
    {
        $basicSalaryConfig = $this->formatAll()->get('employee_esi_limit');

        return $basicSalaryConfig->fixed_amount;
    }

    public function edliChargeslimit()
    {
        $basicSalaryConfig = $this->formatAll()->get('edli_charges_limit');

        return $basicSalaryConfig->fixed_amount;
    }

    public function hra()
    {
        $basicSalaryConfig = $this->formatAll()->get('hra');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function employeeEpf()
    {
        $basicSalaryConfig = $this->formatAll()->get('employee_epf');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function employerEpf()
    {
        $basicSalaryConfig = $this->formatAll()->get('employer_epf');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function administrationCharges()
    {
        $basicSalaryConfig = $this->formatAll()->get('administration_charges');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function edliCharges()
    {
        $basicSalaryConfig = $this->formatAll()->get('edli_charges');

        return $basicSalaryConfig->percentage_rate / 100;
    }

    public function foodAllowance()
    {
        $basicSalaryConfig = $this->formatAll()->get('food_allowance');

        return $basicSalaryConfig->fixed_amount;
    }
}
