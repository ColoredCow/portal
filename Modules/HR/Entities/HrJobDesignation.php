<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class HrJobDesignation extends Model
{
    protected $table = 'hr_job_designation';

    protected $guarded = [];

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
