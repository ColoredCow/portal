<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('task::index');
    }
}
