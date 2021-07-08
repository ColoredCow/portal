<?php

namespace Modules\ModuleChecklist\Entities;

use Illuminate\Database\Eloquent\Model;

class ModuleChecklist extends Model
{
    protected $fillable = [];

    public function tasks()
    {
        return $this->hasMany(ModuleChecklistTask::class);
    }
}
