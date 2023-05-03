<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class CodeTrekApplicants extends Controller
{
    public function index()
{
    $applicants = CodeTrekApplicant::all();
    return view('home')->with('applicants', $applicants);
}

}
