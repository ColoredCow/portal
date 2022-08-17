<?php

namespace Modules\Prospect\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ModuleChecklist\Entities\NDAMeta;
use Modules\Communication\Entities\CalendarMeeting;
use Modules\ModuleChecklist\Entities\ModuleChecklist;

class Prospect extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prospects';
    protected $dates = ['deleted_at'];
    protected $primarykey = 'prospect_id';
    protected $fillable = ['created_by', 'status', 'assign_to', 'name', 'coming_from', 'coming_from_id', 'brief_info'];

    protected static function booted()
    {
        static::created(function ($prospect) {
            $prospect->syncDefaultChecklist();
        });
    }

    public function contactPersons()
    {
        return $this->hasMany(ProspectContactPerson::class);
    }

    public function requirements()
    {
        return $this->hasMany(ProspectRequirement::class);
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function histories()
    {
        return $this->hasMany(ProspectHistory::class);
    }

    public function checklistStatuses()
    {
        return $this->hasMany(ProspectChecklistStatus::class);
    }

    public function getChecklistCurrentTask($checklistID, $checkListTaskID = null)
    {
        $checkListStatus = $this->checklistStatuses()
            ->where('status', 'pending')
            ->where('module_checklist_id', $checklistID)
            ->first();

        if (! $checkListStatus) {
            return '';
        }

        return $checkListStatus->moduleChecklistTask->name;
    }

    public function isChecklistCompleted($moduleCheckListID)
    {
        $query = $this->checklistStatuses();

        if ($moduleCheckListID) {
            $query->where('module_checklist_id', $moduleCheckListID);
        }

        if (! $query->count()) {
            return false;
        }

        return (clone $query)->where('status', 'pending')->first() ? false : true;
    }

    public function isChecklistInProgress($moduleCheckListID = null)
    {
        $query = $this->checklistStatuses();
        if ($moduleCheckListID) {
            $query->where('module_checklist_id', $moduleCheckListID);
        }

        return $query->where('status', '!=', 'pending')->first() ? true : false;
    }

    public function ndaMeta()
    {
        return $this->belongsToMany(NDAMeta::class, 'prospect_nda_meta', 'prospect_id', 'nda_meta_id');
    }

    public function getCheckListStatus($checkListID)
    {
        if ($this->isChecklistCompleted($checkListID)) {
            return 'completed';
        }

        if ($this->isChecklistInProgress($checkListID)) {
            return 'in-progress';
        }

        return 'pending';
    }

    public function syncDefaultChecklist()
    {
        $moduleChecklist = ModuleChecklist::whereIn('slug', config('prospect.checklist'))
            ->get();

        foreach ($moduleChecklist as $checklist) {
            foreach ($checklist->tasks ?: []  as $task) {
                ProspectChecklistStatus::create([
                    'prospect_id' => $this->id,
                    'module_checklist_id' => $checklist->id,
                    'module_checklist_task_id' => $task->id,
                    'status' => 'pending'
                ]);
            }
        }
    }

    public function calendarMeetings()
    {
        return $this->belongsToMany(CalendarMeeting::class, 'prospect_calendar_meeting', 'prospect_id', 'calendar_meeting_id')->withTimestamps();
    }
}
