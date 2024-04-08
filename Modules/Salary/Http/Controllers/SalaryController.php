<?php

namespace Modules\Salary\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\App;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\Salary\Entities\SalaryConfiguration;
use Carbon\Carbon;
use Modules\Salary\Services\SalaryCalculationService;
use Illuminate\Support\Facades\Mail;
use Modules\Salary\Emails\SendAppraisalLetterMail;

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
        $salaryConfigs = SalaryConfiguration::formatAll();

        return view('salary::employee.index')->with([
            'employee' => $employee,
            'salaryConfigs' => $salaryConfigs,
        ]);
    }

    public function storeOrUpdateSalary(Request $request, Employee $employee)
    {
        $currentSalaryObject = $employee->getCurrentSalary();

        if (! $currentSalaryObject || $request->submitType == 'Save as Increment') {
            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'monthly_gross_salary' => $request->grossSalary,
                'commencement_date' => $request->commencementDate,
            ]);

            return redirect()->back()->with('success', 'Salary added successfully!');
        }

        if ($currentSalaryObject == null) {
            return redirect()->back();
        }

        $currentSalaryObject->monthly_gross_salary = $request->grossSalary;
        $currentSalaryObject->commencement_date = $request->commencementDate;
        $currentSalaryObject->save();

        Mail::to('jyoti.srivastava@coloredcow.com')->send(new SendAppraisalLetterMail($employee));

        return redirect()->back()->with('success', 'Gross Salary saved successfully!');
    }

    public function generateAppraisalLetter(Request $request, Employee $employee){
        $salaryService = new SalaryCalculationService($request->grossSalary);
        $data = $salaryService->appraisalLetterData($request, $employee);
        $employeeName = $data->employeeName;
        $pdf = $this->showAppraisalLetterPdf($data);
        return $pdf->inline($employeeName . '.pdf');
    }


    public function showAppraisalLetterPdf($data){
        $pdf = App::make('snappy.pdf.wrapper');
        $template = 'appraisal-letter-template';
        $html = view('salary::render.' . $template, compact('data'));
        $pdf->loadHTML($html);
        return $pdf;
    }

}
