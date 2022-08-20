<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Report\Entities\Report;
use Modules\Report\Http\Requests\ReportRequest;

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
     * @param ReportRequest $request
     */
    public function store(ReportRequest $request)
    {
        $validated = $request->validated();
        Report::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'description' => $validated['desc'],
            'url' => $validated['embedded_url'],
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
        $report = Report::find($id);
        $data = compact('report');

        return view('report::edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param ReportRequest $request
     * @param int $id
     */
    public function update(ReportRequest $request, $id)
    {
        $report = Report::find($id);
        $validated = $request->validated();
        $report->name = $validated['name'];
        $report->type = $validated['type'];
        $report->description = $validated['desc'];
        $report->url = $validated['embedded_url'];
        $report->save();

        return redirect('/report');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function delete($id)
    {
        $report = Report::find($id);
        $data = compact('report');
        $report->delete();

        return redirect('/report');
    }
}
