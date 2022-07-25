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
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('basic_salary');
        return $basicSalaryConfig->percentage_rate;
     }

     public function getMedicalAllowanceAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('medical_allowance');
        return $basicSalaryConfig->percentage_rate;
    }

    public function getEmployeeEsiAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('employee_esi');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getEmployerEsiAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('employer_esi');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getTransportAllowanceAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('transport_allowance');
        return $basicSalaryConfig->fixed_amount;        
    }

    public function getEmployeeEsiLimitAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('employee_esi_limit');
        return $basicSalaryConfig->fixed_amount;        
    }

    public function getEdliChargeslimitAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('edli_charges_limit');
        return $basicSalaryConfig->fixed_amount;        
    }

    public function getHraAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('hra');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getEmployeeEpfAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('employee_epf');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getEmployerEpfAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('employer_epf');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getAdministrationChargesAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('administration_charges');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getEdliChargesAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('edli_charges');
        return $basicSalaryConfig->percentage_rate;        
    }

    public function getFoodAllowanceAttribute()
    {
        $basicSalaryConfig = SalaryConfiguration::formatAll()->get('food_allowance');
        return $basicSalaryConfig->fixed_amount; 
    }

}
