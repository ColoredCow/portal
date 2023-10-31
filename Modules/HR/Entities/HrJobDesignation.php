<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HR\Database\Factories\HrJobDesignationFactory;

class HrJobDesignation extends Model
{

    use HasFactory;

    protected $table = 'hr_job_designation';

    protected $guarded = [];

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    protected static function newFactory()
    {
        return new HrJobDesignationFactory();
    }
}
