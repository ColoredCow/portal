<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Entities\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();
        $data = compact('reports');

        return view('report::index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'desc' => 'nullable|string',
            'embedded_url' => 'required',
        ]);
        Report::create([
            'name' => $validator['name'],
            'type' => $validator['type'],
            'description' => $validator['desc'],
            'url' => $validator['embedded_url'],
        ]);

        return back()->with('success', 'Report add successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        $report = Report::find($id);
        $data = compact('report');

        return view('report::show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        //
    }
}
