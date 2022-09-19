<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OperationsController extends Controller
{
    public function index()
    {
        return view('operations::index');
    }

    public function create()
    {
        return view('operations::create');
    }
}
