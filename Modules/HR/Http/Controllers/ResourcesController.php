<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ResourcesController extends Controller
{
    public function index()
    {
        return view('hr::guidelines-resources.resources');
    }
}
