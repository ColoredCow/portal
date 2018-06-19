<?php

namespace App\Http\Controllers\HR\Employees;

use App\Http\Controllers\Controller;
use App\User;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = User::employees()->orderBy('name')->get();
        return view('hr.employees.index', compact('team'));
    }
}
