<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OperationsController extends Controller
{
    public function index()
    {
        $data = ['name' => 'John'];

        return view('operations::office-location.coming_soon', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }
    
    public function destroy($id)
    {
    }
}
