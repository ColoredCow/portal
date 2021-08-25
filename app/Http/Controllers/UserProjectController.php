<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserProjectController extends Controller
{
    public function index()
    {
        $user_projects = Auth::user()->projects;

        return $user_projects;
    }
}
