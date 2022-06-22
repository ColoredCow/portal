<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\HR\Entities\Job;
use Illuminate\Http\Request;


class ResourcesController extends Controller
{
    public function index()
    {
        $jobs = Job::select('title')->get();

        return view('hr::guidelines-resources.index', compact('jobs'));

    }

    public function show()
    {
        return view('hr::guidelines-resources.show');
    }
}
