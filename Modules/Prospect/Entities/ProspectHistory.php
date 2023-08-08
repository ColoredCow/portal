<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Prospect\Entities\Scopes\ProspectHistoryGlobalScope;
use Modules\User\Entities\User;

class ProspectHistory extends Model
{
    protected $fillable = ['created_by', 'prospect_stage_id', 'prospect_id', 'description'];

    protected $appends = ['performed_on', 'performed_by', 'performed_as'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function prospectStage()
    {
        return $this->belongsTo(ProspectStage::class);
    }

    public function getPerformedOnAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function getPerformedByAttribute()
    {
        return $this->createdBy->name;
    }

    public function getPerformedAsAttribute()
    {
        return optional($this->prospectStage)->name ?? '';
    }

    public function documents()
    {
        return $this->hasMany(ProspectDocument::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ProspectHistoryGlobalScope);
    }
}
