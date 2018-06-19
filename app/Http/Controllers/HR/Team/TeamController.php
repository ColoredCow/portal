<?php

namespace App\Http\Controllers\HR\Team;

use App\Http\Controllers\Controller;
use App\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = User::team()->get();
        return view('hr.team.index', compact('team'));
    }
}
