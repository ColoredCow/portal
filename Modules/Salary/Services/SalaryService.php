<?php

namespace Modules\Salary\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\UserProfile;
use Modules\HR\Entities\HrJobDesignation;
use Modules\Salary\Emails\SendAppraisalLetterMail;
use Modules\Salary\Emails\SendContractorIncrementLetterMail;
use Modules\Salary\Emails\SendContractorOnboardingLetterMail;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\Salary\Entities\SalaryConfiguration;

class SalaryService
{
    public function getDataForEmployeeSalaryPage($employee)
    {
        $salaryConf = new SalaryConfiguration();
        $calculationData = [];
        $employerEpfConf = $salaryConf->formatAll()->get('employer_epf');
        $administrationChargesConf = $salaryConf->formatAll()->get('administration_charges');
        $edliChargesConf = $salaryConf->formatAll()->get('edli_charges');
        $edliChargesLimitConfig = $salaryConf->formatAll()->get('edli_charges_limit');
        $edliChargesLimitConfig = $salaryConf->formatAll()->get('edli_charges_limit');
        $healthInsuranceConf = $salaryConf->formatAll()->get('health_insurance');

        $calculationData['basicSalaryPercentageFactor'] = $salaryConf->basicSalary();
        $calculationData['epfPercentageRate'] = (float) $employerEpfConf->percentage_rate;
        $calculationData['adminChargesPercentageRate'] = (float) $administrationChargesConf->percentage_rate;
        $calculationData['edliChargesPercentageRate'] = (float) $edliChargesConf->percentage_rate;
        $calculationData['edliChargesLimit'] = (float) $edliChargesLimitConfig->fixed_amount;
        $calculationData['insuranceAmount'] = (float) $healthInsuranceConf->fixed_amount;
        $grossSalariesList = [];

        $currentSalary = optional($employee->getCurrentSalary())->monthly_gross_salary;

        if ($employee->payroll_type === 'contractor') {
            $currentSalary = optional($employee->getCurrentSalary())->monthly_fee;
        }

        if ($currentSalary) {
            $grossSalariesList = EmployeeSalary::all()->filter(function ($salary) use ($currentSalary) {
                return $salary->monthly_gross_salary >= $currentSalary;
            })->pluck('monthly_gross_salary')
            ->unique()
            ->sort()
            ->values()
            ->take(7);
        }

        $ctcSuggestions = [];

        foreach ($grossSalariesList as $grossSalary) {
            $tempSalaryObject = new EmployeeSalary;
            $tempSalaryObject->employee_id = $employee->id;
            $tempSalaryObject->monthly_gross_salary = $grossSalary;
            array_push($ctcSuggestions, $tempSalaryObject->ctc_aggregated);
        }

        $data = [
            'employee' => $employee,
            'designations' => HrJobDesignation::all(),
            'ctcSuggestions' => $ctcSuggestions,
            'salaryConfigs' => $salaryConf::formatAll(),
            'grossCalculationData' => json_encode($calculationData),
        ];

        if ($employee->payroll_type === 'contractor') {
            $data['salary'] = $employee->getLatestSalary();
        }

        return $data;
    }

