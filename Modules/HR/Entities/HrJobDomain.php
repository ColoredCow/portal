<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class HrJobDomain extends Model
{
    protected $table = 'hr_job_domains';

    protected $guarded = [];

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function designations()
    {
        return $this->hasMany(HrJobDesignation::class);
    }
}
