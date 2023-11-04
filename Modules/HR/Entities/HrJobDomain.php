<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrJobDomainFactory;

class HrJobDomain extends Model
{
    use HasFactory;

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

    public static function newFactory()
    {
        return new HrJobDomainFactory();
    }
}
