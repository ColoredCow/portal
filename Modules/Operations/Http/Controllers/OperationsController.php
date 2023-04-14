<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;

class OperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        
        return view('operations::office-location.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store()
    {
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update()
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy()
    {
    }
}
