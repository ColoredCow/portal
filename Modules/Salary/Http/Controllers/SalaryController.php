<?php

namespace Modules\Salary\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Employee;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\Salary\Services\SalaryCalculationService;
use Modules\Salary\Services\SalaryService;

class SalaryController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct()
    {
        $this->authorizeResource(EmployeeSalary::class);
        $this->service = new SalaryService;
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

        $data = $this->service->getDataForEmployeeSalaryPage($employee);

        if ($employee->payroll_type === 'contractor') {
            return view('salary::employee.contractor-index')->with($data);
        }

        return view('salary::employee.index')->with($data);
    }

    public function storeOrUpdateSalary(Request $request, Employee $employee)
    {
        $message = $this->service->storeOrUpdateSalary($request, $employee);

        return redirect()->back()->with('success', $message);
    }

    public function storeOrUpdateContractorSalary(Request $request, Employee $employee)
    {
        $message = $this->service->storeOrUpdateContractorSalary($request, $employee);

        return redirect()->back()->with('success', $message);
    }

    public function generateAppraisalLetter(Request $request, Employee $employee)
    {
        $salaryService = new SalaryCalculationService($request->grossSalary);
        if ($request->submitType === 'send_contractor_increment_letter') {
            $pdf = $salaryService->getIncrementLetterPdf($request->all());

            return $pdf->inline($employee->user->name . '_Increment Letter_' . Carbon::parse($request->commencementDate)->format('jS F Y') . '.pdf');
        } elseif ($employee->payroll_type === 'contractor') {
            $pdf = $salaryService->getContractorOnboardingLetterPdf($request->all());

            return $pdf->inline($employee->user->name . '_Onboarding Letter_' . Carbon::parse($request->commencementDate)->format('jS F Y') . '.pdf');
        }

        $data = $salaryService->appraisalLetterData($request, $employee);
        $employeeName = $data->employeeName;
        $commencementDate = $data->commencementDate;
        $date = Carbon::parse($commencementDate);
        $commencementDateFormat = $date->format('F Y');
        $pdf = $salaryService->getAppraisalLetterPdf($data);

        return $pdf->inline($employeeName . '_Appraisal Letter_' . $commencementDateFormat . '.pdf');
    }
}
