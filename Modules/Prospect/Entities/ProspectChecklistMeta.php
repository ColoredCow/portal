<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;

class ProspectChecklistMeta extends Model
{
    protected $fillable = ['prospect_id', 'checklist_id',  'checklist_task_id', 'meta_key', 'meta_value'];

    protected $table = 'prospect_checklist_meta';

    public function getMetaValueAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function getCheckListTaskStatus($prospectID, $checkListID, $checkListTaskID)
    {
        $defaultStatus = 'Pending';
        $row = self::where([
            'prospect_id' => $prospectID,
            'checklist_id' => $checkListID,
            'checklist_task_id' => $checkListTaskID,
            'meta_key' => 'status',
        ])->first();

        return $row ? $row->meta_value : $defaultStatus;
    }
}
