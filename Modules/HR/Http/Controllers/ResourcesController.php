<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Routing\Controller;

class ResourcesController extends Controller
{
    public function index()
    {
        return view('hr::guidelines-resources.resources');
    }
}
