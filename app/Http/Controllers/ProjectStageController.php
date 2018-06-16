<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\ProjectStageRequest;
use App\Models\ProjectStage;
use App\Models\ProjectStageBilling;

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
        $validated = $request->validated();
        $stage = ProjectStage::create([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'cost' => $validated['cost'],
            'type' => $validated['type'],
            'start_date' => $validated['start_date'] ? DateHelper::formatDateToSave($validated['start_date']) : null,
            'end_date' => $validated['end_date'] ? DateHelper::formatDateToSave($validated['end_date']) : null,
            'currency_cost' => $validated['currency_cost'],
            'cost_include_gst' => isset($validated['cost_include_gst']) && $validated['cost_include_gst'] ? true : false,
        ]);

        if (isset($validated['new_billing'])) {
            foreach ($validated['new_billing'] as $percentage) {
                if (!$percentage) {
                    continue;
                }
                ProjectStageBilling::create([
                    'project_stage_id' => $stage->id,
                    'percentage' => $percentage,
                ]);
            }
        } else {
            ProjectStageBilling::create([
                'project_stage_id' => $stage->id,
                'percentage' => 100,
            ]);
        }

        return redirect()->back()->with('status', 'Stage created successfully!');
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
            'type' => $validated['type'],
            'start_date' => $validated['start_date'] ? DateHelper::formatDateToSave($validated['start_date']) : null,
            'end_date' => $validated['end_date'] ? DateHelper::formatDateToSave($validated['end_date']) : null,
            'cost' => $validated['cost'],
            'currency_cost' => $validated['currency_cost'],
            'cost_include_gst' => isset($validated['cost_include_gst']) && $validated['cost_include_gst'] ? true : false,
        ]);

        if (isset($validated['billing'])) {
            foreach ($validated['billing'] as $billing) {
                foreach ($billing as $billing_id => $percentage) {
                    if (!$percentage) {
                        continue;
                    }
                    ProjectStageBilling::where('id', $billing_id)
                    ->update([
                        'percentage' => $percentage,
                    ]);
                }
            }
        }
        if (isset($validated['new_billing'])) {
            foreach ($validated['new_billing'] as $percentage) {
                if (!$percentage) {
                    continue;
                }
                ProjectStageBilling::create([
                    'project_stage_id' => $stage->id,
                    'percentage' => $percentage,
                ]);
            }
        }

        return redirect()->back()->with('status', 'Stage updated successfully!');
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
