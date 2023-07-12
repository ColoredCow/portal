<?php

namespace Modules\Session\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SessionController extends Controller
{
    public function index()
    {
        return view('session::index');
    }

    public function create()
    {
        return view('session::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('session::show');
    }

    public function edit($id)
    {
        return view('session::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
