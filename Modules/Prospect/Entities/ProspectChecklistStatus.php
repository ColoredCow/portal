<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ModuleChecklist\Entities\ModuleChecklistTask;

class ProspectChecklistStatus extends Model
{
    protected $fillable = ['prospect_id', 'module_checklist_id', 'module_checklist_task_id', 'status'];

    protected $table = 'prospect_checklist_statuses';

    public static function markCompleted(Prospect $prospect, $checklistID, $checkListTaskID)
    {
        return self::updateOrCreate([
            'prospect_id' => $prospect->id,
            'module_checklist_id' => $checklistID,
            'module_checklist_task_id' => $checkListTaskID,
        ], ['status' => 'completed']);

        //->update('status', 'completed');
    }

    public function moduleChecklistTask()
    {
        return $this->belongsTo(ModuleChecklistTask::class);
    }
}
