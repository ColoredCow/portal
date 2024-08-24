<?php

namespace Modules\Salary\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Modules\HR\Entities\Employee;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\Salary\Entities\SalaryConfiguration;
use Modules\User\Entities\User;
use Modules\User\Entities\UserProfile;

class SalaryCalculationService
{
    protected $grossSalary;
    protected $salaryConfig;

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

    public function appraisalLetterData($request, $employee)
    {
        $fetchEmployeeSalarydetails = $this->employeeSalaryDetails($request, $employee);
        $fetchEmployeeDetails = $this->employeeDetails($employee);
        $commencementDate = Carbon::parse($request->commencementDate)->format('jS F Y');
        $employeeName = $employee->name;
        $employeeFirstName = explode(' ', $employeeName)[0];
        $currentDate = Carbon::now()->format('jS, M Y');
        $grossSalary = (int) $request->grossSalary;
        $newSalaryObject = new EmployeeSalary();
        $newSalaryObject->monthly_gross_salary = $grossSalary;

        $newBasicSalary = $newSalaryObject->basic_salary;
        $newHra = $newSalaryObject->hra;
        $newTransportAllowance = $newSalaryObject->transport_allowance;
        $otherAllowance = $newSalaryObject->other_allowance;
        $newEmployeeShare = $newSalaryObject->employee_epf + $newSalaryObject->edli_charges + $newSalaryObject->administration_charges;
        $newAnnualCTC = $newSalaryObject->ctc_annual;
        $totalHealthInsurance = $newSalaryObject->health_insurance * (optional($employee->user->profile)->insurance_tenants ?? 1);
        $monthlyHealthInsurance = $totalHealthInsurance / 12;
        $newAggregateCTC = $newSalaryObject->ctc_annual + $totalHealthInsurance;
        $currentAnnualCTC = $employee->getLatestSalary($employee->payroll_type)->ctc_annual;
        $salaryIncreasePercentage = $this->getLatestSalaryPercentageIncrementAttribute($currentAnnualCTC, $newAggregateCTC);
        $employeeUserId = $employee->user_id;
        // if ($request->signature) {
        //     $imageData = file_get_contents($request->signature);
        // }
        $userProfile = UserProfile::where('user_id', $employeeUserId)->first();
        if ($userProfile) {
            $address = $userProfile->address;
        }

        $data = (object) [
            'employeeName' => $employeeName,
            'employeeFirstName' => $employeeFirstName,
            'date' => $currentDate,
            'grossSalary' => $grossSalary,
            'monthlyHealthInsurance' => $monthlyHealthInsurance,
            'commencementDate' => $commencementDate,
            'basicSalary' => $newBasicSalary,
            'hra' => $newHra,
            'tranportAllowance' => $newTransportAllowance,
            'otherAllowance' => $otherAllowance,
            'employeeShare' => $newEmployeeShare,
            'annualCTC' => $newAnnualCTC,
            'ctcAggregated' => $newAggregateCTC,
            'previousSalary' => $currentAnnualCTC,
            'salaryIncreasePercentage' => $salaryIncreasePercentage,
            'address' => isset($address) ? $address : null, // Handle the case where $address might not be set
            // 'imageData' => isset($imageData) ? $imageData : null,
        ];

        return $data;
    }

    public function getLatestSalaryPercentageIncrementAttribute($currentAnnualCTC, $newAnnualCTC)
    {
        $currentCtc = $newAnnualCTC;
        $previousCtc = $currentAnnualCTC;

        if ($currentCtc == 0 || $previousCtc == 0) {
            return 0;
        }

        $percentageIncrementInFloat = (($currentCtc - $previousCtc) / $previousCtc) * 100;

        return round($percentageIncrementInFloat, 2);
    }

    public function employeeOtherAllowance($grossSalary)
    {
        return $grossSalary - (int) ceil($this->basicSalary()) - (int) ceil($this->hra()) - (int) $this->salaryConfig->get('transport_allowance')->fixed_amount - (int) $this->salaryConfig->get('food_allowance')->fixed_amount;
    }

    public function employeeSalaryDetails($request, $employee)
    {
        $employeeSalaryDetails = new EmployeeSalary([
            'employee_id' => $employee->id,
            'monthly_gross_salary' => $request->grossSalary,
            'commencement_date' => $request->commencementDate,
        ]);

        return $employeeSalaryDetails;
    }

    public function employeeShare($fetchEmployeeSalarydetails)
    {
        $epfShare = (int) $fetchEmployeeSalarydetails->getEmployeeEpfAttribute();
        $edliShare = (int) $fetchEmployeeSalarydetails->getEdliChargesAttribute();
        $administrationShare = (int) $fetchEmployeeSalarydetails->getAdministrationChargesAttribute();

        $totalShare = $epfShare + $edliShare + $administrationShare;

        return $totalShare;
    }

    public function employeeAnnualCTC($fetchEmployeeSalarydetails)
    {
        $employeeAnnualCTC = (int) $fetchEmployeeSalarydetails->getCtcAnnualAttribute();

        return $employeeAnnualCTC;
    }

    public function employeeDetails($employee)
    {
        $employeeDetails = new Employee([
            'user_id' => $employee->id,
            'name' => $employee->name,
            'staff_type' => 'Employee',
        ]);

        return $employeeDetails;
    }

    public function employeePreviousSalary($employeeDetails)
    {
        $employeePreviousCTC = (int) $employeeDetails->getPreviousSalary();

        return $employeePreviousCTC;
    }

    public function salaryIncreasePercentage($employeeDetails)
    {
        $employeeIncreasePercentage = (int) $employeeDetails->getLatestSalaryPercentageIncrementAttribute();

        return $employeeIncreasePercentage;
    }

    public function getMailDataForAppraisalLetter($request, $employee)
    {
        $employeeName = $employee->name;
        $employeeFirstName = explode(' ', $employeeName)[0];
        $commencementDate = Carbon::parse($request->commencementDate)->format('jS F Y');
        $employeeUserId = $employee->user_id;
        $employeeDetails = User::where('id', $employeeUserId)->first();
        $employeeEmail = $employeeDetails->email;
        $ccEmail = $request->ccemails;

        $data = [
            'employeeName' => $employeeName,
            'employeeFirstName' => $employeeFirstName,
            'commencementDate' => $commencementDate,
            'employeeEmail' => $employeeEmail,
            'ccemails' => $ccEmail,
        ];

        return $data;
    }

    public function getAppraisalLetterPdf($data)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $template = 'appraisal-letter-template';
        $html = view('salary::render.' . $template, compact('data'));
        $pdf->loadHTML($html);

        return $pdf;
    }

    public function getIncrementLetterPdf($data)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $template = 'contractor-increment-letter-template';
        $html = view('salary::render.' . $template, compact('data'));
        $pdf->loadHTML($html);

        return $pdf;
    }

    public function getContractorOnboardingLetterPdf($data)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $template = 'contractor-onboarding-template';
        $html = view('salary::render.' . $template, compact('data'));
        $pdf->loadHTML($html);

        return $pdf;
    }
}
