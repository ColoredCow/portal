<?php

namespace Modules\Salary\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\Employee;
use Modules\Salary\Emails\SendAppraisalLetterMail;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\Salary\Entities\SalaryConfiguration;
use Modules\Salary\Services\SalaryCalculationService;

class SalaryController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(EmployeeSalary::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('salary::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function employee(Employee $employee)
    {
        $this->authorize('view', EmployeeSalary::class);
        $salaryConf = new SalaryConfiguration();
        $calculationData = [];
        $employerEpfConf = $salaryConf->formatAll()->get('employer_epf');
        $administrationChargesConf = $salaryConf->formatAll()->get('administration_charges');
        $edliChargesConf = $salaryConf->formatAll()->get('edli_charges');
        $edliChargesLimitConfig = $salaryConf->formatAll()->get('edli_charges_limit');
        $edliChargesLimitConfig = $salaryConf->formatAll()->get('edli_charges_limit');
        $healthInsuranceConf = $salaryConf->formatAll()->get('health_insurance');

        $calculationData["basicSalaryPercentageFactor"] = $salaryConf->basicSalary();
        $calculationData["epfPercentageRate"] = (float) $employerEpfConf->percentage_rate;
        $calculationData["adminChargesPercentageRate"] = (float) $administrationChargesConf->percentage_rate;
        $calculationData["edliChargesPercentageRate"] = (float) $edliChargesConf->percentage_rate;
        $calculationData["edliChargesLimit"] = (float) $edliChargesLimitConfig->fixed_amount;
        $calculationData["insuranceAmount"] = (float) $healthInsuranceConf->fixed_amount;

        return view('salary::employee.index')->with([
            'employee' => $employee,
            'salaryConfigs' => $salaryConf::formatAll(),
            'grossCalculationData' => json_encode($calculationData)
        ]);
    }

    public function storeOrUpdateSalary(Request $request, Employee $employee)
    {
        $currentSalaryObject = $employee->getCurrentSalary();
        if ((! $currentSalaryObject) || $request->submitType == 'send_appraisal_letter') {
            if ($currentSalaryObject) {
                $salaryService = new SalaryCalculationService($request->grossSalary);
                $data = $salaryService->getMailDataForAppraisalLetter($request, $employee);
                $commencementDate = $data['commencementDate'];
                $formattedCommencementDate = Carbon::parse($commencementDate)->format('F Y');

                $appraisalData = $salaryService->appraisalLetterData($request, $employee);
                $pdf = $salaryService->getAppraisalLetterPdf($appraisalData);
                Mail::to($data['employeeEmail'])->send(new SendAppraisalLetterMail($data, $pdf->inline($data['employeeName'] . '_Appraisal Letter_' . $formattedCommencementDate . '.pdf'), $formattedCommencementDate));
            }

            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'monthly_gross_salary' => $request->grossSalary,
                'tds' => $request->tds,
                'commencement_date' => $request->commencementDate,
            ]);

            return redirect()->back()->with('success', 'Salary added successfully!');
        }

        if ($currentSalaryObject == null) {
            return redirect()->back();
        }

        $currentSalaryObject->monthly_gross_salary = $request->grossSalary;
        $currentSalaryObject->commencement_date = $request->commencementDate;
        $currentSalaryObject->tds = $request->tds;
        $currentSalaryObject->save();

        return redirect()->back()->with('success', 'Salary updated successfully!');
    }

    public function generateAppraisalLetter(Request $request, Employee $employee)
    {
        $salaryService = new SalaryCalculationService($request->grossSalary);
        $data = $salaryService->appraisalLetterData($request, $employee);
        $employeeName = $data->employeeName;
        $commencementDate = $data->commencementDate;
        $date = Carbon::parse($commencementDate);
        $commencementDateFormat = $date->format('F Y');
        $pdf = $salaryService->getAppraisalLetterPdf($data);

        return $pdf->inline($employeeName . '_Appraisal Letter_' . $commencementDateFormat . '.pdf');
    }
}
