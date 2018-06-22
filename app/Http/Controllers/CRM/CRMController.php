<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

class CRMController extends Controller
{
    public function index()
    {
        return view('crm.index');
    }
}
