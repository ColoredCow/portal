<?php

namespace Modules\HR\Entities;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Employee extends Model
{
    protected $guarded = [];

    protected $dates = ['joined_on'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function getEmploymentDurationAttribute()
    {
        if (is_null($this->user_id)) {
            return;
        } else {
            $now = now();

            return ($this->joined_on->diff($now)->days < 1) ? '0 days' : $this->joined_on->diffForHumans($now, true);
        }
    }

    /**
     * Get the projects for the employees.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('contribution_type');
    }
}