    public function storeOrUpdateSalary($request, $employee)
    {
        $currentSalaryObject = $employee->getLatestSalary();

        if ((! $currentSalaryObject) || $request->submitType == 'send_appraisal_letter') {
            if ($currentSalaryObject) {
                $salaryService = new SalaryCalculationService($request->grossSalary);
                $data = $salaryService->getMailDataForAppraisalLetter($request, $employee);
                $commencementDate = $data['commencementDate'];
                $formattedCommencementDate = Carbon::parse($commencementDate)->format('F Y');

                $appraisalData = $salaryService->appraisalLetterData($request, $employee);
                if ($employee->staff_type === 'Contractor') {
                    $pdf = $salaryService->getContractorOnboardingLetterPdf($appraisalData);
                    Mail::to($data['employeeEmail'])->send(new SendContractorOnboardingLetterMail($data, $pdf->inline($data['employeeName'] . '_Onboarding Letter_' . $formattedCommencementDate . '.pdf'), $formattedCommencementDate));
                } else {
                    $pdf = $salaryService->getAppraisalLetterPdf($appraisalData);
                    Mail::to($data['employeeEmail'])->send(new SendAppraisalLetterMail($data, $pdf->inline($data['employeeName'] . '_Appraisal Letter_' . $formattedCommencementDate . '.pdf'), $formattedCommencementDate));
                }

                $employee->update([
                    'designation_id' => $request->get('newDesignationId', $employee->designation_id),
                    'staff_type' => 'Employee',
                    'payroll_type' => config('salary.payroll_type.full_time.slug'),
                ]);

                $userProfile = $employee->user->profile;
                if (! $userProfile) {
                    $this->createUserProfileAndUpdate($request, $employee);
                } else {
                    if ($userProfile && $request->newDesignationId) {
                        $userProfile->designation = HrJobDesignation::find($request->newDesignationId)->slug;
                    }
                    $userProfile->date_of_birth = $request->date_of_birth;
                    $userProfile->save();
                }
            }

            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'monthly_gross_salary' => $request->grossSalary,
                'monthly_fee' => $request->contractorFee,
                'tds' => $request->tds,
                'commencement_date' => $request->commencementDate,
                'old_designation_id' => optional($currentSalaryObject)->new_designation_id,
                'new_designation_id' => $request->get('newDesignationId', $employee->designation_id),
            ]);

            return 'Salary added successfully!';
        }

        if ($currentSalaryObject == null) {
            return redirect()->back();
        }

        $currentSalaryObject->monthly_gross_salary = $request->grossSalary;
        $currentSalaryObject->commencement_date = $request->commencementDate;
        $currentSalaryObject->tds = $request->tds;
        $currentSalaryObject->save();

        return 'Salary updated successfully!';
    }

    public function storeOrUpdateContractorSalary($request, $employee)
    {
        $currentSalaryObject = $employee->getLatestSalary();
        if ((! $currentSalaryObject) || $request->submitType == 'send_contractor_increment_letter') {
            if ($currentSalaryObject) {
                $salaryService = new SalaryCalculationService($request->grossSalary);
                $data = $salaryService->getMailDataForAppraisalLetter($request, $employee);
                $commencementDate = $data['commencementDate'];
                $formattedCommencementDate = Carbon::parse($commencementDate)->format('F Y');
                $appraisalData = $salaryService->appraisalLetterData($request, $employee);
                $pdf = $salaryService->getIncrementLetterPdf($appraisalData);
                Mail::to($data['employeeEmail'])->send(new SendContractorIncrementLetterMail($data, $pdf->inline($data['employeeName'] . '_Increment Letter_' . $formattedCommencementDate . '.pdf'), $formattedCommencementDate));
            }

            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'monthly_fee' => $request->contractorFee,
                'tds' => $request->tds,
                'commencement_date' => $request->commencementDate,
                'salary_type' => config('salary.type.contractor_fee.slug'),
                'old_designation_id' => optional($currentSalaryObject)->new_designation_id,
                'new_designation_id' => $request->get('newDesignationId', $employee->designation_id),
            ]);

            return 'Contractor fee added successfully!';
        }

        $currentSalaryObject->monthly_fee = $request->contractorFee;
        $currentSalaryObject->commencement_date = $request->commencementDate;
        $currentSalaryObject->tds = $request->tds;
        $currentSalaryObject->save();

        $userProfile = $employee->user->profile;
        if (! $userProfile) {
            $this->createUserProfileAndUpdate($request, $employee);
        }

        return 'Contractor fee updated successfully!';
    }

    public function createUserProfileAndUpdate($request, $employee)
    {
        $userProfile = new UserProfile();
        $userProfile->user_id = $employee->user->id;

        if ($request->date_of_birth) {
            $userProfile->date_of_birth = $request->date_of_birth;
        }
        if ($request->newDesignationId) {
            $userProfile->designation = HrJobDesignation::find($request->newDesignationId)->slug;
        }

        $userProfile->save();
    }
}
