<?php
namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\ProjectStageRequest;
use App\Models\ProjectStage;
use App\Models\ProjectStageBilling;

class ProjectStageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectStageRequest  $request
     */
    public function store(ProjectStageRequest $request)
    {
        $validated = $request->validated();
        $stage = ProjectStage::create([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'cost' => $validated['cost'],
            'type' => $validated['type'],
            'start_date' => isset($validated['start_date']) ? DateHelper::formatDateToSave($validated['start_date']) : null,
            'end_date' => isset($validated['end_date']) ? DateHelper::formatDateToSave($validated['end_date']) : null,
            'currency_cost' => $validated['currency'],
            'cost_include_gst' => isset($validated['cost_include_gst']) && $validated['cost_include_gst'] ? true : false,
        ]);

        if (isset($validated['new_billing'])) {
            foreach ($validated['new_billing'] as $percentage) {
                if (! $percentage) {
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
     * Update the specified resource in storage.
     *
     * @param  ProjectStageRequest  $request
     * @param  ProjectStage  $stage
     */
    public function update(ProjectStageRequest $request, ProjectStage $stage)
    {
        $validated = $request->validated();
        $stage->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'start_date' => $validated['start_date'] ? DateHelper::formatDateToSave($validated['start_date']) : null,
            'end_date' => $validated['end_date'] ? DateHelper::formatDateToSave($validated['end_date']) : null,
            'cost' => $validated['cost'],
            'currency_cost' => $validated['currency'],
            'cost_include_gst' => isset($validated['cost_include_gst']) && $validated['cost_include_gst'] ? true : false,
        ]);

        if (isset($validated['billing'])) {
            foreach ($validated['billing'] as $billing) {
                foreach ($billing as $billing_id => $percentage) {
                    if (! $percentage) {
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
                if (! $percentage) {
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
}
