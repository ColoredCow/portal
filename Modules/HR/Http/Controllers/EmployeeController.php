<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->authorizeResource(Employee::class);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();

        return view('hr.employees.index', $this->service->index($filters));
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', ['employee' => $employee]);
    }

    public function reports()
    {
        $this->authorize('reports');
        return view('hr.employees.reports');
    }
}
