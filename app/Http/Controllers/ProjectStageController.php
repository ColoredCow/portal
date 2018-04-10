<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStageRequest;
use App\Models\ProjectStage;

class ProjectStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectStageRequest  $request
     * @return void
     */
    public function store(ProjectStageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectStage  $stage
     * @return void
     */
    public function show(ProjectStage $stage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectStage  $stage
     * @return void
     */
    public function edit(ProjectStage $stage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectStageRequest  $request
     * @param  \App\Models\ProjectStage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStageRequest $request, ProjectStage $stage)
    {
        $validated = $request->validated();
        $updated = $stage->update([
            'name' => $validated['name'],
            'cost' => $validated['cost'],
            'currency_cost' => $validated['currency_cost'],
            'cost_include_gst' => isset($validated['cost_include_gst']) && $validated['cost_include_gst'] == 'on' ? true : false,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectStage  $stage
     * @return void
     */
    public function destroy(ProjectStage $stage)
    {
        //
    }
}
