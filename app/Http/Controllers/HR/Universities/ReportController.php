<?php

namespace App\Http\Controllers\HR\Universities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('hr.universities.reports');
    }
}
