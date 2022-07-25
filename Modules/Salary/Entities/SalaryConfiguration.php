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

    public function getBasicSalaryAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('basic_salary');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getMedicalAllowanceAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('medical_allowance');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getEmployeeEsiAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('employee_esi');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getEmployerEsiAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('employer_esi');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getTransportAllowanceAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('transport_allowance');

        return $basicSalaryConfig->fixed_amount;
    }

    public function getEmployeeEsiLimitAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('employee_esi_limit');

        return $basicSalaryConfig->fixed_amount;
    }

    public function getEdliChargeslimitAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('edli_charges_limit');

        return $basicSalaryConfig->fixed_amount;
    }

    public function getHraAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('hra');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getEmployeeEpfAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('employee_epf');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getEmployerEpfAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('employer_epf');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getAdministrationChargesAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('administration_charges');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getEdliChargesAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('edli_charges');

        return $basicSalaryConfig->percentage_rate;
    }

    public function getFoodAllowanceAttribute()
    {
        $basicSalaryConfig = self::formatAll()->get('food_allowance');

        return $basicSalaryConfig->fixed_amount;
    }
}
