<?php

namespace Modules\Salary\Services;

use Modules\Salary\Entities\SalaryConfiguration;
use Modules\Salary\Entities\EmployeeSalary;
use Carbon\Carbon;
use Modules\HR\Entities\Employee;

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

    public function appraisalLetterData($request, $employee){

        $fetchEmployeeSalarydetails = $this->employeeSalaryDetails($request, $employee);
        $fetchEmployeeDetails = $this->employeeDetails($employee);
        $employeeName = $employee->name;
        $currentDate = Carbon::now()->format('jS, M Y');
        $grossSalary = (int)$request->grossSalary;
        $commencementDate = Carbon::parse($request->commencementDate)->format('jS F Y');
        $basicSalary = (int)ceil($this->basicSalary());
        $hra = (int)ceil($this->hra());
        $transportAllowance = (int)$this->salaryConfig->get('transport_allowance')->fixed_amount;
        $otherAllowance = $this->employeeOtherAllowance($grossSalary);
        $employeeShare = $this->employeeShare($fetchEmployeeSalarydetails);
        $annualCTC = $this->employeeAnnualCTC($fetchEmployeeSalarydetails);
        $previousSalary = $this->employeePreviousSalary($fetchEmployeeDetails);
        $salaryIncreasePercentage = $this->salaryIncreasePercentage($fetchEmployeeDetails);

        $data = (object) [
            'employeeName' => $employeeName,
            'date' => $currentDate,
            'grossSalary' => $grossSalary,
            'commencementDate' => $commencementDate,
            'basicSalary' => $basicSalary,
            'hra' => $hra,
            'tranportAllowance' => $transportAllowance,
            'otherAllowance' => $otherAllowance,
            'employeeShare' => $employeeShare,
            'annualCTC' => $annualCTC,
            'previousSalary' => $previousSalary,
            'salaryIncreasePercentage' => $salaryIncreasePercentage
        ];
        return $data;

    }

    public function employeeOtherAllowance($grossSalary){
        return $grossSalary - (int)ceil($this->basicSalary()) - (int)ceil($this->hra()) -(int)$this->salaryConfig->get('transport_allowance')->fixed_amount - (int)$this->salaryConfig->get('food_allowance')->fixed_amount;
    }

    public function employeeSalaryDetails($request, $employee){
        $employeeSalaryDetails = new EmployeeSalary([
            'employee_id' => $employee->id,
            'monthly_gross_salary' => $request->grossSalary,
            'commencement_date' => $request->commencementDate,
        ]);
        return $employeeSalaryDetails;
    }

    public function employeeShare($fetchEmployeeSalarydetails){
        $epfShare = (int)$fetchEmployeeSalarydetails->getEmployeeEpfAttribute();
        $edliShare = (int)$fetchEmployeeSalarydetails->getEdliChargesAttribute();
        $administrationShare = (int)$fetchEmployeeSalarydetails->getAdministrationChargesAttribute();

        $totalShare = $epfShare + $edliShare + $administrationShare;
        return $totalShare;
    }

    public function employeeAnnualCTC($fetchEmployeeSalarydetails){
        $employeeAnnualCTC = (int)$fetchEmployeeSalarydetails->getCtcAnnualAttribute();
        return $employeeAnnualCTC;
    }

    public function employeeDetails($employee){
        $employeeDetails = new Employee([
            'user_id' => $employee->id,
            'name' => $employee->name,
            'staff_type' => 'Employee',
        ]);
        return $employeeDetails;
    }

    public function employeePreviousSalary($employeeDetails){
        $employeePreviousCTC = (int)$employeeDetails->getPreviousSalary();
        return $employeePreviousCTC;
    }

    public function salaryIncreasePercentage($employeeDetails){
        $employeeIncreasePercentage = (int)$employeeDetails->getLatestSalaryPercentageIncrementAttribute();
        return $employeeIncreasePercentage;
    }

}
